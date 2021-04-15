<?php

namespace app\componentsX\views\admin;
use Yii;
use yii\bootstrap\Collapse;  //  Collapse (hide/show)

class AdminPersonalAccount
{
	
	
    /**
     * Displays all Elevators' balance of all users
     * 
     */
    public static function showAllElevetorStatistics($userCount, $products, $balance) {
	    
	    echo '<div class="col-sm-12 col-xs-12 panel panel-default">';
	    echo '<p class="panel-heading">Загалом в системі зареєстровано користувачів: <i class="fa fa-male" style="font-size:1.2em"></i> <b>' .  $userCount->count() . '</b><p>';
	    echo '<p class="panel-heading">Загалом на елеваторі зберігається:<p>';
	 
		foreach($products  as $product){
			$productAmount_1 = 0;
			foreach($balance as $b){
				if( $b->balance_productName_id == $product->pr_name_id ){
					$productAmount_1+= (int)$b->balance_amount_kg;
				}
			}
            //productName: weight
			echo "<div class='col-sm-2 col-xs-12 panel-heading'><i class='fa fa-th-large' style='font-size:1.2em'></i> " . $product->pr_name_name . ": <b>" . $productAmount_1 ." kg </b></div>";
		}

	    echo '</div>';
		    
	 }
	 
	 
	 
	
	/**
     * Collapse widget with user info
     * 
     */
    public static function showCollapsedUserInfo() {

	    if(Yii::$app->user->can('adminX')){
			 $admin = "<b>У Вас є права адміністратора.</b>";
			 } 
		  
        echo  '<br><div class="col-sm-12 col-xs-12">';
        echo Collapse::widget([
             'items' => [
                 [
                    'label' => 'Натисніть щоб переглянути деталі профілю',  
                    'content' => '   
                        <div class="col-lg-offset-1" style="color:;">
						 <i class="fa fa-address-card-o" style="font-size:36px"></i></br>
                         <p><b>Деталі Вашаго аккаунту</b>.</p> '.
						 '<p>' .  $admin . '</p>' .
						 '<p>Username: '. Yii::$app->user->identity->username . '</p>' .
						 '<p>Email: '. Yii::$app->user->identity->email . '</p>
						 <p>Name: '. Yii::$app->user->identity->first_name . '</p>
						 <p>Last name: '. Yii::$app->user->identity->last_name . '</p>
						 <p>Company: '. Yii::$app->user->identity->company_name . '</p>
						 <p>Phone: '. Yii::$app->user->identity->phone_number . '</p>
						 <p>Address: '. Yii::$app->user->identity->address . '</p>
                       </div>', 
                ], 
	          ]
         ]);
        // End Collapse widget
        echo '</div>';
    } 
	 
}

