<?php

namespace backend\controllers;

use Yii;
use common\models\Syllabus;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminManageRecordsController implements the CRUD actions for Syllabus model.
 */
class AdminManageRecordsController extends Controller {

    private $_classes = [];

    public function beforeAction($action) {
        parent::beforeAction($action);
        if ($action->id == 'update' || $action->id == 'create') {
            $this->_classes = \yii\helpers\ArrayHelper::map(\common\models\StudentClass::find()->notDeleted()->all(), 'id', 'title');
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
     * Lists all Syllabus models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Syllabus::find()->notDeleted(),
        ]);
        
        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $user = User::findOne($id);
            $output = ['output' => '', 'message' => 'Error'];
            if ($user) {
                $values = current($_POST['User']);
                $value = $values['status'];
                $user->status = $value;
                if ($user->validate()) {
                    $user->save();
                    $output = ['output' => Yii::$app->params['userStatus'][$user->status], 'message' => ''];
                }
            }
            $out = \yii\helpers\Json::encode($output);
            echo $out;
            return;
        }

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Syllabus model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Syllabus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Syllabus();
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
     * Updates an existing Syllabus model.
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
     * Deletes an existing Syllabus model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->df = Syllabus::DELETED;
        $model->save(false);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Syllabus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Syllabus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Syllabus::find()->where(['id' => $id])->notDeleted()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
