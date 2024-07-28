<?php

namespace app\models;

use app\models\classes\behaviors\TimestampBehavior;
use app\models\classes\State;
use app\models\classes\StateTrait;
use Yii;

/**
 * This is the model class for table "learning_category".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $classroom_id
 * @property int $order_id
 * @property string|null $description
 * @property int $state
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $data
 *
 * @property Classroom $classroom
 * @property LearningItem[] $learningItems
 */
class LearningCategory extends \yii\db\ActiveRecord
{
    use StateTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'learning_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'classroom_id', 'order_id',], 'filter', 'filter' => 'trim', 'skipOnArray' => true, 'skipOnEmpty' => true],
            [['classroom_id', 'order_id', 'state'], 'default', 'value' => null],
            [['classroom_id', 'order_id', 'state'], 'integer'],
            [['state'], 'default', 'value' => State::DISABLED],
            [['state'], 'in', 'range' => [State::DISABLED, State::ENABLED]],
            [['order_id', 'created_at'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'data'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [
                ['classroom_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Classroom::class,
                'targetAttribute' => ['classroom_id' => 'id']
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
            'name' => 'Name',
            'classroom_id' => 'Classroom ID',
            'order_id' => 'Order ID',
            'description' => 'Description',
            'state' => 'State',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'data' => 'Data',
        ];
    }

    /**
     * Gets query for [[Classroom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClassroom()
    {
        return $this->hasOne(Classroom::class, ['id' => 'classroom_id']);
    }

    /**
     * Gets query for [[LearningItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLearningItems()
    {
        return $this->hasMany(LearningItem::class, ['learning_category_id' => 'id']);
    }
}
