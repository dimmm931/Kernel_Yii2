<?php

namespace app\modules\controllers;

use yii\web\Controller;
use Yii;
use app\models\LoginForm;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\models\RegisterRequest_InputModel;
use app\models\ProductName;
use app\models\Balance;
use app\modules\models\InvoiceLoadOut;

/**
 * Default controller for the `admin` module
 */
class AdminXController extends Controller
{
	 const STATUS_PENDING = '0';
	
	/**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['admin-panel'], //'admin-panel'
                'rules' => [
                    [
                        'actions' => ['admin-panel'], //'admin-panel'
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
	
	
	
	
	/**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
	/**
     * any action in this controller is available with users with adminX RBAC
     */
	public function beforeAction($action){
		
		if (Yii::$app->user->isGuest) {
           //return $this->redirect(['/site/login']);
		   throw new \yii\web\NotFoundHttpException("Please log-in first.");
        }
		
	    if(!Yii::$app->user->can('adminX')){
		    throw new \yii\web\NotFoundHttpException("You have no admin rights.");
	    }
        return parent::beforeAction($action); 
	  }
	  
	
	
	
	
	 //===================================
	 /**
     * Renders the admin personal account/main page
     * @return string
     */
    public function actionAdminPanel()
    {

	    $userCount = User::find();
		$products = ProductName::find()->all();
		$balance = Balance::find()->all();
		
        return $this->render('admin-panel', [
            'userCount' => $userCount,
			'products' =>  $products ,
			'balance' => $balance
        ]);
    }
	
	
	
	
	
	 //===================================
	 /**
     * Ajax Check and count (via ajax request) if there are any users' registration requests (with status = 10) 
     * @return json
     */
    public function actionCountRegisterRequests()
    {
        $found = User::find()->where(['status' => 9]);
		$count = $found->count();
		
		//RETURN JSON DATA
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
          return [
             'result_status' => "OK",
			 'count' => $count ,  
          ]; 
        
    }
	
	
	
		 //===================================
	 /**
     * Ajax Check and count (via ajax request) if there are any users' load-out requests (with where(['confirmed_by_admin' => self::STATUS_PENDING])) STATUS_PENDING == 0
     * @return json
     */
    public function actionCountLoadOutRequests()
    {
        $found = InvoiceLoadOut::find()->where(['confirmed_by_admin' => self::STATUS_PENDING]);
		$count = $found->count();
		
		//RETURN JSON DATA
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
          return [
             'result_status' => "OK",
			 'count' => $count ,  
          ]; 
        
    }
	
	
	
	
	 //===================================
	 /**
     * Renders the page to view (approve/reject) users' registration requests
     * @return string
     */
    public function actionUsersRegistrationRequests()
    {
		
		
		$model = new RegisterRequest_InputModel();
		
		if ($model->load(\Yii::$app->request->post()) ) {
			$customer = User::find()->where(['id' => $model->yourInput])->one();
			$customer->status = 10;
			if($customer->save()){
				Yii::$app->getSession()->setFlash('approveOK', "You successfully approved new user" . $model->yourInputEmail);
				$model->yourInput ='';
				return $this->refresh();
			}
		}
		
		$requests = User::find()->where(['status' => 9])->all();
		
        return $this->render('users-registration-requests', [
		      'requests' => $requests, 
			  'model' => $model, 
	    ]);
    }
	
	
	
	
	
	
}
