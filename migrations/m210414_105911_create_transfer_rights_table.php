<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transfer_rights}}`.
 */
class m210414_105911_create_transfer_rights_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transfer_rights}}', [
            'id'             => $this->primaryKey(),
            'product_id'     => $this->integer()->notNull(),
            'invoice_id'     => $this->string(77)->notNull(), 
            'from_user_id'   => $this->integer()->notNull(),
            'to_user_id'     => $this->integer()->notNull(),
            'product_weight' => $this->integer()->notNull(), 
            'unix_time'      => $this->integer()->notNull(),
            'date'           => $this->timestamp(),
            'final_balance_sender'   => $this->integer()->notNull()->comment("Sender's balance"),
            'final_balance_receiver' => $this->integer()->notNull()->comment("Receiver's balance"), 
        ]);
        
        // add foreign keys for table 'user', 'product_name'
        $this->addForeignKey('fk-product_id',  'transfer_rights', 'product_id',   'product_name', 'pr_name_id', 'CASCADE'); //arg, thisTable, thisID, thatTable, thatID
        $this->addForeignKey('fk-from_user_id','transfer_rights', 'from_user_id', 'user', 'id', 'CASCADE'); 
        $this->addForeignKey('fk-to_user_id',  'transfer_rights', 'to_user_id',   'user', 'id', 'CASCADE'); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transfer_rights}}');
    }
}
