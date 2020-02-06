<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\modules\models\Messages;
use yii\data\Pagination;

class MessagesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['show-messages'],
                'rules' => [
                    [
                        'actions' => ['show-messages'],
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
     * Displays user's messages.
     *
     * 
     */
    public function actionShowMessages()
    {
		//find all messages
		$messagesCount = Messages::find() ->orderBy ('m_id DESC')->where(['m_receiver_id' => Yii::$app->user->identity->id])->all();
		
		//find unread messages from received array
		$unreadCount = 0;
		foreach($messagesCount as $c){
		    if($c->m_status_read == '0'){
				$unreadCount++;
			}				
		}
		
		//LinkPager
		$messages = Messages::find() ->orderBy ('m_id DESC')->where(['m_receiver_id' => Yii::$app->user->identity->id]);//->all();
		$pages= new Pagination(['totalCount' => $messages->count(), 'pageSize' => 9]);
        $modelPageLinker = $messages->offset($pages->offset)->limit($pages->limit)->all();
		
		$messModel = new Messages();

		return $this->render('messages-index', [
		      'messagesCount' => $messagesCount, 
			  'unreadCount' => $unreadCount,
			  'modelPageLinker' => $modelPageLinker, //pageLinker
              'pages' => $pages,      //pageLinker
			  'messModel'  => $messModel
			  
	    ]);
    }

	

	
	//====================================================
    /**
     * Ajax. Change clicked message m_status_read as read, i.e 1
     *
     * 
     */
    public function actionAjaxUpdateReadStatus()
    {
		$messages = Messages::find() ->where(['m_id' => $_POST['serverClickedID']]) ->one();
		$messages->m_status_read = '1'; //read
		$messages->save(false);
		
		//RETURN JSON DATA
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
          return [
             'result_status' => "OK",
          ]; 
		  
	}

		

}
