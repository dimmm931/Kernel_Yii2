<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance".
 *
 * @property int $balance_id
 * @property int $balance_productName_id
 * @property int $balance_user_id
 * @property int $balance_amount_kg
 * @property string $balance_last_edit
 */
class Balance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'balance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['balance_productName_id', 'balance_user_id', 'balance_amount_kg'], 'required'],
            [['balance_productName_id', 'balance_user_id', 'balance_amount_kg'], 'integer'],
            [['balance_last_edit'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'balance_id' => Yii::t('app', 'Balance ID'),
            'balance_productName_id' => Yii::t('app', 'Balance Product Name ID'),
            'balance_user_id' => Yii::t('app', 'Balance User ID'),
            'balance_amount_kg' => Yii::t('app', 'Balance Amount Kg'),
            'balance_last_edit' => Yii::t('app', 'Balance Last Edit'),
        ];
    }
	
	
	
    /**
     * hasOne relation
     * @return \yii\db\ActiveQuery
     */
	public function getProductname()
	{  
       return $this->hasOne(ProductName::className(), ['pr_name_id' => 'balance_productName_id']); 
    }

}