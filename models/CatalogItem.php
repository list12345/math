<?php

namespace app\models;

use app\models\classes\behaviors\TimestampBehavior;
use app\models\classes\StateTrait;
use Yii;
use Yii2App\Classes\State;

/**
 * This is the model class for table "catalog_item".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $type
 * @property int $catalog_category_id
 * @property int $order_id
 * @property string|null $description
 * @property int $state
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $data
 *
 * @property CatalogCategory $catalogCategory
 */
class CatalogItem extends \yii\db\ActiveRecord
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
        return '{{%catalog_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'type', 'catalog_category_id',], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['code', 'name', 'type', 'catalog_category_id', 'created_at', 'order_id',], 'required'],
            [['catalog_category_id'], 'default', 'value' => null],
            [['catalog_category_id'], 'integer'],
            [['description'], 'string'],
            [['state'], 'default', 'value' => self::STATE_ENABLED],
            [['order_id', 'state'], 'integer'],
            [['state'], 'in', 'range' => [self::STATE_DISABLED, self::STATE_ENABLED]],
            [['created_at', 'updated_at', 'data'], 'safe'],
            [['code', 'name', 'type'], 'string', 'max' => 64],
            [['code'], 'unique'],
            [
                ['catalog_category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => CatalogCategory::class,
                'targetAttribute' => ['catalog_category_id' => 'id']
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
            'code' => 'Code',
            'name' => 'Name',
            'type' => 'Type',
            'catalog_category_id' => 'Catalog Category ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'data' => 'Data',
        ];
    }

    /**
     * Gets query for [[CatalogCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategory()
    {
        return $this->hasOne(CatalogCategory::class, ['id' => 'catalog_category_id']);
    }

    /**
     * Apply class to type and unique guid identifier
     */
    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if ($this->getScenario() != 'search') {
                $this->code = self::v4();
                $this->type = get_class($this);
            }
        }

        return parent::beforeValidate();
    }

    /**
     * @return string
     */
    public static function v4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
