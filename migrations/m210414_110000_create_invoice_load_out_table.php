<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%iinvoice_load_out}}`.
 */
class m210414_110000_create_invoice_load_out_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%invoice_load_out}}', [
            'id'                  => $this->primaryKey(),
            'user_id'             => $this->integer()->notNull()->comment("User's ID"),
            'invoice_unique_id'   => $this->string(77)->notNull(),
            'product_id'          => $this->integer()->notNull()->comment("Product FK"),
            'product_wieght'      => $this->integer()->notNull(),
            'user_date_unix'      => $this->integer()->notNull(),
            'confirmed_by_admin'  => "enum('" . 0 . "','" . 1 . "') NOT NULL DEFAULT '" . 0 . "'", //set enum
            'confirmed_date_unix' => $this->integer(),
            'date_to_load_out'    => $this->integer(),
            'b_intervals'         => $this->integer(),
            'b_quarters'          => $this->integer(),
            'elevator_id'         => $this->integer(),
            'completed'           => "enum('" . 0 . "','" . 1 . "') NOT NULL DEFAULT '" . 0 . "'", //set enum
            'completed_date_unix' => $this->integer(),
            'final_balance'       => $this->integer(),

        ]);
        
        // add foreign keys for table 'user', 'product_name', 'elevators',
        $this->addForeignKey('fk-user_id',     'invoice_load_out', 'user_id',      'user',         'id',         'CASCADE'); //arg, thisTable, thisID, thatTable, thatID
        $this->addForeignKey('fk-product_id2', 'invoice_load_out', 'product_id',   'product_name', 'pr_name_id', 'CASCADE'); 
        $this->addForeignKey('fk-elevator_id2','invoice_load_out', 'elevator_id',  'elevators',    'e_id',       'CASCADE'); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%invoice_load_out}}');
    }
}
