<?php

namespace backend\controllers;

use Yii;
use common\models\Assignment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminManageAssignmentsController implements the CRUD actions for Assignment model.
 */
class AdminManageAssignmentsController extends Controller {

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
     * Lists all Assignment models.
     * @return mixed
     */
    public function actionIndex() {
        
        $search = new \backend\models\AssignmentSearch();
        $dataProvider = $search->search(\Yii::$app->request->queryParams);


        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                     'classes' => $this->_classes,
                     'search'=>$search
        ]);
    }

    /**
     * Displays a single Assignment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Assignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Assignment();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'classes' => $this->_classes,
        ]);
    }

    /**
     * Updates an existing Assignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
                    'model' => $model,
                    'classes' => $this->_classes,
        ]);
    }

    /**
     * Deletes an existing Assignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->df = Assignment::DELETED;
        $model->save(false);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Assignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Assignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Assignment::find()->where(['id' => $id])->notDeleted()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
