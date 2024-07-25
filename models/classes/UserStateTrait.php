<?php

namespace app\models\classes;

/**
 * Trait UserStateTrait
 */
trait UserStateTrait
{
    /**
     * @param $state
     *
     * @return string
     */
    public function getStateName($state)
    {
        $states = $this->getStateList();

        return isset($states[$state]) ? $states[$state] : 'unknown';
    }

    /**
     * @return array
     */
    public function getStateList()
    {
        $states = [
            UserState::STATUS_NEW => 'New',
            UserState::STATUS_ACTIVE => 'Active',
            UserState::STATUS_BLOCKED => 'Blocked',
            UserState::STATUS_DELETED => 'Deleted',
        ];

        return $states;
    }
}
