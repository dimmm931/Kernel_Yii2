<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\TransferRights;
use app\models\User;


class TransferRightsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['transfer-right'],
                'rules' => [
                    [
                        'actions' => ['transfer-right'],
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
     * Application to transfer your product right to other client
     *
     * 
     */
    public function actionTransferRight()
    {
		
		$model = new TransferRights();
		$allUsers = User::find()->orderBy ('id DESC')->all(); //users list for form autocomplete
		
		if ($model->load(Yii::$app->request->post())) {
			if ( $model->save()){
				
				$res1 = $model->checkBalance(Yii::$app->user->identity->id); //this current User balance
				$res2 = $model->checkBalance($model->to_user_id); //2nd User balance, id from form
				
				//++ Add product weight to 2nd User 
				if($res2){
			        //adds and updates with new weight		
			        $model->balanceAdd($res2);
		        } else {
			        //saves new row with product and weight	
			        $model->addNewProduct($res2);
		        }
				
			    //-- deduct from this current User1
			    $model->deductProduct($res1);  
				
				
				$model->sendMessageUser1(); //send the message to current user
				$model->sendMessageUser2(); //send the message to User who obtained new product
				
			    Yii::$app->getSession()->setFlash('statusOK', "Ваш запит на переоформлення зерна виконано. Пiдтвердження у повiдомленнях."); 
			    return $this->refresh();
           } else {
			    //var_dump($model->getErrors());
			    Yii::$app->getSession()->setFlash('statusFail', "Error"); 
		   }
		}
		
		
		return $this->render('trans-right-index', [
		      'model' => $model,
			  'allUsers' => $allUsers,
	    ]);
    }

	


}
