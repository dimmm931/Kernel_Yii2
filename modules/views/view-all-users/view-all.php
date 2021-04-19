<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Json; 

use app\assets\admin\AdminViewAllUsersAsset;   // use your custom asset
AdminViewAllUsersAsset::register($this); 

$this->title = 'Всі користувачі';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="all" class="admin-default-index animate-bottom">
    <h1><?= Html::encode($this->title) ?></h1>
	<!-- Image -->
	<center>
	<div class="row">
	    <div class="col-sm-2 col-xs-6">
            <?php		
            $image = '<i class="fa fa-address-card-o" style="font-size:26px"></i>';	
            echo "<div class='subfolder border shadowX'>" .
			Html::a( $image ."<p>Всі користувачі</p><br>" , ["#"] , $options = ["title" => "more  info",]) . 
		    "</div><br>"; 
		    ?>
        </div>
	</div>
	</center>
	 <!-- Image -->
		   
    <?php
	//passing php obj to autocomplete.js
    $this->registerJs(
        "var usersX2 = ".Json::encode($allUsers).";", 
        yii\web\View::POS_HEAD, 
        'calender-eventss-script3'
    );
 
	$urlZ = Yii::$app->request->baseUrl;
	$this->registerJs(
        "var url = '" . $urlZ . "';",  
        yii\web\View::POS_HEAD, 
        'user1-events-script'
    );
    ?>
	 
    <!-- Collapse widget with user info -->
    <?php //echo \app\componentsX\views\admin\AdminPersonalAccount::showCollapsedUserInfo();?>

    <div class="row"> 		
    </div><!-- class='row' -->

    <div class="row oneX">
	    <div class="col-sm-6 col-xs-12">
	        <p>Пошук</p>  
	    </div>
	
	    <!-- Search -->
	    <div class="col-sm-4 col-xs-12">
	        <div class="search-container">
                <form action="#">
                <input type="text" placeholder="Пошук по імені.." name="search" id="searchProduct">
                <button type="button"><i class="fa fa-search"></i></button>
                </form>
            </div>
	   </div>
	   <!-- END Search -->
	   
	</div><!-- End .oneX-->
	
   <!------------------------- RESULT --------------------->
	<div class="row twoX">
	    <div class="col-sm-12 col-xs-12" id="resultX">
        <?php
	        echo "<br><p class='list-group-item'><b>Found  ".count($allUsers) . " users</b></p><br>";
	        $i = 0;
            foreach($allUsers as $v){
		        $i++;
	            //echo "<p> <a href='#' class='list-group-item'>" . $i ."." . $v->name. "</a></p>";
				echo Html::a( $i ."." . $v->username, ["/admin/view-all-users/single-user-view", "user_id"=> $v->id, ] , $options = ["title" => "more  info", "class"=>"list-group-item"] ); 
            }
        ?>
        </div> 
	</div><!-- End .twoX-->
	<!------------------------- END RESULT --------------------->
   
</div>
