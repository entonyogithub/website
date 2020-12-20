<?php

namespace backend\controllers;

use Yii;
use common\models\AttendanceLog;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

/**
 * AdminManageAttendanceLogsController implements the CRUD actions for AttendanceLog model.
 */
class AdminManageAttendanceLogsController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AttendanceLog models.
     * @return mixed
     */
    public function actionIndex() {
        $options = [
            'name' => 'file',
            'language' => 'en',
            'pluginOptions' => [
                'showUpload' => false,
                'showRemove' => false,
                'showPreview' => false,
                'showCancel' => false,
                'browseClass' => 'btn btn-default btn-block',
                'browseLabel' => Yii::t('app', 'Add file'),
                'uploadLabel' => Yii::t('app', 'Upload'),
                'removeLabel' => Yii::t('app', 'Remove'),
            ],
            'options' => ['accept' => 'application/vnd.ms-excel',],
        ];
        $model = new \backend\models\ImportForm;
        $dataProvider = new ActiveDataProvider([
            'query' => AttendanceLog::find(),
        ]);


        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'options' => $options,
                    'model' => $model
        ]);
    }

    /**
     * Displays a single AttendanceLog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AttendanceLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AttendanceLog();
        $users = \yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['role' => 'Users'])->active()->orderBy('created_at DESC')->all(), 'id', 'username');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'users' => $users
        ]);
    }

    /**
     * Updates an existing AttendanceLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $users = \yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['role' => 'Users'])->active()->orderBy('created_at DESC')->all(), 'id', 'username');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
                    'model' => $model,
                    'users' => $users
        ]);
    }

    /**
     * Deletes an existing AttendanceLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionImport() {
        if (\Yii::$app->request->isAjax) {
            $arr = ['success' => 1, 'error' => ''];
            $file_path = $_FILES['ImportForm']['tmp_name']['file'];
            if ($_FILES['ImportForm']['type']['file'] == 'application/vnd.ms-excel' || $_FILES['ImportForm']['type']['file'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
//                try{
                $reader = ReaderEntityFactory::createXLSXReader();
                $reader->open($file_path);
                $erros = 'Error while importing ' . "<br/>";
                foreach ($reader->getSheetIterator() as $sheet) {
                    foreach ($sheet->getRowIterator() as $key => $row) {

                        if ($key != 1) {
                            $values = $row->toArray();
                            $user_id = $values[0];
                            $profile = \common\models\UserProfile::find()->where(['finger_print_id' => $user_id])->one();
                            if ($profile) {
                                $log = new AttendanceLog();
                                $log->uid = $profile->uid;
                                $log->start_titme = $values[3]->format("H:i");
                                $log->end_time = $values[4]->format("H:i");
                                $log->duration = $values[9]->format("H:i");
                                $log->date = \Yii::$app->formatter->asDate($values[11], "php:Y-m-d");
                                if ($log->validate()) {
                                    $log->save();
                                } else {
                                    $model_erros = \kartik\form\ActiveForm::validate($log);
                                    $errors = implode(',', \backend\helpers\CustomHelper::setErrorResponse($model_erros));
                                    $reference_num = 'member #' . $log->uid . ':' . "<br/>" . $errors;
                                    $erros .= $reference_num;
                                    $arr['error'] = $erros;
                                }
                            }
                        }
                    }
                }
                $reader->close();
//                }catch(\ErrorException $e){
//                    $arr['error'] = $e->getMessage();
//                    
//                }
            } else {
                $arr['error'] = 'Not sported file type';
            }
            echo json_encode($arr);
        }
    }

    /**
     * Finds the AttendanceLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AttendanceLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AttendanceLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
