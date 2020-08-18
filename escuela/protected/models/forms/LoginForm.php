<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $captcha;

    private $_user = false;

    public function init()
    {
        $this->rememberMe = true;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            //[['captcha'], 'required'],
            //[['captcha'], 'captcha'],
            // rememberMe must be a boolean value
            //[['rememberMe'], 'boolean'],
            // password is validated by validatePassword()
            ['username', 'validateUserEstado'],
            ['password', 'validatePassword'],
            
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password))
                $this->addError($attribute, 'Incorrect username or password.');

        }
    }

    public function validateUserEstado($attribute, $params)
    {
        if(!$this->hasErrors())
        {
            $user = $this->getUser();

            if ($user['id_perfil'] != 1)
            {
                if(!$user['activo'])
                {
                    $this->addError($attribute, 'Debes contactar con el administrador de sistema.');
                }
            }
            
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate())
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24 : 0);

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false)
            $this->_user = Yii::$app->user->identityClass::findByUsername($this->username);

        return $this->_user;
    }
}
