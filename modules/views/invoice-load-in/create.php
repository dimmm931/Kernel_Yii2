<?php

use yii\helpers\Html;
use yii\helpers\Json;

use app\assets\admin\AdminLoadInAsset;   // use your custom asset
AdminLoadInAsset::register($this); 

/* @var $this yii\web\View */
/* @var $model app\modules\models\InvoiceLoadIn */

$this->title = 'Створити нову накладну';
$this->params['breadcrumbs'][] = ['label' => 'Invoice Load Ins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="all" class="invoice-load-in-create animate-bottom">

    <h1><?= Html::encode($this->title) ?>
	<i class="fa fa-folder-open-o" style="font-size:34px"></i></h1>
	<p>Зареєструвати надходження нового зерна від клієнта</p>
	
	<!--- Image -->
	<div class="row"> 
        <center>
	        <div class="col-sm-2 col-xs-6"> 
             <?php		
             $image = '<i class="fa fa-dropbox" style="font-size:46px"></i>';	
             echo "<div class='subfolder border shadowX'>" .
		     Html::a( $image ."<p></p><br>" , ["#"], $options = ["title" => "My transactions",]) . 
		     "</div>"; 
	         ?>
            </div>
	    </center>
	</div></br>
	
    <!------ FLASH Message ----->
    <?php if( Yii::$app->session->hasFlash('OK') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('OK'); ?>
        </div>
    <?php endif;?>
    <!------ END FLASH  ----->
   
	<?php
	//passing php obj to autocomplete.js
    $this->registerJs(
        "var usersX = ".Json::encode($allUsers).";", 
        yii\web\View::POS_HEAD, 
        'calender-events-script'
    );
	//End passing php obj to autocomplete.js-
	?>

    <?= $this->render('_form', [
        'model' => $model,
		'products' => $products,
		'elevators' => $elevators
    ]) ?>

</div>
