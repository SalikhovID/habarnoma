<?php

namespace frontend\models;

use common\constants\Status;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    public $repeat_password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Required fields
            [['username', 'first_name', 'last_name', 'password', 'repeat_password'], 'required'],

            // String length validation
            [['username'], 'string', 'min' => 3, 'max' => 255],
            [['first_name', 'last_name'], 'string', 'min' => 2, 'max' => 100],
            [['password'], 'string', 'min' => 6, 'max' => 255],

            // Username uniqueness (assuming User model)
            [['username'], 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],

            // Username format (alphanumeric and underscore only)
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => 'Username can only contain letters, numbers and underscore.'],

            // Name validation (letters, spaces, hyphens only)
            [['first_name', 'last_name'], 'match', 'pattern' => '/^[a-zA-Z\s\-]+$/', 'message' => 'Name can only contain letters, spaces and hyphens.'],

            // Password confirmation
            [['repeat_password'], 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],

            // Trim whitespace
            [['username', 'first_name', 'last_name'], 'trim'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->username;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->status = Status::ACTIVE->value;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        return $user->save();
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
