<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
	<!---- Image ----> 
	<div class="row"> 
        <center>
	        <div class="col-sm-2 col-xs-6"> 
            <?php		
            $image = '<i class="fa fa-cubes" style="font-size:56px"></i>';	
            echo "<div class='subfolder border shadowX'>" .
		         Html::a( $image ."<p></p><br>" , ["#"], $options = ["title" => "Sign in",]) . 
		         "</div>"; 
	        ?>
            </div>
	    </center>
	</div>
    </br>
   
   
    <!------ FLASH Message to show if the account not yet activated by the admin ----->
    <?php if( Yii::$app->session->hasFlash('failX') ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('failX'); ?>
    </div>
    <?php endif;?>
    <!------ END FLASH  ----->
   
    <!--<i class="fa fa-cubes" style="font-size:68px;color:navy"></i>-->
    <p>Будь-ласка, введіть Ваші логін та пароль:</p>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label shadowX lavender'],
        ],
    ]); ?>

        <?php // echo $form->field($model, 'username')->textInput(['autofocus' => true]); ?>
        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Your email']) ?>
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
