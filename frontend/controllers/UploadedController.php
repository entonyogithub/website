<?php

namespace frontend\controllers;

use Yii;
use \yii\web\NotFoundHttpException;
use yii\imagine\Image;
use \yii\helpers\Url;
use \yii\helpers\Html;

class UploadedController extends \yii\web\Controller {

    public $uploadDir = 'original';
    public $uploadUrl = '@fronturl/upload/original';
    public $uploadPath = '@frontend/web/upload/original';

    /**
     * Accept the image uploaded and check style 
     * @param type $dir
     * @param type $image
     * @throws NotFoundHttpException
     */
    public function actionIndex($dir, $image) {
        header("Content-Type: image");
        if ($dir != $this->uploadDir) {
            if (isset(\Yii::$app->params['image'][$dir])) {
                $config_arr = \Yii::$app->params['image'][$dir];
                $original_image_path = \Yii::getAlias($this->uploadPath) . '/' . $image;
                if (file_exists($original_image_path)) {
                    $request_image_path = \Yii::getAlias($config_arr['path']) . '/' . $image;
                    if (!file_exists($request_image_path)) {
                        $width = $config_arr['width'];
                        $height = $config_arr['height'];
                        $this->generateImageThumb($width, $height, $original_image_path, $request_image_path);
                        readfile($request_image_path);
                    } else {
                        readfile($request_image_path);
                    }
                } else
                    throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
            } else
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        } else {
            $original_image_path = \Yii::getAlias($this->uploadPath) . '/' . $image;
            if (file_exists($original_image_path)) {
               readfile($original_image_path);
            } else
                throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
    }

    /**
     * Create img style using imagine lib 
     * @param int $width
     * @param int $height
     * @param string $path
     * @param string $thumbPath
     */
    private function generateImageThumb($width, $height, $path, $thumbPath) {
        $quality = 100;

        if (!$width || !$height) {
            $image = Image::getImagine()->open($path);
            $ratio = $image->getSize()->getWidth() / $image->getSize()->getHeight();
            if ($width) {
                $height = ceil($width / $ratio);
            } else {
                $width = ceil($height * $ratio);
            }
        }

        // Fix error "PHP GD Allowed memory size exhausted".
        ini_set('memory_limit', '512M');
        Image::thumbnail($path, $width, $height)->save($thumbPath, ['quality' => $quality]);
    }

}
