<?php
//displays and handles users' request to load out product
namespace app\modules\controllers;

use Yii;
use app\modules\models\InvoiceLoadIn;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\models\InvoiceLoadOut;
use app\modules\models\InvoiceLoadOut_2_Intervals;
use yii\data\Pagination;
use app\modules\models\InvoiceLoadOut_Just_Admin_Form;
use app\modules\models\Elevators;
//use app\models\User;
//use app\models\ProductName;
//use app\models\Balance;


/**
 * InvoiceLoadOutController implements the CRUD actions for InvoiceLoadIn model.
 */
class InvoiceLoadOutController extends Controller
{
	
	 const STATUS_PENDING = '0';

	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
	
		
	/**
     * any action in this controller is available with users with adminX RBAC
     */
	public function beforeAction($action){
	    if(!Yii::$app->user->can('adminX')){
		    throw new \yii\web\NotFoundHttpException("You have no admin rights. Triggered in beforeAction()");
	    }
        return parent::beforeAction($action); 
	  }
	  
	  

    /**
     * Lists all InvoiceLoadOut requests sent by user. Main page, rest of info is added by ajax.
     * @return mixed
     */
    public function actionIndex()
    {
	    $finalCheckifFree = false;
	    $model = new InvoiceLoadOut_Just_Admin_Form(); //form for admin to add selected date and finilize the user's request.
	    $model_1 = new InvoiceLoadOut();
	   
        $requestsLoadOutCount = InvoiceLoadOut::find()->where(['confirmed_by_admin' => self::STATUS_PENDING]) -> all(); //for counting
	    $allElevators = Elevators::find()->all();
	   
	    //LinkPager (to list all invoices where self::STATUS_PENDING)
	    $query = InvoiceLoadOut::find()->where(['confirmed_by_admin' => self::STATUS_PENDING]);
        $pages= new Pagination(['totalCount' => $query->count(), 'pageSize' => 5]);
        $modelPageLinker = $query->offset($pages->offset)->limit($pages->limit)->all();


	    //save the form and finilize the user's request
	    if ($model->load(Yii::$app->request->post())) {
			//finds the request to LoadOut started by the User, here finilize it by adding date to load, intervals, quarters and elevatpr number
			$thisInvoice = InvoiceLoadOut::find()->where(['id' => $model->id])->one(); //invoice ID, set to hidden form by js/invoice_load_out.js 
			
			//Aditional final check if DATE/TIME is still free (if someone has not taken this time while we were booking)
			if($model_1->checkIfFree_date($model)){
			    Yii::$app->getSession()->setFlash('statusFAIL', "На жаль, за цей час дату вже було зайнято. Оберіть іншую дату.");
                return $this->refresh();				
			} 
			
			//Aditional final check if someone has not edited/proceeded this invouce while we were booking)
			if($model_1->checkIfFreeInvoice($model)){
				Yii::$app->getSession()->setFlash('statusFAIL', "На жаль, за цей час цю накладну вже було опрацьовано. Оберіть іншую накладну.");
                return $this->refresh();				
			}
				
	
			//assign fields from InvoiceLoadOut_Just_Admin_Form form
			//$model_1->assignFields($thisInvoice);
			$thisInvoice->confirmed_by_admin  = '1'; 
			$thisInvoice->confirmed_date_unix = $model->confirmed_date_unix;
			$thisInvoice->date_to_load_out    = $model->date_to_load_out;
			$thisInvoice->b_intervals         = $model->b_intervals;
			$thisInvoice->b_quarters          = $model->b_quarters;
			$thisInvoice->elevator_id         = $model->elevator_id;
			
			if ($thisInvoice ->save(false)){
				$model_1->sendMessage_LoadOut_Confirmed($thisInvoice, $model);
			    Yii::$app->getSession()->setFlash('statusOK', "Заявку успішно опрацьовано. Kористувачу відправленно повідомлення"); 
			    return $this->refresh();
            } else {
			   //var_dump($model->getErrors());
			   Yii::$app->getSession()->setFlash('statusOK', "Error"); 
		    }
		   
		}
		
        return $this->render('load-out-index', [
            'requestsLoadOutCount' => $requestsLoadOutCount,
			'modelPageLinker'      => $modelPageLinker, //pageLinker
            'pages'                => $pages,      //pageLinker
			'model'                =>  $model,  //model for admin form
			'allElevators'         => $allElevators //list of all elevators for dropdown
        ]);
    }

   
	

    /**
     * Works with ajax sent from js/admin/invoice_load_out.js -> method gets data for one selected invoice
     * @return json
     *
     */
    public function actionAjax_get_invoice() 
    {	
	    $invoiceLoadOut = InvoiceLoadOut::find()->where(['id' => $_POST['serveInvoiceLoadOutID']]) -> one();
	  
		//RETURN JSON DATA
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
         return [
            'result_status' => "OK", // return ajx status
            'code' => 100,	 
			'invoiceLoadOut' => $invoiceLoadOut, 
        ]; 
	}

	
	
	
	
