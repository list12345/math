<?php

namespace app\models\classes;

/**
 * Class StateTrait
 */
trait StateTrait
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
            State::ENABLED => 'Enabled',
            State::DISABLED => 'Disabled',
        ];

        return $states;
    }
}
