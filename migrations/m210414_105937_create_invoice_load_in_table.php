<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoice_load_in}}`.
 */
class m210414_105937_create_invoice_load_in_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%invoice_load_in}}', [
            'id'                      => $this->primaryKey(), 
            'user_kontagent_id'       => $this->integer()->notNull()->comment("User's ID"),
            'product_nomenklatura_id' => $this->integer()->notNull()->comment("Product ID"),
            'date'                    => $this->timestamp(),
            'unix'                    => $this->integer()->notNull(),
            'invoice_id'              => $this->string(77)->notNull(),
            'elevator_id'             => $this->integer()->notNull(),
            'carrier'                 => $this->string(77)->notNull(),
            'driver'                  => $this->string(77)->notNull(),
            'truck'                   => $this->string(77)->notNull(),
            'truck_weight_netto'      => $this->integer()->notNull(),
            'truck_weight_bruto'      => $this->integer()->notNull(),
            'product_wight'           => $this->integer()->notNull(),
            'trash_content'           => $this->integer()->notNull(),
            'humidity'                => $this->smallInteger()->notNull()
            'final_balance'           => $this->integer()->notNull(),
        ]);
        
        // add foreign keys for table 'user', 'product_name', 'elevators'
        $this->addForeignKey('fk-user_kontagent_id',       'invoice_load_in', 'user_kontagent_id',        'user',         'id',         'CASCADE'); //arg, thisTable, thisID, thatTable, thatID
        $this->addForeignKey('fk-product_nomenklatura_id', 'invoice_load_in', 'product_nomenklatura_id',  'product_name', 'pr_name_id', 'CASCADE'); 
        $this->addForeignKey('fk-elevator_id',             'invoice_load_in', 'elevator_id',              'elevators',    'e_id',       'CASCADE'); 

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%invoice_load_in}}');
    }
}
