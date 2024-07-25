<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\classes\UserState;
use app\models\classes\UserStateTrait;

/**
 * Class UserForm
 */
class UserForm extends Model
{
    use UserStateTrait;

    /** @const */
    const SCENARIO_INSERT = 'insert';
    /** @const */
    const SCENARIO_UPDATE = 'update';

    /** @var array */
    public $assigned_roles;
    /** @var string */
    public $username;
    /** @var string */
    public $email;
    /** @var integer */
    public $status;
    /** @var string */
    public $firstname;
    /** @var string */
    public $lastname;
    /** @var */
    public $password;
    /** @var */
    public $password1;

    /**
     * returns associative array of available roles for a user
     *
     * @return array
     */
    public static function getAvailableRoles()
    {
        $roles = array_keys(Yii::$app->authManager->getRoles());

        return array_combine($roles, $roles);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password1'], 'required', 'on' => self::SCENARIO_INSERT],
            [['username', 'email'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['status'], 'default', 'value' => UserState::STATUS_ACTIVE], // change later after confirmation email
            [['assigned_roles'], 'default', 'value' => []],
            [['firstname', 'lastname'], 'default'],
            [['status'], 'integer'],
            [
                ['status'],
                'in',
                'range' => [
                    UserState::STATUS_NEW,
                    UserState::STATUS_ACTIVE,
                    UserState::STATUS_BLOCKED,
                    UserState::STATUS_DELETED,
                ],
            ],
            [
                ['assigned_roles'],
                'each',
                'rule' => ['in', 'range' => array_keys(Yii::$app->authManager->getRoles())],
            ],
            [['password', 'password1'], 'string', 'min' => 8, 'max' => 64, 'on' => self::SCENARIO_INSERT],
            ['password1', 'compare', 'compareAttribute' => 'password', 'on' => self::SCENARIO_INSERT],
            [['username', 'email'], 'string', 'max' => 255],
            [['firstname', 'lastname'], 'string', 'max' => 128],
            [['username', 'email', 'firstname', 'lastname'], 'filter', 'filter' => 'trim'],
            [
                ['username', 'email', 'password', 'password1', 'firstname', 'lastname'],
                'filter',
                'filter' => 'trim',
                'on' => self::SCENARIO_INSERT,
            ],
            [['password', 'password1'], 'safe', 'on' => self::SCENARIO_INSERT],
            [
                ['username', 'email', 'firstname', 'lastname', 'status', 'assigned_roles'],
                'safe',
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'password1' => 'Confirm Password',
            'email' => 'Email',
            'status' => 'Status',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
        ];
    }
}
