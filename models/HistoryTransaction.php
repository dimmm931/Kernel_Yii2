<?php
namespace app\models;

use Yii;
use app\modules\models\InvoiceLoadOut;
use app\modules\models\InvoiceLoadIn;
use app\models\TransferRights;

/**
 * This is the model class for many tables".
 *
 */
 
class HistoryTransaction extends \yii\db\ActiveRecord
{

    /**
     * find transaction for all period (if there is no $_GET['period'])
     * @return array
     */
    public function getAllMonthData()
	{
        $query1 = InvoiceLoadOut::find()->orderBy ('id ASC')->where(['user_id' => Yii::$app->user->identity->id])->all(); 
		$query2 = InvoiceLoadIn::find() ->orderBy ('id ASC')->where(['user_kontagent_id' => Yii::$app->user->identity->id])->all(); 
	    $query3 = TransferRights::find()->orderBy ('id ASC')->where(['from_user_id' => Yii::$app->user->identity->id])->orWhere(['to_user_id' => Yii::$app->user->identity->id])->all();    
		return array($query1, $query2, $query3);
	}

	
	
	
    /**
     * find transaction for current month only (if there is $_GET['currentMonth'])
     * @return array
     */
	public function getCurrentMonthData()
	{
		$query1 = InvoiceLoadOut::find()->orderBy ('id ASC')->where(['user_id' => Yii::$app->user->identity->id])
			         ->andWhere(['between', 'user_date_unix', strtotime(date('Y-m-01 00:00:00')), time() ])  //time()->current Unix, strtotime(date('Y-m-01 00:00:00')) -> unix of first day of current month
			         ->all(); 
				 
		$query2 = InvoiceLoadIn::find() ->orderBy ('id ASC')->where(['user_kontagent_id' => Yii::$app->user->identity->id])
			        ->andWhere(['between', 'unix', strtotime(date('Y-m-01 00:00:00')), time() ])  
			        ->all(); 
					
		$query3 = TransferRights::find() ->orderBy ('id ASC')->where(['from_user_id' => Yii::$app->user->identity->id])->orWhere(['to_user_id' => Yii::$app->user->identity->id])
			        ->andWhere(['between', 'unix_time', strtotime(date('Y-m-01 00:00:00')), time() ])  
			        ->all();
		return array($query1, $query2, $query3);
	}
	
	
	
	
    /**
     * find transaction for previous month only (if there is $_GET['lastMonth'])
     * @return array
     */
    public function getPreviousMonthData()
	{
		$startLastMonth = mktime(0, 0, 0, date("m") - 1, 1, date("Y")); //Unix of 1st day of last month
        $endLastMonth   = mktime(0, 0, 0, date("m"), 0, date("Y"));       //Unix of 1ast day of last month

		$query1 = InvoiceLoadOut::find()->orderBy ('id ASC')->where(['user_id' => Yii::$app->user->identity->id])
			         ->andWhere(['between', 'user_date_unix', $startLastMonth, $endLastMonth  ])  
			         ->all(); 
				 
		$query2 = InvoiceLoadIn::find() ->orderBy ('id ASC')->where(['user_kontagent_id' => Yii::$app->user->identity->id])
			        ->andWhere(['between', 'unix', $startLastMonth, $endLastMonth  ])  
			        ->all(); 
					
		$query3= TransferRights::find() ->orderBy ('id ASC')->where(['from_user_id' => Yii::$app->user->identity->id])->orWhere(['to_user_id' => Yii::$app->user->identity->id])
			        ->andWhere(['between', 'unix_time', $startLastMonth, $endLastMonth  ])  
			        ->all(); 
		return array($query1, $query2, $query3);
		
	}
	
	
	
    	
    /**
     * find transaction for last 6 month (if there is $_GET['last_6_Month'])
     * @return array
     */
    public function getLast_6MonthMonthData()
	{
		$startLastMonth = mktime(0, 0, 0, date("m") - 6, 1, date("Y")); //Unix of 1st day of the  month -6

		$query1 = InvoiceLoadOut::find()->orderBy ('id ASC')->where(['user_id' => Yii::$app->user->identity->id])
			         ->andWhere(['between', 'user_date_unix', $startLastMonth, time() ])  
			         ->all(); 
				 
		$query2 = InvoiceLoadIn::find() ->orderBy ('id ASC')->where(['user_kontagent_id' => Yii::$app->user->identity->id])
			        ->andWhere(['between', 'unix', $startLastMonth, time() ])  
			        ->all(); 
					
	    $query3 = TransferRights::find() ->orderBy ('id ASC')->where(['from_user_id' => Yii::$app->user->identity->id])->orWhere(['to_user_id' => Yii::$app->user->identity->id])
			        ->andWhere(['between', 'unix_time', $startLastMonth, time() ])  
			        ->all(); 
		return array($query1, $query2, $query3);
	}
	
	
	
	
    
   /**
    * sort 3 merged arrays by ascending UnixTime values
    * @return array
    */
    function sortArrayByUnix($queryTemp)
	{
		//sort merged array by unixTime from 3 arrays (InvoiceLoadOut::date_to_load_out/InvoiceLoadIn::unix, TransferRights::unix_time)
		$query = array();
		for($i = 0; $i < count($queryTemp); $i++){
			
			for($j =$i + 1; $j < count($queryTemp)/* - $i*/; $j++){
				
				if($queryTemp[$i] instanceof InvoiceLoadOut) {
				   $key = 'user_date_unix'; //'date_to_load_out';
				
                } else if ($queryTemp[$i] instanceof TransferRights) { 			
					$key = 'unix_time';
				
                } else if ($queryTemp[$i] instanceof InvoiceLoadIn) {				
				    $key = 'unix';
			    }
				
			    if(isset($queryTemp[$j]['user_id'])){ //if it is from {invoice_load_out DB}
				    $key2 = 'user_date_unix'; //'date_to_load_out';
			   } else if (isset($queryTemp[$j]['from_user_id'])) {  //if it is from {transfer_rights DB}
					$key2 = 'unix_time';
				} else { //if it is from {invoice_load_in DB}
				    $key2 = 'unix';
			    }
			
				if(isset($queryTemp[$i][$key]) && isset($queryTemp[$j][$key2])){
				    if( $queryTemp[$i][$key] > $queryTemp[$j][$key2] ){
					    $max = $queryTemp[$i];
					    $queryTemp[$i] = $queryTemp[$j];
					    $queryTemp[$j] = $max;
				     }
				}
			} 
		}
	   
	   $query = array_reverse($queryTemp); //new comes first
	   return $query;
		
	}
	
}