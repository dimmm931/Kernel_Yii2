<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\modules\models\InvoiceLoadOut;
use app\modules\models\InvoiceLoadIn;
use app\models\TransferRights;
use app\models\HistoryTransaction;

class TransactionsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['mytransations'],
                'rules' => [
                    [
                        'actions' => ['mytransations'],
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
	
	
	
    /**
     * Displays personal history of all transaction.
     *
     * @return string
     */
    public function actionMytransations()
    {
		$model = new HistoryTransaction();
	
		//find transaction for all period (if there is no $_GET['period'])
		if (!Yii::$app->getRequest()->getQueryParam('period')){
		    $query = $model->getAllMonthData();
		}
		
		//find transaction for current month only (if there is $_GET['currentMonth'])
        if (Yii::$app->getRequest()->getQueryParam('period') == "currentMonth"){
	        $query = $model->getCurrentMonthData();			
		}
		 
		//find transaction for previous month only (if there is $_GET['lastMonth'])
        if (Yii::$app->getRequest()->getQueryParam('period') == "lastMonth"){
			$query = $model->getPreviousMonthData();
		}
		 
		//find transaction for last 6 month (if there is $_GET['last_6_Month'])
        if (Yii::$app->getRequest()->getQueryParam('period') == "last_6_Month"){
			$query = $model->getLast_6MonthMonthData();
		}
		 
		//merge results to 1 array
		$queryTemp = array_merge($query[0], $query[1], $query[2]);
		 
		//sort merged array by unixTime from 3 arrays (InvoiceLoadOut::date_to_load_out/InvoiceLoadIn::unix, TransferRights::unix_time)
		$query1 = $model->sortArrayByUnix($queryTemp);
		 	   		
		return $this->render('transactions-index', [
		      'query' => $query1, 
	    ]);
    }

}
