<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_name}}`.
 */
class m210414_105738_create_product_name_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_name}}', [
            'pr_name_id'      => $this->primaryKey(),
            'pr_name_name'    => $this->text()->notNull(),
            'pr_name_descr'   => $this->string(155)->notNull(),
            'pr_name_measure' => $this->string(17)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_name}}');
    }
}
