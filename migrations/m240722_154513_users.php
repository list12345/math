<?php

use yii\db\Migration;

/**
 * Class m240722_154513_users
 */
class m240722_154513_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'firstname' => $this->string(128),
            'lastname' => $this->string(128),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->null(),
        ]);
        $this->insert('{{user}}', [
            'username' => 'admin',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'status' => \app\models\classes\UserState::STATUS_ACTIVE,
            'created_at' => new \yii\db\Expression('NOW()::TIMESTAMP(0)'),
            'updated_at' => new \yii\db\Expression('NOW()::TIMESTAMP(0)'),
            'email' => 'admin@localhost',
        ]);
        $this->insert('{{auth_item}}', [
            'name' => 'admin',
            'type' => 1,
        ]);
        $this->insert('{{auth_item}}', [
            'name' => 'user',
            'type' => 1,
        ]);

        $this->insert('{{auth_assignment}}', [
            'item_name' => 'admin',
            'user_id' => 1,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');

        return true;
    }
}
