<?php

namespace app\modules\controllers;

use Yii;
use app\modules\models\InvoiceLoadIn;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\ProductName;
use app\modules\models\Elevators;
use app\models\Balance;


/**
 * InvoiceLoadInController implements the CRUD actions for InvoiceLoadIn model.
 */
class InvoiceLoadInController extends Controller
{
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
     * Lists all InvoiceLoadIn models.
     * @return mixed
     */
    public function actionIndex()
    {
		
        $dataProvider = new ActiveDataProvider([
            'query' => InvoiceLoadIn::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InvoiceLoadIn model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	
	
	//=================================
    /**
     * Creates a new InvoiceLoadIn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InvoiceLoadIn();
		
		$allUsers = User::find()->orderBy ('id DESC')->all(); //users list for form autocomplete
		$products = ProductName::find()->all(); 
		$elevators = Elevators::find()->all(); //elevators for form dropdown
		
		//$model->invoice_id = Yii::$app->security->generateRandomString(5). "-" . time(); //invoiceID to form 
		//$model->unix = time();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$res = $model->checkBalance();
			
			if($res){
			  //adds and updates with new weigth if product was already on balance		
			  $model->balanceAdd($res);
		    } else {
			  //saves new row with product and weigth if product was was not on balance	yet	
			  $model->addNewProduct();
		    }
			
			
		    $model->sendMessage(); //notify the user
			
            //return $this->redirect(['view', 'id' => $model->id]);
			Yii::$app->getSession()->setFlash('OK', "Накладну збережено. {$model->products->pr_name_name} :  {$model->product_wight} кг.");
			return $this->refresh();
        }

        return $this->render('create', [
            'model' => $model,
			'allUsers' => $allUsers,
			'products' => $products,
			'elevators' => $elevators
        ]);
    }

    /**
     * Updates an existing InvoiceLoadIn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing InvoiceLoadIn model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InvoiceLoadIn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InvoiceLoadIn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InvoiceLoadIn::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
