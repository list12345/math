<?php
namespace app\models\classes\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;

/**
 * Class TimestampBehavior
 */
class TimestampBehavior extends Behavior
{
    /** @var string */
    public $createdAtAttribute = 'created_at';
    /** @var string */
    public $updatedAtAttribute = 'updated_at';
    /** @var array */
    public $except_scenarios = ['search'];

    /**
     * @return array
     */
    public function events()
    {
        return [BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate'];
    }

    /**
     * @param $event
     */
    public function beforeValidate($event)
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        if (!in_array($owner->getScenario(), $this->except_scenarios)) {
            if ($owner->getIsNewRecord()) {
                $owner->setAttribute($this->createdAtAttribute, date('Y-m-d H:i:s', time()));
            } else {
                if ($owner->hasAttribute($this->updatedAtAttribute)) {
                    $owner->setAttribute($this->updatedAtAttribute, date('Y-m-d H:i:s', time()));
                }
            }
        }
    }
}
