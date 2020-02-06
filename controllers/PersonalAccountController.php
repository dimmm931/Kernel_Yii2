<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Balance;
use app\modules\models\Messages;

class PersonalAccountController extends Controller
{
	const STATUS_NOT_READ = '0';
	
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
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
            'error' => [//
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
    //====================================================
    /**
     * Displays personal account homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $balance = Balance::find()->orderBy ('balance_id DESC') -> where(['balance_user_id' => Yii::$app->user->identity->id ])->all();
		
        
		return $this->render('index', [
		      'balance' => $balance, 
	    ]);
    }

	
    
	
	
	
	
	
	 //===================================
	 /**
     * Ajax Check and count (via ajax request) if there are any inbox messages (with m_status_read' => 0) 
     * @return json
     */
    public function actionCountInboxMessages()
    {
        $found = Messages::find()->where(['m_status_read' => self::STATUS_NOT_READ])->andWhere(['m_receiver_id' => Yii::$app->user->identity->id]);
		$count = $found->count();
		
		//RETURN JSON DATA
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
          return [
             'result_status' => "OK",
			 'count' => $count ,  
          ]; 
	}
	
	
	
	
	

}
