<?php

namespace app\models;

use app\models\classes\UserState;
use app\models\classes\UserStateTrait;
use Yii;
use yii\base\NotSupportedException;
use app\models\classes\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $firstname
 * @property string $lastname
 * @property string $customer_company_id
 */
class User extends ActiveRecord implements IdentityInterface
{
    use UserStateTrait;

    /** @var null */
    protected $_user_roles = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => UserState::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     *
     * @throws \yii\base\NotSupportedException
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => UserState::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => UserState::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status'], 'default', 'value' => UserState::STATUS_NEW],
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
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['firstname', 'lastname',], 'string', 'max' => 128],
            [
                'email',
                'unique',
                'message' => 'This email has already been taken.',
            ],
            [['password_reset_token'], 'unique'],
            [
                'username',
                'unique',
                'message' => 'This username has already been taken.',
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
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'customer_company_id' => 'Customer Company',
        ];
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @throws \yii\base\InvalidParamException
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     *
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     *
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     *
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @param $role
     *
     * @return null|\yii\rbac\Role
     */
    public function getRole($role)
    {
        $result = null;

        if (!$this->_user_roles) {
            $this->_user_roles = Yii::$app->authManager->getRolesByUser($this->getId());
        }
        if (isset($this->_user_roles[$role])) {
            $result = $this->_user_roles[$role];
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return array
     */
    public function getUserRolesList()
    {
        return is_array($this->getUserRoles()) ? array_keys($this->getUserRoles()) : [];
    }

    /**
     * @return null|\yii\rbac\Role[]
     */
    public function getUserRoles()
    {
        if (!$this->_user_roles) {
            $this->_user_roles = Yii::$app->authManager->getRolesByUser($this->getId());
        }

        return $this->_user_roles;
    }
}
