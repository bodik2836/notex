<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 */
class m230714_232611_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts}}', [
            'post_id' => $this->primaryKey(),
            'message' => $this->text()->notNull(),
            'date' => $this->timestamp(),
            'user_id_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-posts-user_id_id',
            'posts',
            'user_id_id',
            'users',
            'user_id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-posts-user_id_id',
            'posts'
        );

        $this->dropTable('{{%posts}}');
    }
}
