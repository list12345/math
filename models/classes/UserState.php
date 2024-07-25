<?php

namespace app\models\classes;

/**
 * Class UserState
 */
class UserState extends Enum
{
    /** @const int */
    const STATUS_NEW = 0;
    /** @const int */
    const STATUS_ACTIVE = 1;
    /** @const int */
    const STATUS_BLOCKED = 2;
    /** @const int */
    const STATUS_DELETED = 3;
}
