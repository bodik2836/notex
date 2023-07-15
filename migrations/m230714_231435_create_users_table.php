<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m230714_231435_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'user_id' => $this->primaryKey(),
            'user_name' => $this->string(),
            'user_surname' => $this->string(),
            'user_email' => $this->string()->unique()->notNull(),
            'user_pass' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
