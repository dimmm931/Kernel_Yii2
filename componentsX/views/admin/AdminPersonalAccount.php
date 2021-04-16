<?php

namespace app\componentsX\views\admin;
use Yii;
use yii\bootstrap\Collapse;  //  Collapse (hide/show)

class AdminPersonalAccount
{
	
    /**
     * Displays all Elevators' balance of all users
     * @param collection of objects $userCount (all users)
     * @param collection of objects $products  (all products)
     * @param collection of objects $balance   (all balances)
     * $return string $allElevatorsStats
     */
    public static function showAllElevetorStatistics($userCount, $products, $balance) {
	    
	    $allElevatorsStats = '<div class="col-sm-12 col-xs-12 panel panel-default">';
	    $allElevatorsStats.= '<p class="panel-heading">Загалом в системі зареєстровано користувачів: <i class="fa fa-male" style="font-size:1.2em"></i> <b>' .  $userCount->count() . '</b><p>';
	    $allElevatorsStats.= '<p class="panel-heading">Загалом на елеваторі зберігається:<p>';
	 
		foreach($products  as $product){
			$productAmount_1 = 0;
           
			foreach($balance as $b){
				if( $b->balance_productName_id == $product->pr_name_id ){
					$productAmount_1+= (int)$b->balance_amount_kg;
				}
			}
            
            //productName: weight
			$allElevatorsStats.=  "<div class='col-sm-2 col-xs-12 panel-heading'><i class='fa fa-th-large' style='font-size:1.2em'></i> " . $product->pr_name_name . ": <b>" . $productAmount_1 ." kg </b></div>";
		}

	    $allElevatorsStats.=  '</div>';
        return $allElevatorsStats;	    
	 }
	 
	 
	 
	
	/**
     * Collapse widget with admin info
     * @return string $adminInfo
     *
     */
    public static function showCollapsedUserInfo() {

	    if(Yii::$app->user->can('adminX')){
			$admin = "<b>У Вас є права адміністратора.</b>";
	    } 
		  
        $adminInfo = '<br><div class="col-sm-12 col-xs-12">';
        $adminInfo.= Collapse::widget([
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
        
        $adminInfo.= '</div>';
  
        return $adminInfo;
    } 	 
}
