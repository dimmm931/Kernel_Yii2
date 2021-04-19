<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;
use Yii;

use app\assets\user\TransferRightsAsset; // use your custom asset
TransferRightsAsset::register($this); 

$this->title = 'Переоформити';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="all" class="site-about animate-bottom">
    <h1><?= Html::encode($this->title) ?></h1>
	<p>Переоформити зерно на іншого користувача</p>
	
	<!------ FLASH Message ----->
    <?php if( Yii::$app->session->hasFlash('statusOK') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('statusOK'); ?>
        </div>
    <?php endif;?>
    <!------ END FLASH  --------->
  
   
    <!------ FLASH Message ----->
    <?php if( Yii::$app->session->hasFlash('statusFail') ): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('statusFail'); ?>
        </div>
    <?php endif;?>
    <!------ END FLASH  --------->
	
	<!--- Image --->
	<div class="row"> 
        <center>
	        <div class="col-sm-2 col-xs-6"> 
                <?php		
                $image = '<i class="fa fa-balance-scale" style="font-size:56px"></i>';	
                echo "<div class='subfolder border shadowX'>" .
		              Html::a( $image ."<p></p><br>" , ["#"], $options = ["title" => "My transactions",]) . 
		             "</div>"; 
	            ?>
            </div>
	    </center>
	</div>
    </br><hr>

	<?php
	//passing php obj to autocomplete.js
    $this->registerJs(
        "var usersX2 = ".Json::encode($allUsers).";", 
        yii\web\View::POS_HEAD, 
        'calender-events-script3'
    );
	?>
	
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	
 
</div>