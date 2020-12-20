<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Notification extends Component {

    /**
     * Trigger emails after get the proper function
     * @param type $event
     * @param type $data
     */
    public function Trigger($event, $data = array()) {
        if (method_exists($this, $event)) {
            return $this->$event($data);
        }
    }

    /**
     * Auto reply for in contact us form 
     * @param array $data
     */
    public function AutoReplay($data) {
        
    }

    /**
     * Auto reply for in contact us form 
     * @param array $data
     */
    public function VolunteerRequest($data) {
        return \Yii::$app->mailer->compose('Volunteer-request-html', ['model' => $data['model']])
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                        ->setTo($data['email'])
                        ->setSubject('Password reset for ' . \Yii::$app->name)
                        ->send();
    }

    /**
     * email when user register on the website 
     * @param array $data
     */
    public function Register($data) {
        return \Yii::$app->mailer->compose('Register-html', ['user' => $data['user']])
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                        ->setTo($data['email'])
                        ->setSubject('Password reset for ' . \Yii::$app->name)
                        ->send();
    }

    /**
     * confimation after user register 
     * @param array $data
     */
    public function AfterRegister($data) {
        
    }

    /**
     * reset password email 
     * @param array $data
     */
    public function ForgetPass($data) {

        return \Yii::$app->mailer->compose(
                                ['html' => 'passwordResetToken-html',
                            'text' => 'passwordResetToken-text'], ['user' => $data['user']])
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                        ->setTo($data['email'])
                        ->setSubject('Password reset for ' . \Yii::$app->name)
                        ->send();
    }

    public function SendInvitation($data) {

        return \Yii::$app->mailer->compose('SendInvitation-html', ['invitation' => $data['invitation']])
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                        ->setTo($data['email'])
                        ->setSubject(\Yii::$app->name . ' Invitation')
                        ->send();
    }

}
