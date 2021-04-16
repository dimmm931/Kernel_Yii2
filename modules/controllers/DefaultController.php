<?php

namespace app\modules\controllers;

use yii\web\Controller;
use Yii;
use app\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
	
	
	/**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['admin-panel'],
                'rules' => [
                    [
                        'actions' => ['admin-panel'],
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
     * Renders the index view for the module-> Login form
     * @return string
     */
    public function actionIndex()
    {
		if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/admin/admin-x/admin-panel']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
			return $this->redirect(['/admin/admin-x/admin-panel']);
        }

        $model->password = '';
		
        return $this->render('index', [
		      'model' => $model, 
	    ]);
    }
	
}
