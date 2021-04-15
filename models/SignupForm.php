<?php
 
namespace app\models;
 
use Yii;
use yii\base\Model;
 
/**
 * Signup form
 */
class SignupForm extends Model
{
 
    public $username;
    public $email;
    public $password;
	public $password_confirm;
	public $phone_number;
	public $first_name;
	public $last_name;
	public $company_name;
	public $address;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','first_name'], 'trim'],
            [['username', 'first_name', 'phone_number', 'address'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
			['password_confirm','required'],
			//my compare passwords  & confirm
            ['password_confirm', 'compare', 'compareAttribute'=>'password', 'message'=>"Паролі не співпадають", /*'on' => 'update' */   ],
			['phone_number', 'string', 'max' => 14], 
			['phone_number','validateDatesX'], //my validation
			[['first_name', 'last_name'], 'string', 'max' => 22],
            [['company_name'], 'string', 'max' => 33],
        ];
    }
 
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
 
        $user               = new User();
        $user->username     = $this->username;
        $user->email        = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
		$user->phone_number = $this->phone_number;
		$user->first_name   = $this->first_name;
		$user->last_name    = $this->last_name;
		$user->company_name = $this->company_name;
		$user->address      = $this->address;
        return $user->save() ? $user : null;
    }
	
	 
    /**
     * My validation
     *
     * 
     */
	public function validateDatesX(){
		//$RegExp_Phone = '/^[+]380\([\d]{1,4}\)[0-9]+$/';
		$RegExp_Phone = '/^[+]380[\d]{1,4}[0-9]+$/';
		if (!preg_match($RegExp_Phone, $this->phone_number)){
			$this->addError('phone_number','Телефон має бути у форматі +380********* ');
		}
    }
}