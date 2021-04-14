<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%balance}}`.
 */
class m210414_105810_create_balance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%balance}}', [
            'balance_id'             => $this->primaryKey(),
            'balance_productName_id' => $this->integer()->notNull(),
            'balance_user_id'        => $this->integer()->notNull(),
            'balance_amount_kg'      => $this->integer()->notNull(),
            'balance_last_edit'      => $this->timestamp(),
        ]);
        
        // add foreign keys for table 'user', 'product_name'
        $this->addForeignKey('fk-balance_productName_id', 'balance', 'balance_productName_id', 'product_name', 'pr_name_id', 'CASCADE'); //arg, thisTable, thisID, thatTable, thatID
        $this->addForeignKey('fk-balance_user_id',        'balance', 'balance_user_id',        'user',         'id',         'CASCADE'); 

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%balance}}');
    }
}
