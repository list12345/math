<?php

namespace app\models;

use app\models\classes\behaviors\TimestampBehavior;
use app\models\classes\StateTrait;
use Yii;

/**
 * This is the model class for table "catalog_category".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $order_id
 * @property string|null $name
 * @property int $state
 * @property string|null $description
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $data
 *
 * @property CatalogCategory[] $catalogCategories
 * @property CatalogItem[] $catalogItems
 * @property CatalogCategory $parent
 */
class CatalogCategory extends \yii\db\ActiveRecord
{
    use StateTrait;
    /** @const */
    public const STATE_DISABLED = 0;
    /** @const */
    public const STATE_ENABLED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%catalog_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'order_id', 'created_at'], 'required'],
            [['parent_id', 'order_id',], 'default', 'value' => null],
            [['state'], 'default', 'value' => self::STATE_ENABLED],
            [['state'], 'in', 'range' => [self::STATE_DISABLED, self::STATE_ENABLED]],
            [['parent_id', 'order_id', 'state'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'data'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [
                ['parent_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => CatalogCategory::class,
                'targetAttribute' => ['parent_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'order_id' => 'Order ID',
            'name' => 'Name',
            'state' => 'State',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'data' => 'Data',
        ];
    }

    /**
     * Gets query for [[CatalogCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategories()
    {
        return $this->hasMany(CatalogCategory::class, ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[CatalogItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItems()
    {
        return $this->hasMany(CatalogItem::class, ['catalog_category_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(CatalogCategory::class, ['id' => 'parent_id']);
    }
}
