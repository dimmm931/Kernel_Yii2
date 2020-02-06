<?php

namespace app\modules\models;

use Yii;
use yii\base\Model;
use app\modules\models\InvoiceLoadOut;
use app\modules\models\InvoiceLoadIn;
use app\models\TransferRights;

/**
 * 
 *  
 * 
 *
 *
 */
 
class ViewAllUsers extends Model
{
	
    /**
     * @inheritdoc
     */
   public function getAllHistoryData($id)
   {
	   $query1 = InvoiceLoadOut::find()->orderBy ('id ASC')->where(['user_id' => $id])->all(); 
	   $query2 = InvoiceLoadIn::find() ->orderBy ('id ASC')->where(['user_kontagent_id' => $id])->all(); 
	   $query3 = TransferRights::find()->orderBy ('id ASC')->where(['from_user_id' => $id])->orWhere(['to_user_id' => $id])->all();    
	   return array($query1, $query2, $query3);
   }
	
	
	
	
	  
   /**
   * sort 3 merged arrays by ascending UnixTime values
   *
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
