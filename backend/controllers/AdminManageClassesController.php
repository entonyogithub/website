<?php

namespace backend\controllers;

use Yii;
use common\models\StudentClass;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminManageClassesController implements the CRUD actions for StudentClass model.
 */
class AdminManageClassesController extends Controller {

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
     * Lists all StudentClass models.
     * @return mixed
     */
    public function actionIndex() {
        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $class = StudentClass::findOne($id);
            $output = ['output' => '', 'message' => 'Error'];
            if ($class) {
                $values = current($_POST['StudentClass']);
                $value = $values['taken_lectures'];
                $class->taken_lectures = $value;
                if ($class->validate()) {
                    $class->save();
                    $output = ['output' => $class->taken_lectures . ' / ' . $class->total_number_of_lectures, 'message' => ''];
                }
            }
            $out = \yii\helpers\Json::encode($output);
            echo $out;
            return;
        }
        if (Yii::$app->user->identity->role == "Teachers") {
            $teacher_classes = \yii\helpers\ArrayHelper::map(\common\models\TeacherClass::find()->where(['uid' => Yii::$app->user->id])->all(), 'class_id', 'class_id');
            $query = \common\models\StudentClass::find()->where(['in', 'id', $teacher_classes])->notDeleted()->orderBy('created_at DESC');
        } else {
            $query =\common\models\StudentClass::find()->notDeleted()->orderBy('created_at DESC');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentClass model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $addForm = new \backend\models\AddUserForm();
        $students = new ActiveDataProvider([
            'query' => \common\models\StudentJoinedClass::find()->where(['class_id' => $model->id])->orderBy('created_at DESC'),
        ]);
        $teachers = new ActiveDataProvider([
            'query' => \common\models\TeacherClass::find()->where(['class_id' => $model->id])->orderBy('created_at DESC'),
        ]);
        $topStudents = $this->BestStudents($model);
        return $this->render('view', [
                    'model' => $model,
                    'students' => $students,
                    'teachers' => $teachers,
                    'addForm' => $addForm,
                    'topStudents' => $topStudents
        ]);
    }

    /**
     * Creates a new StudentClass model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new StudentClass();
        if ($model->load(Yii::$app->request->post())) {
            $model->uid = Yii::$app->user->id;
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing StudentClass model.
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
        ]);
    }

    /**
     * Deletes an existing StudentClass model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->df = StudentClass::DELETED;
        $model->save(false);
        return $this->redirect(['index']);
    }

    public function actionAddStudent() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $addForm = new \backend\models\AddUserForm();
        if ($addForm->load(\Yii::$app->request->post())) {
            if ($addForm->validate()) {
                $exist_user = \common\models\StudentJoinedClass::find()->where(['uid' => $addForm->uid])->exists();
                if (!$exist_user) {
                    $student = new \common\models\StudentJoinedClass();
                    $student->uid = $addForm->uid;
                    $student->class_id = $addForm->class_id;
                    if ($student->save()) {
                        return ['success' => 1];
                    }
                } else {
                    return ['success' => 0, 'error' => 'User already joined to class'];
                }
            }
        }
    }

    public function actionAddTeacher() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $addForm = new \backend\models\AddUserForm();
        if ($addForm->load(\Yii::$app->request->post())) {
            if ($addForm->validate()) {
                $exist_user = \common\models\TeacherClass::find()->where(['uid' => $addForm->uid, 'class_id' => $addForm->class_id])->exists();
                if (!$exist_user) {
                    $teacher = new \common\models\TeacherClass();
                    $teacher->uid = $addForm->uid;
                    $teacher->class_id = $addForm->class_id;
                    if ($teacher->save()) {
                        return ['success' => 1];
                    }
                } else {
                    return ['success' => 0, 'error' => 'Teacher already added to the class'];
                }
            }
        }
    }

    public function actionDeleteTeacher($id) {
        $model = \common\models\TeacherClass::find()->where(['id' => $id])->one();
        $model->delete();
        return $this->redirect(['/admin-manage-classes/view?id=1#w11-tab1']);
    }

    public function actionDeleteStudent($id) {
        $model = \common\models\StudentJoinedClass::find()->where(['id' => $id])->one();
        $model->delete();
        return $this->redirect(['/admin-manage-classes/view?id=1#w11-tab2']);
    }

    private function BestStudents($class) {
        $students_arr = [];
        $students = \common\models\StudentJoinedClass::find()->where(['class_id' => $class->id])->all();
        if ($students) {
            foreach ($students as $student) {
                $user_uploads_count = \common\models\StudentUpload::find()->where(['uid' => $student->uid])->weekly()->count();
                $user_listening_count = \common\models\StudentListening::find()->where(['uid' => $student->uid])->weekly()->count();
                if ($user_uploads_count >= $class->total_number_of_recording && $user_listening_count >= $class->total_number_of_listening) {
                    $students_arr[] = [
                        'id' => $student->user->id,
                        'name' => $student->user->userProfile->first_name . " " . $student->user->userProfile->last_name,
                        'age' => $student->user->userProfile->age,
                    ];
                }
            }
        }
        return new \yii\data\ArrayDataProvider([
            'models' => $students_arr,
        ]);
        ;
    }

    /**
     * Finds the StudentClass model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentClass the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = StudentClass::find()->where(['id' => $id])->notDeleted()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
