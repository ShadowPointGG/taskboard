<?php

namespace app\models\usermodels;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class InviteForm extends Model
{
    public $username;
    public $first_name;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\usermodels\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['first_name','trim'],
            ['first_name','required'],
            ['first_name','string', 'min' => 2, 'max'=>50],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\usermodels\User', 'message' => 'This email address has already been taken.'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function invite()
    {
        if (!$this->validate()) {
            return null;
        }

        $string = Yii::$app->security->generateRandomString(12);
        
        $user = new User();
        $user->username = $this->username;
        $user->first_name = $this->first_name;
        $user->email = $this->email;
        $user->setPassword($string);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        return $user->save() && $this->sendEmail($user, $string);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user, $password)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'user-invite_html', 'text' => 'user-invite_txt'],
                ['user' => $user, 'password' => $password]
            )
            ->setFrom(Yii::$app->params['senderEmail'])
            ->setTo($this->email)
            ->setSubject(COMPANY_NAME . ' has invited you to ' . APPLICATION_NAME)
            ->send();
    }
}
