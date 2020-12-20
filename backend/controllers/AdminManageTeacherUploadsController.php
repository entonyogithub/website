<?php

namespace backend\controllers;

use Yii;
use common\models\TeacherUpload;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminManageTeacherUploadsController implements the CRUD actions for TeacherUpload model.
 */
class AdminManageTeacherUploadsController extends Controller {

    private $_classes = [];

    public function beforeAction($action) {
        parent::beforeAction($action);
        if ($action->id == 'update' || $action->id == 'create' || $action->id == 'index') {
            if (Yii::$app->user->identity->role == "Teachers") {
                $teacher_classes = \yii\helpers\ArrayHelper::map(\common\models\TeacherClass::find()->where(['uid' => Yii::$app->user->id])->all(), 'class_id', 'class_id');
                $this->_classes = \yii\helpers\ArrayHelper::map(\common\models\StudentClass::find()->where(['in', 'id', $teacher_classes])->notDeleted()->all(), 'id', 'title');
            } else {
                $this->_classes = \yii\helpers\ArrayHelper::map(\common\models\StudentClass::find()->notDeleted()->all(), 'id', 'title');
            }
        }
        return true;
    }

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
     * Lists all TeacherUpload models.
     * @return mixed
     */
    public function actionIndex() {
        $search = new \backend\models\UploadsSearch();
        $dataProvider = $search->search(\Yii::$app->request->queryParams);


        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                     'classes' => $this->_classes,
                     'search'=>$search
        ]);
    }

    /**
     * Displays a single TeacherUpload model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TeacherUpload model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TeacherUpload();
        $model->scenario = "insert";
        $file_options = \backend\helpers\CustomHelper::getImageOptions($model, 'file');
        if ($model->load(Yii::$app->request->post())) {
            $model->uid = Yii::$app->user->id;
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'classes' => $this->_classes,
                    'file_options' => $file_options
        ]);
    }

    /**
     * Updates an existing TeacherUpload model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->scenario = "update";
        $file_options = \backend\helpers\CustomHelper::getImageOptions($model, 'file');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
                    'model' => $model,
                    'classes' => $this->_classes,
                    'file_options' => $file_options
        ]);
    }

    /**
     * Deletes an existing TeacherUpload model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->df = TeacherUpload::DELETED;
        $model->save(false);
        return $this->redirect(['index']);
    }

    /**
     * Finds the TeacherUpload model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TeacherUpload the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TeacherUpload::find()->where(['id' => $id])->notDeleted()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
