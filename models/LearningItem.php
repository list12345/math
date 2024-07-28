<?php

namespace app\models;

use app\models\classes\behaviors\TimestampBehavior;
use app\models\classes\State;
use app\models\classes\StateTrait;
use Yii;

/**
 * This is the model class for table "learning_item".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $type
 * @property int $order_id
 * @property string|null $description
 * @property int $learning_category_id
 * @property int $state
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $data
 *
 * @property LearningCategory $learningCategory
 */
class LearningItem extends \yii\db\ActiveRecord
{
    use StateTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{learning_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'type', 'learning_category_id',], 'filter', 'filter' => 'trim', 'skipOnArray' => true, 'skipOnEmpty' => true],
            [['code', 'name', 'type', 'order_id', 'learning_category_id', 'created_at'], 'required'],
            [['order_id', 'learning_category_id',], 'default', 'value' => null],
            [['state'], 'default', 'value' => State::DISABLED],
            [['state'], 'in', 'range' => [State::DISABLED, State::ENABLED]],
            [['order_id', 'learning_category_id', 'state'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'data'], 'safe'],
            [['code', 'name', 'type'], 'string', 'max' => 64],
            [['code'], 'unique'],
            [
                ['learning_category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => LearningCategory::class,
                'targetAttribute' => ['learning_category_id' => 'id']
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
            'order_id' => 'Order ID',
            'description' => 'Description',
            'learning_category_id' => 'Learning Category ID',
            'state' => 'State',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'data' => 'Data',
        ];
    }

    /**
     * Gets query for [[LearningCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLearningCategory()
    {
        return $this->hasOne(LearningCategory::class, ['id' => 'learning_category_id']);
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
