<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

	<!---- Image ----> 
	<div class="row"> 
        <center>
	        <div class="col-sm-2 col-xs-6"> 
            <?php		
            $image = '<i class="fa fa-briefcase" style="font-size:56px"></i>';	
            echo "<div class='subfolder border shadowX'>" .
		        Html::a( $image ."<p></p><br>" , ["#"], $options = ["title" => "About",]) . 
		         "</div>"; 
	        ?>
            </div>
	    </center>
	</div>
    </br>
	
	<div class="col-sm-8 col-xs-12">
        <p>
        Кернел – провідний у світі та найбільший в Україні виробник та експортер соняшникової олії, ключовий постачальник сільськогосподарської продукції з регіону Чорноморського басейну на світові ринки. Свою продукцію Кернел експортує більш ніж у 80 країн світу. З листопада 2007 року акції компанії торгуються на Варшавській фондовій біржі (WSE).
        </p>
    </div> 
</div>
