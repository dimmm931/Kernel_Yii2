<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Balance;

/* @var $this yii\web\View */
/* @var $model app\modules\models\InvoiceLoadIn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-load-in-form">

   <?php
   //generate invoice number
   $invoice = "Trans-" . Yii::$app->security->generateRandomString(5). "-" . time(); 
   ?>
  
   
	<h3><span class="p-5 bg-success">Накладна  <i class="fa fa-print " style="font-size:34px"></i> <b> <?=$invoice?></b></h3>
	

    <?php $form = ActiveForm::begin( 
	    [ 'options' => ['class' => 'form-inline'],
		'fieldConfig' => [
                //'enableError' => true ,
                'template' => '<div class="col-sm-12">{label}</div>
				              <div class="col-sm-6">{input}{error}</div>'
                                ]
		]); ?>
	
      

	
	<div class="col-sm-6 col-xs-12"> <i class="fa fa-male" style="font-size:24px"></i>
	<?= $form->field($model, 'user2')->textInput(['id' => 'userName', 'placeholder' => 'Вкажіть email на кого переоформлюєте']); //not involved in form saving, just to get value (Id of user) from autocmplete and set it to {user_kontagent_id} ?>
	</div>
	
	
	<div class="col-sm-6 col-xs-12"><i class="fa fa-key" style="font-size:24px"></i>
	<?= $form->field($model, 'product_id')->dropDownList(ArrayHelper::map(Balance::find()->where(['balance_user_id' => Yii::$app->user->identity->id])->joinWith(['productname'])->all(),'balance_productName_id', 'productname.pr_name_name'),['prompt'=>'choose product']);?>
    </div>
	
	 <div class="col-sm-6 col-xs-12"><i class="fa fa-laptop" style="font-size:24px"></i>
     <?= $form->field($model, 'product_weight')->textInput(['placeholder' => 'вага в кг'])->label('Вага в кг'); ?>
     </div>
	
    <?= $form->field($model, 'from_user_id')->hiddenInput(['id' => 'userID', 'value'=>  Yii::$app->user->identity->id, 'placeholder' => 'User ID'])->label(false); ?>
	<?= $form->field($model, 'to_user_id')->hiddenInput(['id' => 'userIDToTransfer', 'value'=> 'will be hidden field', 'placeholder' => 'User ID to'])->label(false); ?>
	<?= $form->field($model, 'unix_time')->hiddenInput(['value' => time(), 'placeholder' => 'Unix'])->label(false); ?>
    <?= $form->field($model, 'invoice_id')->hiddenInput(['value' => $invoice ])->label(false); ?>
   

	<div class="col-sm-12 col-xs-12">
        <div class="form-group">
            <?= Html::submitButton('Виконати', ['class' => 'btn btn-success']) ?>
       </div>
	</div>

    <?php ActiveForm::end(); ?>

</div>