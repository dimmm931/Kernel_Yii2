<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use app\modules\models\InvoiceLoadOut;
use app\modules\models\InvoiceLoadIn;
use app\models\TransferRights;

$this->title = 'Профіль користувача ';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="all" class="admin-default-index animate-bottom">
    <h1><?= Html::encode($this->title) ?></h1>
	<!-- Image -->
	<center>
	    <div class="row">
	       <div class="col-sm-2 col-xs-6">
                <?php		
                $image = '<i class="fa fa-address-card-o" style="font-size:26px"></i>';	
                echo "<div class='subfolder border shadowX'>" .
			        Html::a( $image ."<p>{$oneUser->username}</p><br>" , ["#"] , $options = ["title" => "more  info",]) . 
		            "</div><br>"; 
				?>
            </div>
	    </div>
	</center>
	<!-- Image -->
		   
    <!-- Collapse widget with user info -->
    <?php //echo \app\componentsX\views\admin\AdminPersonalAccount::showCollapsedUserInfo();?>
   
    <!------------------------- RESULT (user Info) --------------------->
	<div class="row twoX list-group-item">
	
        <?php
		echo "<div class='row'></div>";
	    echo "<div class='col-sm-4 col-xs-6 list-group-item'>Ім'я</div>" .
			 "<div class='col-sm-4 col-xs-6 list-group-item'>" .  $oneUser->username . "</div>";
	    echo "</div>";
			
		echo "<div class='row'></div>";
	    echo "<div class='col-sm-4 col-xs-6 list-group-item'>Пошта</div>" .
			 "<div class='col-sm-4 col-xs-6 list-group-item'>" .  $oneUser->email . "</div>";
	    echo "</div'>";
			
		echo "<div class='row'></div>";
	    echo "<div class='col-sm-4 col-xs-6 list-group-item'>Компанія</div>" .
			      "<div class='col-sm-4 col-xs-6 list-group-item'>" .  $oneUser->company_name . "</div>";
		echo "</div'>";  
        ?>

	</div><!-- End .twoX-->
	<!------------------------- END RESULT --------------------->
	
	
    <!------------------------- RESULT (user's balance ) --------------------->
    <div class='col-sm-12 col-xs-12'>
        <hr>
        <p>Баланс:</p>
        <?php
        //display user's balance  
	    echo \app\componentsX\views\user\PersonalAccount::showUserBalance($balance);
	    ?>
	</div>
   

    <!------------------------- RESULT (user's history ) --------------------->
    <div class='col-sm-12 col-xs-12 history'>
    <hr>
    <p>Історія:</p>
    <?php
    //var_dump($query);
    if(empty($query)){
        echo '<div class="col-sm-8 col-xs-12 text-danger"> Поки що жодних транзакцій</div>';	
	} else {
	?>
	
	<div class="col-sm-12 col-xs-12"> 
	    <?php 
        //HISTORY result does here
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
				$inv = \app\componentsX\views\user\TransactionHistory::displayTransferRights($i, $value);
					    				
		    //if it is from {invoice_load_in DB}	
		    } else if ($value instanceof InvoiceLoadIn) {
			    $inv = \app\componentsX\views\user\TransactionHistory::displayInvoiceLoadIn($i, $value);
		    }
            
            $invText   = $inv['invoiceText']; //text for invoice
            $modaltext = $inv['modalText'];   //text for modal
            
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
                            <p><b>Інформація</b></p>
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
	
</div> <!-- history-->

</div>
