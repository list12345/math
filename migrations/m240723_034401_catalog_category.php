<?php

use yii\db\Migration;

/**
 * Class m240723_034401_catalog_category
 */
class m240723_034401_catalog_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catalog_category}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->bigInteger()->null(),
            'order_id' => $this->integer()->notNull(),
            'name' => $this->string(64),
            'description' => $this->text(),
            'state' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->null(),
            'data' => $this->json()->null(),
        ]);
        //self-reference
        $this->addForeignKey(
            'fk_catalog_category_catalog_category_id',
            '{{%catalog_category}}',
            'parent_id',
            '{{%catalog_category}}',
            'id'
        );

        $this->createTable('{{%catalog_item}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(64)->notNull()->unique(),
            'name' => $this->string(64)->notNull(),
            'type' => $this->string(64)->notNull(),
            'catalog_category_id' => $this->bigInteger()->notNull(),
            'order_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'state' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->null(),
            'data' => $this->json()->null(),
        ]);

        $this->addForeignKey(
            'fk_catalog_item_catalog_category_id',
            '{{%catalog_item}}',
            'catalog_category_id',
            '{{%catalog_category}}',
            'id'
        );
        for ($i = 1; $i <= 12; $i++) {
            $this->insert('{{%catalog_category}}', [
                'parent_id' => null,
                'order_id' => $i,
                'name' => 'Grade ' . $i,
                'state' => 1,
                'description' => $this->text(),
                'created_at' => new \yii\db\Expression('NOW()::TIMESTAMP(0)'),
                'updated_at' => new \yii\db\Expression('NOW()::TIMESTAMP(0)'),
            ]);
        }
        for ($i = 1; $i <= 12; $i++) {
            $this->insert('{{%catalog_category}}', [
                'parent_id' => $i,
                'order_id' => 1,
                'name' => 'Lessons Grade ' . $i,
                'state' => 1,
                'description' => $this->text(),
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
        $this->dropTable('{{%catalog_item}}');
        $this->dropTable('{{%catalog_category}}');

        return true;
    }
}
