<?php
 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
 
$this->title = 'Реєстрація';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
	
	
	 <!---- Image ----> 
	 <div class="row"> 
       <center>
	   <div class="col-sm-2 col-xs-6"> 
        <?php		
        $image = '<i class="fa fa-desktop" style="font-size:56px"></i>';	
        echo "<div class='subfolder border shadowX'>" .
		     Html::a( $image ."<p></p><br>" , ["#"], $options = ["title" => "Sign in",]) . 
		     "</div>"; 
	    ?>
       </div>
	   </center>
	</div></br>
	
	
	
	<!------ FLASH Message ----->
   <?php if( Yii::$app->session->hasFlash('warnX') ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('warnX'); ?>
    </div>
    <?php endif;?>
   <!------ END FLASH  ----->
   
	
    
    <div class="row">
        <div class="col-lg-5">
            <?php Pjax::begin(); ?>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'email')->label('Email'); ?>
                <?= $form->field($model, 'password')->passwordInput()->label('Пароль'); ?>
				<?= $form->field($model, 'password_confirm')->passwordInput()->label('Повторіть пароль'); ?>
				<?= $form->field($model, 'phone_number')->textInput()->label('Телефон'); ?>
				<?= $form->field($model, 'first_name')->textInput()->label('Ім"я'); ?>
				<?= $form->field($model, 'last_name')->textInput()->label('Прізвище'); ?>
				<?= $form->field($model, 'company_name')->textInput()->label('Компанія'); ?>
				<?= $form->field($model, 'address')->textInput()->label('Адреса'); ?>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
			<?php Pjax::end(); ?>
 
        </div>
    </div>
</div>