    /**
     * Works with ajax sent from js/admin/datepicker_action.js -> method gets Interval list for a selected date, returns all html
     * @return json
     *
     */
    public function actionAjax_get_interval_list() 
    {	
        global $text;
	    $InvoiceLoadOutIntervals = new InvoiceLoadOut_2_Intervals();
		//$InvoiceLoadOutIntervals->test();
	    $dayPost = Yii::$app->request->post('serverSelectedDateUnix'); //$_POST['serverSelectedDateUnix'] from ajax ->js/admin/datepicker_action.js;
		$elevatorPost = Yii::$app->request->post('serverSelectedElevator'); 
		
		//!!!!!!!!! -- change {Where} to between + Where Elevator
		$result = InvoiceLoadOut::find()  
		          ->orderBy ('id ASC') 
		          ->where([ 'date_to_load_out' => (int)$dayPost]) //->andWhere(['between', 'date_to_load_out', $dayPost, $dayPost - 86400 ])  //->where([ 'date_to_load_out' => $dayPost]) 
			      ->andWhere(['elevator_id' => (int)$elevatorPost ]) 
			      ->all(); 
		
        $bIntervals = array();// array for intervals available 
	
	    foreach($result as $ss){
            array_push($bIntervals, $ss->b_intervals);  
        }

        $fixArray = sort($bIntervals);  // sorted in case $bIntervals[7,8,7]
	 
	    //fixing start hour, i.e if u selected today in calendar, it will build intervals from current hour only
	    $that_date  = time(); //unixTime now
        $first_hour = $that_date - ($that_date % (60*60*24)); //unixTime of now at 00:00:00

	    if($dayPost == $first_hour && ( ((date("H") + 1) > 8) || ((date("H") + 1) < 20)) ){ //if current hour is between 8 -20
	       $startHour = date("H") + 1; //start from current hour
	    } else {
		   $startHour = 8;
	    }
	    $start = $startHour;

	    for($i = $start; $i < 20; $i++){
            //if time exists in array  $bIntervals, displays taken
            if(in_array($i, $bIntervals)){ 
			    $indexOf = array_search($i, $bIntervals); // find the indexOf of $i, which exists in array to use {$rowF[$indexOf]['b_booker'].}
			    $Next_i = $indexOf + 1;  //the position of first found +1
			    $t = $i + 1; // next hour
			   
			   
			    if(isset($bIntervals[$Next_i])){
				    $bIntervals[$Next_i] = $bIntervals[$Next_i];
			    } else {
				    $bIntervals[$Next_i] = FALSE;
			    }
			 
			    if($i == $bIntervals[$Next_i]){  //if have duplicate = Reserved/Reserved
			        $InvoiceLoadOutIntervals->DisplayReserved($i, null, $indexOf, $result, '00',  '30'); //1st Row  //DisplayReserved($iterator,$nextIterator,$indexOf,$result,$minutesStart,$minutesEnd)
				    //second row
			        $Next_indexOf = $indexOf + 1; //Take next row from Active Record result
			        $InvoiceLoadOutIntervals->DisplayReserved($i, $t, $indexOf+1, $result, '30',  '00');  //2nd Row //Reserved second Row
			    }
				   
                if($i!= $bIntervals[$Next_i] ){  //if DOES NOT have duplicate
				    if($result[$indexOf]->b_quarters == 0){ // if it is for 9.00-9.30 = Reserved/Free		   
					    $InvoiceLoadOutIntervals->DisplayReserved($i,null,$indexOf,$result, '00',  '30'); //Reserved 1st Row       
				        //second Free Row
					    $InvoiceLoadOutIntervals->DisplayFree($i,$t,"30","00");
				    }
								
								
				    if($result[$indexOf]->b_quarters == 3){ // if it is for 9.30-10.00 = Free/Reserved
				        $InvoiceLoadOutIntervals->DisplayFree($i, null, "00", "30");					      
					    //second Reserved
					    $InvoiceLoadOutIntervals->DisplayReserved($i,$t,$indexOf,$result, '30',  '00');  //2nd Row //Reserved second Row	       
				    }
                }	
			  
			} else {  // End if(in_array($i, $bIntervals))  //if i does not exist in array (i.e it is FREE/FREE)
			    $tt = $i + 1;	
				//1st FREE ROW
                $InvoiceLoadOutIntervals->DisplayFree($i, null, "00", "30");								   			
				//second Fee Row
				$InvoiceLoadOutIntervals->DisplayFree($i, $tt,"30","00");
		    } 
			  
	    } 
	    return $text;
	}
    

}