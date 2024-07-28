<?php

use yii\db\Migration;

/**
 * Class m240723_034401_catalog_category
 */
class m240723_034401_learning_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%classroom}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'order_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'state' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->null(),
            'data' => $this->json()->null(),
        ]);
        $this->createTable('{{%learning_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'classroom_id' => $this->bigInteger()->null(),
            'order_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'state' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->null(),
            'data' => $this->json()->null(),
        ]);
        $this->addForeignKey(
            'fk_learning_category_classroom_id',
            '{{%learning_category}}',
            'classroom_id',
            '{{%classroom}}',
            'id'
        );

        $this->createTable('{{%learning_item}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(64)->notNull()->unique(),
            'name' => $this->string(64)->notNull(),
            'type' => $this->string(64)->notNull(),
            'order_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'learning_category_id' => $this->bigInteger()->notNull(),
            'state' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->null(),
            'data' => $this->json()->null(),
        ]);

        $this->addForeignKey(
            'fk_learning_item_learning_category_id',
            '{{%learning_item}}',
            'learning_category_id',
            '{{%learning_category}}',
            'id'
        );

        for ($i = 1; $i <= 12; $i++) {
            $this->insert('{{%classroom}}', [
                'order_id' => $i,
                'name' => 'Grade ' . $i,
                'state' => 1,
                'description' => 'Grade ' . $i,
                'created_at' => new \yii\db\Expression('NOW()::TIMESTAMP(0)'),
                'updated_at' => new \yii\db\Expression('NOW()::TIMESTAMP(0)'),
            ]);
        }
        for ($i = 1; $i <= 12; $i++) {
            $this->insert('{{%learning_category}}', [
                'classroom_id' => $i,
                'order_id' => 1,
                'name' => 'Lessons Grade ' . $i,
                'state' => 1,
                'description' => 'Grade ' . $i . ' Math Lessons',
                'created_at' => new \yii\db\Expression('NOW()::TIMESTAMP(0)'),
                'updated_at' => new \yii\db\Expression('NOW()::TIMESTAMP(0)'),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%learning_item}}');
        $this->dropTable('{{%learning_category}}');
        $this->dropTable('{{%classroom}}');

        return true;
    }
}
