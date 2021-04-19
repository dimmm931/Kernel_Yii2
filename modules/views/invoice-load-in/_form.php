<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\models\InvoiceLoadIn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-load-in-form">

        <?php 
	    //generate invoice
	    $invoiceIn = Yii::$app->security->generateRandomString(5). "-" . time();
	    ?>	
		<h3><span class="p-5 bg-success">Накладна  <i class="fa fa-print " style="font-size:34px"></i> <b> <?=$invoiceIn?></b></h3><hr>
		
	    <?php
	    $form = ActiveForm::begin( 
	    [ 'options' => ['class' => 'form-inline'],
		'fieldConfig' => [
                //'enableError' => true ,
                'template' => '<div class="col-sm-12">{label}</div>
				              <div class="col-sm-6">{input}{error}</div>'
                                ]
		]); ?>
	
    <div class="col-sm-4 col-xs-12">
	<?= $form->field($model, 'user_name')->textInput(['id' => 'userName', 'placeholder' => 'Email']); //not involved in form saving, just to get value (Id of user) from autocmplete and set it to {user_kontagent_id} ?>
	</div>
	
    <?= $form->field($model, 'user_kontagent_id')->hiddenInput(['id' => 'userID', 'value'=> 'will be hidden field', 'placeholder' => 'User ID'])->label(false); ?> <!-- hiddenInput(['value'=> '', 'id' => 'some_id'])->label(false); -->
    
	<div class="col-sm-4 col-xs-12">
	    <?= $form->field($model, 'product_nomenklatura_id')->dropDownList(ArrayHelper::map($products, 'pr_name_id', 'pr_name_name'), ['prompt' => 'Оберіть продукт'])->label('Номенклатура'); ?>
    </div>
	
    <?= $form->field($model, 'date')->hiddenInput()->label(false); ?>
    <?= $form->field($model, 'unix')->hiddenInput(['value' => time() ])->label(false); ?>
    <?= $form->field($model, 'invoice_id')->hiddenInput(['value' => $invoiceIn, 'maxlength' => true])->label(false); ?>

	<div class="col-sm-12 col-xs-12"></div>
	<div class="col-sm-4 col-xs-12">
	   <?= $form->field($model, 'elevator_id')->dropDownList(ArrayHelper::map($elevators, 'e_id', 'e_elevator'), ['prompt' => 'Оберіть елеватор'])->label('Елеватор');; ?>
    </div>
    
	<div class="col-sm-4 col-xs-12">
       <?= $form->field($model, 'carrier')->textInput(['placeholder'=> 'Перевізник', 'maxlength' => true])->label('Перевізник'); ?>
    </div>
    
	<div class="col-sm-4 col-xs-12">
        <?= $form->field($model, 'driver')->textInput(['placeholder' => 'Водій', 'maxlength' => true])->label('Водій'); ?>
    </div>
    
	<div class="col-sm-4 col-xs-12">
        <?= $form->field($model, 'truck')->textInput(['placeholder' => 'Авто', 'maxlength' => true])->label('Авто'); ?>
    </div>
    
	<div class="col-sm-4 col-xs-12">
        <?= $form->field($model, 'truck_weight_netto')->textInput(['placeholder' => 'Вага авто нетто'])->label('Вага авто нетто'); ?>
    </div>
    
	<div class="col-sm-4 col-xs-12">
        <?= $form->field($model, 'truck_weight_bruto')->textInput(['placeholder' => 'Вага авто брутто'])->label('Вага авто брутто'); ?>
    </div>
    
	<div class="col-sm-4 col-xs-12">
        <?= $form->field($model, 'product_wight')->textInput(['placeholder' => 'Вага продукту'])->label('Вага продукту кг'); ?>
    </div>
    
	<div class="col-sm-4 col-xs-12">
        <?= $form->field($model, 'trash_content')->textInput(['placeholder' => 'Домішки %'])->label('Домішки %'); ?>
    </div>
    
	<div class="col-sm-4 col-xs-12">
        <?= $form->field($model, 'humidity')->textInput(['placeholder' => 'Волога %'])->label('Волога'); ?>
    </div>
	
	<div class="col-sm-12 col-xs-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
	</div>

    <?php ActiveForm::end(); ?>

</div>