<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\helpers\Json;

use app\assets\admin\AdminLoadOutAsset;// use your custom asset
AdminLoadOutAsset::register($this); 
 
 
$this->title = 'Запити на відвантаження';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="all" class="site-about animate-bottom">
    <h1><?= Html::encode($this->title) ?></h1>
	
   <!------ FLASH Message if OK ----->
   <?php if( Yii::$app->session->hasFlash('statusOK') ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('statusOK'); ?>
    </div>
    <?php endif;?>
   <!------ END FLASH if OK ----->
   
   
      <!------ FLASH Message if FAILS ----->
   <?php if( Yii::$app->session->hasFlash('statusFAIL') ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('statusFAIL'); ?>
    </div>
    <?php endif;?>
   <!------ END FLASH if FAILS ----->

	
	
	

	<!---- Image ----> 
	 <div class="row"> 
       <center>
	   <div class="col-sm-2 col-xs-6"> 
        <?php		
        $image = '<i class="fa fa-download" style="font-size:56px"></i>';	
        echo "<div class='subfolder border shadowX'>" .
		     Html::a( $image ."<p></p><br>" , ["#"], $options = ["title" => "Sign up requests",]) . 
		     "</div>"; 
	    ?>
       </div>
	   </center>
	</div></br>
	
	
   
	
	<?php
	//pass url to JS for ajax
	$urlX1 = Yii::$app->getUrlManager()->getBaseUrl(); //pass baseURL for 2 ajax
    $this->registerJs( "var urlX = ".Json::encode($urlX1).";",   yii\web\View::POS_HEAD,  'myproduct2-events-script' );
	
	//pass elevators to JS for ajax to build dropdown with elevators
    $this->registerJs( "var elevators = ".Json::encode($allElevators).";",   yii\web\View::POS_HEAD,  'myproduct3-events-script' );	
    					
							
	//Display all invoices LoadOut with confirmed_by_admin' => self::STATUS_PENDING, ie {0}
	$requestsLoadOut = $modelPageLinker;
	
	if(empty($requestsLoadOut)){
		echo '<div class="col-sm-8 col-xs-12 text-danger"> Запитів немає.</div>';
		
	} else {
		
		echo '<div class="col-sm-8 col-xs-12 text-success"> You have <b class="text-danger">'  . count($requestsLoadOutCount) . ' </b>запитів </div></hr>';
		
		//table headers
		echo '<div class="col-sm-12 col-xs-12  list-group-item header-color">' .
		       '<div class="col-sm-2 col-xs-6"> <b> From </b></div>' .
		       '<div class="col-sm-2 col-xs-6"> <b> Date </b></div>' .
			   //'<div class="col-sm-8 col-xs-6"> <b> Text </b></div>' .
			 '</div>';

		$i = 0;
		foreach($requestsLoadOut as $m){
		    $i++;
			//displays invoices in loop
			echo '<div class="col-sm-12 col-xs-12 list-group-item cursorX invoice-one ' .($i%2 ? 'evenX':''). '" data-toggle="modal" data-target="#myModal' . $i . '" data-invoic-id="' .$m->id . ' " >' .  //data-toggle="modal" data-target="#myModal' . $i .   for modal
			       '<div class="col-sm-2 col-xs-6">' . $m->users->email . '</div>' . //hasOne relation
				   '<div class="col-sm-2 col-xs-6">' . Yii::$app->formatter->format($m->user_date_unix, 'date') .      '</div>' .
				   //'<div class="col-sm-8 col-xs-6">' . crop($m->m_text, 27) .   '</div>' .
				 '</div>'; 
		}
		
	
	}
	
	// display LinkPager
    echo LinkPager::widget([
        'pagination' => $pages,
    ]); 
    ?>
	
	
	
	
	<!----------------- Div with selected invoice's details and datepicker (html-ed with ajax) ------------>
	<div class="col-sm-12 col-xs-12" id="invoiceSelected">
	</div>
	<!------------- END Div with selected invoice's details and datepicker (html-ed with ajax)  ------------>
	
	
	
	
	<!----------------- Div with Interval list (free/taken) (html-ed with ajax) ------------>
	<div class="col-sm-12 col-xs-12" id="intervalList">

	</div>
	<!------------- Div with Interval list (html-ed with ajax)  ------------>
	
	
	
    </br>
	
	
	<!----------------- Div with hidden form (where Admin sets date to loadOut, hour & minutes)  ------------>
	<div class="col-sm-12 col-xs-12" id="formFinish"> 
	
	    <div class="col-sm-12 col-xs-12 text-danger"><!-- this div to display selected date, hour, min, html-ed in js/datepicker_action.js -->
		    <center><h3  class="borderZ" id="selDate"></h3></center>
		</div> 
	
	    <?php $form = ActiveForm::begin(); ?>
	
	     <div class="col-sm-4 col-xs-12">
	    <?= $form->field($model, 'id')->hiddenInput([ 'placeholder' => 'invoice ID', 'id' => 'invoiceID' ])->label(false);  ?>
	    </div>
		
        <div class="col-sm-4 col-xs-12">
	    <?= $form->field($model, 'confirmed_date_unix')->hiddenInput([ 'placeholder' => 'Confirm date', 'value'=> time() ])->label(false); ?>
	    </div>
	
	    <div class="col-sm-4 col-xs-12">
        <?= $form->field($model, 'date_to_load_out')->hiddenInput([ 'placeholder' => 'Date to load', 'id' => 'dateToLoad'])->label(false); ?> 
        </div>
	
	    <div class="col-sm-4 col-xs-12">
        <?= $form->field($model, 'b_intervals')->hiddenInput(['placeholder' => 'Hour', 'id' => 'intervalHour'])->label(false); ?>
        </div>
	
	    <div class="col-sm-4 col-xs-12">
	    <?= $form->field($model, 'b_quarters')->hiddenInput(['placeholder' => 'Minute', 'id' => 'quarterMinute'])->label(false); ?>
	    </div>
	
	    <div class="col-sm-4 col-xs-12">
	    <?= $form->field($model, 'elevator_id')->hiddenInput(['placeholder' => 'Elevator', 'id' => 'elevator'])->label(false); ?>
	    </div>
	
	    <div class="col-sm-12 col-xs-12">
            <div class="form-group">
                <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
            </div>
	    </div>

       <?php ActiveForm::end(); ?>
	</div>
	<!------------- END Div with hidden form   ------------>

	
	
	

	
	<!------------- Loader for ajax waiting time ------------>
	<div class="loader" id="loader"></div>
	<!------------- Loader for ajax waiting time ------------>
	
	
</div>



<?php
//DELETE?????
/*
$this->registerJsFile(
    '@web/js/jqueryX.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
     '@web/js/datepicker_ui/datepicker.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
*/
?>





