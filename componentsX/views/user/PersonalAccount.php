<?php

namespace app\componentsX\views\user;
use Yii;
use yii\bootstrap\Collapse;  //  Collapse (hide/show)

class PersonalAccount
{
	
    //---------------------------------------------------------
    public static function showUserBalance($balance) 
    {
	
	    //display user's balance
		    if(!$balance){
			    echo " <b>0</b> <i>(seems to have nothing on the balance so far).</i>";
				
		    } else {
		        
		        foreach ($balance as $k){
					echo "<div class='row'>";
				    echo "<div class='col-sm-2 col-xs-5'><i class='fa fa-shopping-basket' style='font-size:16px'></i> " . 
					                                            $k->productname->pr_name_name . ":</div>" . //hasOne relation
						 "<div class='col-sm-1 col-xs-3'><b>" . $k->balance_amount_kg . "</b>" . " " .      //weight
						                                        $k->productname->pr_name_measure  . "</div>";  //hasOne relation
				    echo "</div>";
			    }	
			}
	}
	 
	 
	 
	
	//---------------------------------------------------------
    public static function showCollapsedUserInfo() 
    {
         //Collapse widget
        echo Collapse::widget([
        'items' => [
            [
            'label' => 'Натисніть щоб переглянути деталі профілю',
            'content' => '   
                        <div class="col-lg-offset-1" style="color:;">
						 <i class="fa fa-address-card-o" style="font-size:36px"></i></br>
                         <p><b>Ваш аккаунт</b>.</p>
						 <p>Username: '. Yii::$app->user->identity->username . '</p>
						 <p>Email: '. Yii::$app->user->identity->email . '</p>
						 <p>Name: '. Yii::$app->user->identity->first_name . '</p>
						 <p>Last name: '. Yii::$app->user->identity->last_name . '</p>
						 <p>Company: '. Yii::$app->user->identity->company_name . '</p>
						 <p>Phone: '. Yii::$app->user->identity->phone_number . '</p>
						 <p>Address: '. Yii::$app->user->identity->address . '</p>
                       </div>',
            // to  be  this  block open  by  default de-comment  the  following 
            /*'contentOptions' => [
                'class' => 'in'
            ]*/  
            ], 
	     ]
      ]);
    }
	 
}

