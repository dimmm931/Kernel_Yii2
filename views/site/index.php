<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Welcome to Kernel';
?>
<div id="all" class="site-index animate-bottom">

    <!-- <div class="container-background"></div> --> <!-- for background-image -->
	
	
	<!------ FLASH Message ----->
   <?php if( Yii::$app->session->hasFlash('warnX1') ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('warnX1'); ?>
    </div>
    <?php endif;?>
   <!------ END FLASH  ----->
   
	
    <div class="jumbotron shadowX lavender">
        <h1 class="text-shadowX lavender ">Welcome to Kernel</h1>
		<?//Html::img(Yii::$app->getUrlManager()->getBaseUrl().'/images/kernel.jpg' , $options = ["id"=>"","margin-left"=>"3%","class"=>"","width"=>"5%","title"=>"Kernel"] ); ?>
    </div>
 
   
	
    <div class="body-content">
	
        <div class="row log-reg"> 
            <center>
			<div class="col-sm-4 col-xs-0"></div>
			
		    <!-- Login -->
		    <div class="col-sm-2 col-xs-6">
			<?php
			    $image = '<i class="fa fa-address-card-o" style="font-size:96px"></i>';	
				 echo "<div class='subfolder border shadowX lavender'>" .
			             Html::a( $image ."<p>Sign in</p><br>" , ["/site/login"], $options = ["title" => "Sign in",]) . 
				      "</div>";
			?>
			</div>
			
			<!-- Registration -->
			<div class="col-sm-2 col-xs-6">
			<?php
			    $image = '<i class="fa fa-user-plus" style="font-size:96px"></i>';	
				 echo "<div class='subfolder border shadowX lavender'>" .
			             Html::a( $image ."<p>Sign up</p><br>" , ["/site/signup"] , $options = ["title" => "Sign Up",]) . 
				      "</div>";
			?>
			</div>
			</center>
		</div> <!--class="log-reg" -->
        

    </div>
</div>
