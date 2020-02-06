<?php
//model for hidden input in admin views/user-registration-requests.php
namespace app\modules\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for actionUsersRegistrationRequests.
 *
 * @property int $b_id

 */
class RegisterRequest_InputModel extends Model
{
	
	
	 public $yourInput;
	 public $yourInputEmail;

	
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
            ['yourInput', 'integer', 'message'=>'your text'],
           
        ];
    }
public function attributeLabels()
    {
        return [
            'yourInput' => 'userID',

            
        ];
    }

    
}
