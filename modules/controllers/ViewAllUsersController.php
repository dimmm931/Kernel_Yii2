<?php
namespace app\modules\controllers;

use yii\web\Controller;
use Yii;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Balance;
use app\modules\models\ViewAllUsers;

/**
 * View all users
 */
class ViewAllUsersController extends Controller
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
     * any action in this controller is available with users with adminX RBAC
     *
     */
	public function beforeAction($action)
    {
	    if(!Yii::$app->user->can('adminX')){
		    throw new \yii\web\NotFoundHttpException("You have no admin rights.");
	    }
        return parent::beforeAction($action); 
	}
	

	/**
     * Renders the main viewUsers page
     * @return string
     *
     */
    public function actionIndex()
    {
	    $allUsers = User::find()->orderBy ('id DESC')->all(); //users list for form autocomplete
		
        return $this->render('view-all', [
            'allUsers' => $allUsers,
        ]);
    }
	
	
	
	/**
     * Renders single User page view with info, balance, history
     * @return string
     *
     */
    public function actionSingleUserView($user_id)
    {
	    $oneUser = User::find()->where(['id' => $user_id])->one();
		$balance = Balance::find()->orderBy ('balance_id DESC') -> where(['balance_user_id' => $user_id ])->all();
		
		$model = new ViewAllUsers();
		//find transaction for last user
		$query = $model->getAllHistoryData($user_id);

		//merge results to 1 array
		$queryTemp = array_merge($query[0], $query[1], $query[2]);
		 
		//sort merged array by unixTime from 3 arrays (InvoiceLoadOut::date_to_load_out/InvoiceLoadIn::unix, TransferRights::unix_time)
		$query = $model->sortArrayByUnix($queryTemp);
		 
        return $this->render('view-one-user', [
            'oneUser'  => $oneUser,
			'balance'  => $balance,
			'query'    => $query,
        ]);
    }	
	
}
