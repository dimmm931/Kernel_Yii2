<?php

namespace app\componentsX\views\user;
use Yii;
use yii\bootstrap\Collapse;  //  Collapse (hide/show)

class TransactionHistory
{
	
    /**
     * Invoices from invoice_load_out DB
     * @return string $text
     */
    public static function displayInvoiceLoadOut($i, $value) 
    {
		echo "<div class='bg-danger cursorX' data-toggle='modal' data-target='#myModalHistory" . $i ."'>" .   
			    "<i class='fa fa-mail-reply' style='font-size:18px'></i><br>" . 
			    "<b>" . date("d-m-Y H:i:s", $value->user_date_unix) . "</b><br>".  //unix hen user make request
       		    " Списано. Відвантажено з елеватора. " . //Yii::$app->formatter->asDate($value->date_to_load_out, 'dd-MM-yyyy H:i:s ') . "<br>" .
			    //$value->users->email . //hasOne
			    " Накладна:<b> " .$value['invoice_unique_id']  . "</b> " . 
			    " Елеватор: <b> " .$value['elevator_id']  . "</b> " . 
				"Відвантаження: <b>" . ($value->date_to_load_out != 0 ? date("d-m-Y H:i:s", $value->date_to_load_out):' pending.')   . "</b>" .
				" Статус: OK" .
				"<div class='bg-danger'>  - " . $value['product_wieght'] .  " кг " . $value->products->pr_name_name  . " </div>". //-1kg
				"<div class='bg-danger'>  На балансі " . $value['final_balance'] .  " кг " . $value->products->pr_name_name  . " </div>" . //final balance
			  "</div>";
				
				
        //text for modal				
	    $text =  '<div class="row list-group-item">
			        <div class="col-sm-1 col-xs-3">Накладна:</div>
				      <div class="col-sm-4 col-xs-9">' . $value['invoice_unique_id'] . '</div> 
				  </div>
				  <div class="row list-group-item">
				    <div class="col-sm-1 col-xs-3">Дата:</div> 
				    <div class="col-sm-4 col-xs-9">' . date("d-m-Y H:i:s", $value->date_to_load_out) . '</div> 
				  </div>
				  <div class="row list-group-item">
				    <div class="col-sm-1 col-xs-3">Списано :</div>
					<div class="col-sm-4 col-xs-9"> - ' . $value['product_wieght'] .  " кг " . $value->products->pr_name_name . '</div> 
				  </div>';
						  
		return $text;		
	  
	}
	 
	 
	 
	 
	/**
     * Invoices from TransferRights DB
     * @return string $text
     */
     public static function displayTransferRights($i, $value) 
     {
		//if view the Sender of rightsTransfer
        if ($value->from_user_id == Yii::$app->user->identity->id){ //display 'Ви переказали', i.e view the Sender
            echo "<div class='bg-danger cursorX' data-toggle='modal' data-target='#myModalHistory" . $i ."'>" .   
				 "<i class='fa fa-mail-reply' style='font-size:18px'></i><br>" . 
				  "<b>" . date("d-m-Y H:i", $value->unix_time) . "</b><br>".  //unix hen user make request
       			  " Списано/Переоформлено на <b> " . $value->users->email . "</b>" .
				  " Накладна:<b> " .$value['invoice_id']  . "</b> " . 
				  " Статус: OK" .
				  "<div class='bg-danger'>  - " . $value['product_weight'] .  " кг " . $value->products->pr_name_name  . " </div>". //-1kg
				  "<div class='bg-danger'>  На балансі: " . $value['final_balance_sender'] .  " кг " . $value->products->pr_name_name  . " </div>". //final balance
				  "</div>";
					
        //if view the Reciever of rightsTransfer					
	    } else if ($value->to_user_id == Yii::$app->user->identity->id){ //display 'Вам переказали', i.e view the Reciever
            echo "<div class='bg-success cursorX' data-toggle='modal' data-target='#myModalHistory" . $i ."'>" .   
				 "<i class='fa fa-mail-reply' style='font-size:18px'></i><br>" . 
				 "<b>" . date("d-m-Y H:i", $value->unix_time) . "</b><br>".  //unix hen user make request
       		     " На Вас було переоформлено товар від на <b> " . $value->users2->email . "</b>" .
			     " Накладна:<b> " .$value['invoice_id']  . "</b> " . 
				 " Статус: OK" .
				 "<div class='bg-success'>  + " . $value['product_weight'] .  " кг " . $value->products->pr_name_name  . " </div>". //-1kg
				 "<div class='bg-success'>  На балансі: " . $value['final_balance_receiver'] .  " кг " . $value->products->pr_name_name  . " </div>". //final balance
				 "</div>";
		}
				
				
        //text for modal-> NOT FINISHED		
	    $text =  '<div class="row list-group-item">
				  <div class="col-sm-1 col-xs-3">Накладна:</div>
				  <div class="col-sm-4 col-xs-9">' . $value['invoice_id'] . '</div> 
				  </div>
				  <div class="row list-group-item">
				  <div class="col-sm-1 col-xs-3">Дата:</div>
				  <div class="col-sm-4 col-xs-9">' . date("d-m-Y H:i:s", $value->unix_time) . '</div> 
				  </div>
				  <div class="row list-group-item">
				  <div class="col-sm-1 col-xs-3">Списано :</div>
				  <div class="col-sm-4 col-xs-9"> - ' . $value['product_weight'] .  " кг " . $value->products->pr_name_name . '</div> 
				  </div>';
                  
		return $text;
			   
	}
	 
	 
	 
	
	/**
     * Invoices from InvoiceLoadIn DB
     * @return string $text
     */
    public static function displayInvoiceLoadIn($i, $value) 
    {
		echo "<div class='bg-success cursorX' data-toggle='modal' data-target='#myModalHistory" . $i ."'>" . 
		     "<i class='fa fa-mail-forward' style='font-size:18px'></i><br>" .
	         "<b>" . date("d-m-Y H:i:s", $value->unix) . "</b><br>".
        	 "Додано. Завантажено на елеватор. " . 
			 "Накладна:<b>  " . $value['invoice_id'] . " </b>" .  
			 " Елеватор: <b> " .$value['elevator_id']  . "</b> " . 
			 "<div class='bg-success'>  + " . $value['product_wight'] .  " кг " . $value->products->pr_name_name  . " </div>". //-1kg
			 "<div class='bg-success'>  На балансі: " . $value['final_balance'] .  " кг " . $value->products->pr_name_name  . " </div>". //final balance
			 "</div>";
				
				
        //text for modal				
	    $text =  '<div class="row list-group-item">
				  <div class="col-sm-1 col-xs-3">Накладна:</div>
				  <div class="col-sm-4 col-xs-9">' . $value['invoice_id'] . '</div> 
				  </div>
                  <div class="row list-group-item">
				  <div class="col-sm-1 col-xs-3">Дата:</div>   
				  <div class="col-sm-4 col-xs-9">' . date("d-m-Y H:i:s", $value->unix) . '</div> 
				  </div>
                  <div class="row list-group-item">
				  <div class="col-sm-1 col-xs-3">Додано :</div>
				  <div class="col-sm-4 col-xs-9"> + ' . $value['product_wight'] .  " кг " . $value->products->pr_name_name . '</div> 
				  </div>';
		return $text;
	}

	 
	 
	 
}

