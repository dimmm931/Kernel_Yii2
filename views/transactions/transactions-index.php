<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use app\modules\models\InvoiceLoadOut;
use app\modules\models\InvoiceLoadIn;
use app\models\TransferRights;

use app\assets\user\TransactionHistoryAsset;   // use your custom asset
TransactionHistoryAsset::register($this); 

$this->title = 'Моя історія';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="all" class="site-about animate-bottom">
	
    <h1><?= Html::encode($this->title) ?></h1>
	
	<div class="row">
	
	    <div class="col-sm-6 col-xs-12"><!-- left-->
	
	        <!--- Image -->
	        <div class="row"> 
                <center>
	                <div class="col-sm-4 col-xs-6"> 
                        <?php		
                        $image = '<i class="fa fa-area-chart" style="font-size:56px"></i>';	
                        echo "<div class='subfolder border shadowX'>" .
		                Html::a( $image ."<p></p><br>" , ["#"], $options = ["title" => "My transactions",]) . 
		                "</div>"; 
	                    ?>
                    </div>
	            </center>
	        </div></br>
	
	    </div><!-- left-->
	
	
	
	   <div class="col-sm-6 col-xs-6"><!-- right div ith DropDown -->
	      <select id="dropdownnn"><!-- triggered with js -->
			<?php  
             $selectStatus = 'selected="selected"'; 			
			 echo '<option value="' . Url::to(["transactions/mytransations"]) . '"' . ((!isset($_GET['period'])) ? $selectStatus:'')  . '> За весь час </option>';
             echo '<option value="' . Url::to(["transactions/mytransations", "period" => "currentMonth"]) . '"' . ((isset($_GET['period']) && $_GET['period'] == "currentMonth") ? $selectStatus:'')  . '> Поточний місяць </option>';
             echo '<option value="' . Url::to(["transactions/mytransations", "period" => "lastMonth"])    . '"' . ((isset($_GET['period']) && $_GET['period'] == "lastMonth") ? $selectStatus:'')  . '> Попередній місяць </option>';
             echo '<option value="' . Url::to(["transactions/mytransations", "period" => "last_6_Month"]) . '"' . ((isset($_GET['period']) && $_GET['period'] == "last_6_Month") ? $selectStatus:'')  . '> Останні півроку </option>';		 
			?>


		  </select>
	  </div><!-- right -->
    
	</div><!-- row-->
	
	
	
    <!-- Results -->
	<?php
	
	if(empty($query)){
		echo '<div class="col-sm-8 col-xs-12 text-danger"> Поки що жодних транзакцій</div>';
		
	} else {
		
		//define $period
		if (!Yii::$app->getRequest()->getQueryParam('period')){
			$period = ' за весь час';
		}
		if (Yii::$app->getRequest()->getQueryParam('period') == "currentMonth"){
			$period = ' за поточний місяць';
		}
		if (Yii::$app->getRequest()->getQueryParam('period') == "lastMonth"){
			$period = ' за минулий місяць';
		}
		if (Yii::$app->getRequest()->getQueryParam('period') == "last_6_Month"){
			$period = ' за останнні 6 місяців';
		}
			
		echo '<div class="col-sm-8 col-xs-12 text-success"> У Вас  <b class="text-danger">'  . count($query) . ' </b> транзакцій ' . $period  . '</div><hr>';
	 ?>
	
	    <div class="col-sm-12 col-xs-12"> 
	    <?php 
        //HISTORY result does here
		date_default_timezone_set('Europe/Kiev');
	    $i = 0;
		
	    //iterate over merged and manually sorted array
	    foreach($query as $key => $value){
			
		    $i++;
		    echo "<div class='col-sm-12 col-xs-12 list-group-item'>";
           
		    //if it is from {invoice_load_out DB}
		    if ($value instanceof InvoiceLoadOut) { 
			    $inv = \app\componentsX\views\user\TransactionHistory::displayInvoiceLoadOut($i, $value);
				
			//if it is from {transfer_rights DB}	
            } else if ($value instanceof TransferRights) { 
				$inv  = \app\componentsX\views\user\TransactionHistory::displayTransferRights($i, $value);
				    
		    //if it is from {invoice_load_in DB}	
		    } else if ($value instanceof InvoiceLoadIn) {
			    $inv  = \app\componentsX\views\user\TransactionHistory::displayInvoiceLoadIn($i, $value);
		    }
		    $invText    = $inv['invoiceText']; //text for invoice
            $modaltext  = $inv['modalText'];   //text for modal
            
            echo $invText; //displays one of 3 invoices
		    echo "</div><hr>";
		    ?>
			  
		    <!--------- Hidden Modal ---------->
            <div class="modal fade" id="myModalHistory<?php echo $i;?>" role="dialog">
                  <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                         <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                             <h4 class="modal-title"><i class="fa fa-line-chart" style="font-size:50px; color: navy;"></i> <b> Деталі</b> </h4>
                         </div>
					   
                        <div class="modal-body">
                            <p><b>Message</b></p>
						    <?=$modaltext;?>    
                        </div>
					  
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
             </div>
            <!------------ End Modal ---------------> 
		  
		    <?php
	      } 
	}
	?>		  
		  
	</div> 
 
</div>
