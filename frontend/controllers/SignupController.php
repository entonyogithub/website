<?php

namespace frontend\controllers;

use Yii;
use \frontend\models\SignupForm;
use yii\base\InvalidParamException;
use \yii\web\BadRequestHttpException;
use \common\models\User;
use \backend\models\Invitation;

class SignupController extends \yii\web\Controller {

    public function actionIndex($email, $token) {
        try {
            if ($invitation = Invitation::isValidInvitation($email, $token)) {
                $model = new SignupForm;
                $profile = new \common\models\Profile;
                $profile->scenario = 'insert';
                $countries = \yii\helpers\ArrayHelper::map(\common\models\Country::find()->all(), 'id', 'name');
                if ($model->load(Yii::$app->request->post())) {
                    $profile->load(Yii::$app->request->post());
                    if (\yii\base\Model::validateMultiple([$model, $profile])) {
                        $user = new \common\models\User;
                        $user->email = $model->email;
                        $user->setPassword($model->password);
                        $user->generateAuthKey();
                        $user->generateActiveKey();
                        $user->status = User::STATUS_ACTIVE;
                        if ($user->save(false)) {
                            $profile->uid = $user->id;
                            if ($profile->save(false)) {
                                $user->addRole('Member', $user);
                                $invitation->used = Invitation::USED;
                                $invitation->save(false);
                                Yii::$app->getSession()->setFlash('success',Yii::t('app','Thanks you for your registeration {link}',['link'=>  \yii\helpers\Html::a(Yii::t('app','Here'),'/login')]));
                                return $this->redirect('/confirmation');
                            }

                            if (Yii::$app->getUser()->login($user)) {
                                return $this->goHome();
                            }
                        }
                    }
                }
                return $this->render('index', [
                            'model' => $model,
                            'profile' => $profile,
                            'countries' => $countries
                ]);
            } else
                throw new \yii\base\InvalidParamException(Yii::t('app', 'Incorect email or Token sent'));
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

}
