<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_name".
 *
 * @property int $pr_name_id
 * @property string $pr_name_name
 * @property string $pr_name_descr
 */
class ProductName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pr_name_name', 'pr_name_descr'], 'required'],
            [['pr_name_name'], 'string'],
            [['pr_name_descr'], 'string', 'max' => 155],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pr_name_id' => Yii::t('app', 'Pr Name ID'),
            'pr_name_name' => Yii::t('app', 'Pr Name Name'),
            'pr_name_descr' => Yii::t('app', 'Pr Name Descr'),
        ];
    }
}
