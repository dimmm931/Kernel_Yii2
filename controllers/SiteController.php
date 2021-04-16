<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\SignupForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
     * Displays homepage.
     * @return string
     * 
     */
    public function actionIndex()
    {
  
		if(!Yii::$app->user->isGuest){ 
		    return $this->redirect(['personal-account/index']);
		}
		$this->layout = 'mainHome'; //layout with NO navbar menu
        return $this->render('index');
    }

    /**
     * Login action.
     * @return Response|string
     * 
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     * @return Response
     * 
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     * @return Response|string
     * 
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     * @return string
     * 
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
	
	
     /**
     * Displays registration page
     * @return Response|string
     * 
     */
	public function actionSignup()
    {
        $model = new SignupForm();
 
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {

				Yii::$app->getSession()->setFlash('warnX1', "Ви були успішно зареєстровані. Очікуйте на підтвердження реєстрації адміністратором. Ви отримаєте повідомлення на email, вказаний при реєстрації і після цього зможете заходтити до особистого кабінету.");
                return $this->goHome();				
            } else {
				Yii::$app->getSession()->setFlash('warnX', "Помилка реєстрації!!! Перевірте Ваші дані."); 
			}
        }
 
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

}
