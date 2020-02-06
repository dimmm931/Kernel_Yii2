<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\assets\admin\AdminConfirmRegistrationAsset;   // use your custom asset
AdminConfirmRegistrationAsset::register($this); 
 
$this->title = 'Запити на реєстрацію';
$this->params['breadcrumbs'][] = $this->title;
?>



<div id="all" class="admin-default-index animate-bottom">
    <h1><?= Html::encode($this->title) ?></h1>
	
	
	<!-- Image -->
	 <div class="row"> 
       <center>
	   <div class="col-sm-2 col-xs-6"> 
        <?php		
        $image = '<i class="fa fa-address-card-o" style="font-size:56px"></i>';	
        echo "<div class='subfolder border shadowX'>" .
		     Html::a( $image ."<p></p><br>" , ["#"], $options = ["title" => "Sign up requests",]) . 
		     "</div>"; 
	    ?>
       </div>
	   </center>
	</div></br>
	
	
	
	
   <!------ FLASH Message to show if the account not yet activated by the admin ----->
   <?php if( Yii::$app->session->hasFlash('approveOK') ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('approveOK'); ?>
    </div>
    <?php endif;?>
   <!------ END FLASH  ----->
   
	
	<?php
	//display table with users to approve
	$i = 0;
	if(!$requests){
		echo "No new users to approve.";
	} else {
		
		
      foreach ($requests as $b){
	      $i++;
		  echo '<div class="row list-group-item  ' .($i%2 ? 'evenX':''). '">';
		
		      //username
		      echo '<div class="col-sm-2 col-xs-2">' .
		          $b->last_name . //$b->username.
		     '</div>';
		
		      //email
		      echo '<div class="col-sm-2 col-xs-4 word-breakX">'.
		         $b->email.
		      '</div>';
			 
			  //button to Confirm registration
	          echo '<div class="col-sm-2 col-xs-3">';
		         $form = ActiveForm::begin(); ?>
                 <?= $form->field($model, 'yourInput')->hiddenInput(['value'=> $b->id])->label(false) ?>
				 <?= $form->field($model, 'yourInputEmail')->hiddenInput(['value'=> $b->email])->label(false) ?>
				 <div class="form-group">
                 <?= Html::submitButton(Yii::t('app', 'Confirm'), ['class' => 'btn btn-small btn-info fixx']) ?>
                 </div>
                 <?php ActiveForm::end(); 
	          echo '</div>';
			
			  //button to view User
	          echo '<div class="col-sm-2 col-xs-2">'.
                 '<button type="button" class="btn btn-info btnX" data-toggle="modal" data-target="#myModal' . $i . '">View</button>' .
	          '</div>';
	?>
			
			<!--------- Hidden Modal ---------->
           <div class="modal fade" id="myModal<?php echo $i;?>" role="dialog">
               <div class="modal-dialog modal-lg">
                   <div class="modal-content">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                           <h4 class="modal-title"><b><i class="fa fa-address-card-o" style="font-size:56px"></i> </b></h4>
                       </div>
					   
                      <div class="modal-body">
                          <p><b>User's info.</b></p>
						  
						  <div class="row list-group-item">
						      <div class="col-sm-2 col-xs-6">Username</div>
						      <div class="col-sm-4 col-xs-6"><?=$b->username;?></div>
						  </div>
						  
						  <div class="row list-group-item">
						      <div class="col-sm-2 col-xs-6">Email</div>
						      <div class="col-sm-4 col-xs-6"><?=$b->email;?></div>
						  </div>
						  
						  <div class="row list-group-item">
						      <div class="col-sm-2 col-xs-6">First name</div>
							  <div class="col-sm-4 col-xs-6"><?=$b->first_name;?></div>
						  </div>
						  
						  <div class="row list-group-item">
						      <div class="col-sm-2 col-xs-6">Last name</div>
							   <div class="col-sm-4 col-xs-6"><?=$b->last_name;?></div>
						  </div>
							  
						 <div class="row list-group-item">
						      <div class="col-sm-2 col-xs-6">Company</div>
							   <div class="col-sm-4 col-xs-6"><?=$b->company_name;?></div>
						 </div>
						
						  <div class="row list-group-item">
						      <div class="col-sm-2 col-xs-6">Phone</div>
							  <div class="col-sm-4 col-xs-6"><?=$b->phone_number;?></div>
						 </div>
						 
						 <div class="row list-group-item">
						      <div class="col-sm-2 col-xs-6">Address</div>
							  <div class="col-sm-4 col-xs-6"><?=$b->address;?></div>
						 </div>
						 
						 <div class="row list-group-item">
						      <div class="col-sm-2 col-xs-6">Registered</div>
							  <div class="col-sm-4 col-xs-6"><?=Yii::$app->formatter->asDate($b->created_at,'php:d.m.Y')?></div>
						 </div>
						 
                     </div>
					  
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                  </div>
              </div>
           </div>
          <!------------ End Modal --------------->


		<?php
		echo '</div>';
	  }
	}
	//end display table with users to approve
	?>

</div>