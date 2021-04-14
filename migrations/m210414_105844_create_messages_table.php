<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%messages}}`.
 */
class m210414_105844_create_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%messages}}', [
            'm_id'          => $this->primaryKey(), 
            'm_time'        => $this->timestamp(),
            'm_unix'        => $this->integer()->notNull(),
            'm_sender_id'   => $this->integer()->notNull(),
            'm_receiver_id' => $this->integer()->notNull(),
            'm_text'        => $this->text()->notNull(), 
            'm_status_read' => "enum('" . 0 . "','" . 1 . "') NOT NULL DEFAULT '" . 0 . "'", //set enum
        ]);
        
        
        // add foreign keys for table 'user'
        $this->addForeignKey('fk-m_sender_id',  'messages', 'm_sender_id',   'user', 'id', 'CASCADE'); //arg, thisTable, thisID, thatTable, thatID
        $this->addForeignKey('fk-m_receiver_id','messages', 'm_receiver_id', 'user', 'id', 'CASCADE'); 
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%messages}}');
    }
}
