<?php
// commands/SeedController.php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;
use app\modules\models\Elevators;
use app\models\ProductName;
use app\modules\models\AuthAssignment;
use app\modules\models\AuthItem;

class SeedController extends Controller
{
    public function actionIndex()
    {
        
        //creates the admin user
        $user                = new User();
        $user->id            = 1;
        $user->username      = "test";
        $user->password_hash = Yii::$app->getSecurity()->generatePasswordHash('testtest');
        $user->email         = "test@ukr.net";
        $user->status        = 10;
        $user->first_name    = "Dima";
        $user->last_name     = "Ivanov";
        $user->company_name  = "Sealand Ltd";
        $user->phone_number  = "+38097543654";
        $user->address  = "Kyiv, st. Darwina, 4";
        $user->save();
        
        
        //creates multiple non-admin users
        $faker = \Faker\Factory::create();
        for ( $i = 1; $i <= 10; $i++ )
        {
            $user = new User();
            $user->id = null;
            $user->username = $faker->username;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash('testtest');
            $user->email = $faker->email;
            $user->status        = 9;
            $user->first_name    = $faker->firstName; //($gender=null|'male', 'female');
            $user->last_name     = $faker->lastName;
            $user->company_name  = $faker->company;
            $user->phone_number  = $faker->phoneNumber;
            $user->address       = $faker->address;
            $user->save();
           
        }
        
       
        //RBAC seeder (creates RBAC access for admin)
        //create a new role, it is created if this role does not exist in table {auth_item}
	    if(!AuthItem::checkIfRoleExist('adminX')) {   //method from /models/AuthItem.php. Checks if Rbac role already exists. Name of rbac role is passes as arg $roleName
            $role = Yii::$app->authManager->createRole('adminX');
            $role->description = 'myAdminX';
            Yii::$app->authManager->add($role);
	    } else {
		    echo "<p> Role already exists</p>";
	    }
        //assign a role 'adminX' to user 1
        $userRole = Yii::$app->authManager->getRole('adminX');
        Yii::$app->authManager->assign($userRole, 1); //Yii::$app->user->identity->id
        
        
        
        
        
        
        //Elevator seeder (creates elevator list)
        $elevatorsList = array(
            array('e_id' => 1, 'e_elevator' => 'Елеватор 1', 'e_discription' => '9.00-18.00', 'e_operated_by' => 'name'),
            array('e_id' => 2, 'e_elevator' => 'Елеватор 2', 'e_discription' => '9.00-18.00', 'e_operated_by' => 'name'),
            array('e_id' => 3, 'e_elevator' => 'Елеватор 3', 'e_discription' => '9.00-18.00', 'e_operated_by' => 'name'),
            array('e_id' => 4, 'e_elevator' => 'Елеватор 4', 'e_discription' => '9.00-18.00', 'e_operated_by' => 'name'),
            array('e_id' => 5, 'e_elevator' => 'Елеватор 5', 'e_discription' => '9.00-18.00', 'e_operated_by' => 'name'),
        );
        
        foreach ($elevatorsList as $a) { 
            $elev = new Elevators();
            $elev->e_id          = $a['e_id'];
            $elev->e_elevator    = $a['e_elevator'];
            $elev->e_discription = $a['e_discription'];
            $elev->e_operated_by = $a['e_operated_by'];
            $elev->save();
        }
        
        
        
        
        
        //Product_name seeder (creates products)
        $productList = array(
            array('pr_name_id' => 1, 'pr_name_name' => 'Пшениця',   'pr_name_descr' => 'Wheat crops', 'pr_name_measure' => 'kg'),
            array('pr_name_id' => 2, 'pr_name_name' => 'Кукурудза', 'pr_name_descr' => 'Corn crops',  'pr_name_measure' => 'kg'),
            array('pr_name_id' => 3, 'pr_name_name' => 'Рис',       'pr_name_descr' => 'Rice crops',  'pr_name_measure' => 'kg'),
            array('pr_name_id' => 4, 'pr_name_name' => 'Гречка',    'pr_name_descr' => 'Buckwheat',   'pr_name_measure' => 'kg'),
            array('pr_name_id' => 5, 'pr_name_name' => 'Овес',      'pr_name_descr' => 'Oats',        'pr_name_measure' => 'kg'),
        );
        
        foreach ($productList as $a) { 
            $product = new ProductName();
            $product->pr_name_id      = $a['pr_name_id'];
            $product->pr_name_name    = $a['pr_name_name'];
            $product->pr_name_descr   = $a['pr_name_descr'];
            $product->pr_name_measure = $a['pr_name_measure'];
            $product->save();
        }
        
        
      
        
        
       
        
    }
}