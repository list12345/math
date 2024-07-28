<?php

namespace app\models;

use app\models\classes\behaviors\TimestampBehavior;
use app\models\classes\State;
use app\models\classes\StateTrait;
use Yii;

/**
 * This is the model class for table "classroom".
 *
 * @property int $id
 * @property string|null $name
 * @property int $order_id
 * @property string|null $description
 * @property int $state
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $data
 *
 * @property LearningCategory[] $learningCategories
 */
class Classroom extends \yii\db\ActiveRecord
{
    use StateTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{classroom}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name',], 'filter', 'filter' => 'trim', 'skipOnArray' => true, 'skipOnEmpty' => true],
            [['order_id', 'created_at'], 'required'],
            [['order_id',], 'default', 'value' => null],
            [['state'], 'default', 'value' => State::DISABLED],
            [['state'], 'in', 'range' => [State::DISABLED, State::ENABLED]],
            [['order_id', 'state'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'data'], 'safe'],
            [['name'], 'string', 'max' => 64],
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
            'name' => 'Name',
            'order_id' => 'Order ID',
            'description' => 'Description',
            'state' => 'State',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'data' => 'Data',
        ];
    }

    /**
     * Gets query for [[LearningCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLearningCategories()
    {
        return $this->hasMany(LearningCategory::class, ['classroom_id' => 'id']);
    }
}
