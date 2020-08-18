<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\commands\CorreoController;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RecoveryForm extends Model
{
    public $email;


    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email'], 'required'],
            ['email', 'email'],
            ['email', 'validateMail'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateMail($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $user = $this->getUser();

            if (!$user)
                $this->addError($attribute, 'Incorrect email.');
        }
    }



    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false)
            $this->_user = Yii::$app->user->identityClass::findByUsername($this->email);

        return $this->_user;
    }

    public function sendMail($token)
    {
        CorreoController::emailresetpassword($this->email,'App Web',$token);
        return true;
    }
}
