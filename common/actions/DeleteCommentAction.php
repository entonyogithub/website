<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\actions;

use Yii;
use yii\web\ServerErrorHttpException;

/**
 * DeleteAction implements the API endpoint for deleting a model.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DeleteCommentAction extends \yii\base\Action {

    /**
     * Deletes a model.
     * @param mixed $id id of the model to be deleted.
     * @throws ServerErrorHttpException on failure.
     */
    public $modelClass;
    public $parentField;

    /**
     * @inheritdoc
     */
    public function init() {
        if ($this->modelClass === null && $this->parentField === null) {
            throw new InvalidConfigException(get_class($this) . '::$modelClass must be set.');
        }
    }

    public function run($id) {
        $model = $this->modelClass;
        $field = $this->parentField;
        $row = $model::find()->where(['id' => $id])->notDeleted()->one();
        if ($row) {
            $row->df = $model::DELETED;
            $row->save(false);
            Yii::$app->controller->redirect(['view','id'=>$row->$field,'#'=>'comments']);
        }
    }

}
