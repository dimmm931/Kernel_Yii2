<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Admin Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-default-index">
    <h2><?php //echo $this->context->action->uniqueId; ?></h2>
    <h1><?= Html::encode($this->title) ?></h1>
    
    <!------ FLASH Message to show if the account not yet activated by the admin ----->
    <?php if( Yii::$app->session->hasFlash('failX') ): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('failX'); ?>
        </div>
    <?php endif;?>
    <!------ END FLASH  ----->
   
    <p>Please fill out the following fields to login:</p>
	<!-- Image -->
	<center>
	<div class="row">
	    <div class="col-sm-2 col-xs-6">
            <?php		
            $image = '<i class="fa fa-address-card-o" style="font-size:56px"></i>';	
            echo "<div class='subfolder border shadowX'>" .
			        Html::a( $image ."<p>Admin access</p><br>" , ["#"] , $options = ["title" => "more  info",]) . 
		          "</div><br>"; 
		    ?>
        </div>
	</div>
	</center>
	<!-- Image -->
		
    <?php 
    $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); 
    ?>

        <?php // echo $form->field($model, 'username')->textInput(['autofocus' => true]); ?>
        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => '']) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    
</div>
</div>
