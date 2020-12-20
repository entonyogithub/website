<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;
<?php if(isset($tableSchema->columns['df'])): ?>
use yii\db\ActiveQuery;
<?php endif;?>
<?php if(isset($tableSchema->columns['created_at']) ||isset($tableSchema->columns['updated_at'])): ?>
use yii\behaviors\TimestampBehavior;
<?php endif;?>
<?php $field = '';?>
<?php if(isset($tableSchema->columns['photo'])): ?>
use mohorev\file\UploadImageBehavior;
<?php $field = 'photo';?>
<?php elseif(isset($tableSchema->columns['image'])): ?>
<?php $field = 'image';?>
use mohorev\file\UploadImageBehavior;
<?php elseif(isset($tableSchema->columns['logo'])): ?>
<?php $field = 'logo';?>
use mohorev\file\UploadImageBehavior;
<?php endif;?>

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($tableSchema->columns as $column): ?>
 * @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
<?php if(isset($tableSchema->columns['df'])): ?>
    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;
<?php endif;?>
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
    <?php if(isset($tableSchema->columns['created_at']) ||isset($tableSchema->columns['updated_at'])): ?>
       public function behaviors() {
        return [
            TimestampBehavior::className(),
            <?php if(isset($tableSchema->columns['photo']) ||isset($tableSchema->columns['image'])||isset($tableSchema->columns['logo'])): ?>
                [
                'class' => UploadImageBehavior::className(),
                'attribute' => '<?= $field;?>',
                'scenarios' => ['insert', 'update'],
                'generateNewName' => true,
                'instanceByName' => false,
                'createThumbsOnSave' => false,
                'path' => '@frontend/web/upload/original',
                'url' => '@fronturl/uploaded/original',
                ],
           <?php endif;?>
        ];
    }
    <?php endif;?>
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * @inheritdoc
     */
    public function rules()
    {       
        return [<?= "\n            " . implode(",\n            ", $rules) . "\n        " ?>,
        <?php if(isset($tableSchema->columns['photo']) ||isset($tableSchema->columns['image'])||isset($tableSchema->columns['logo'])): ?>
        ['<?= $field;?>', 'image', 'skipOnEmpty' => false, 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['insert']],
        ['<?= $field;?>', 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['update']],
        <?php endif;?>
        ];
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
    <?php if(isset($tableSchema->columns['df'])): ?>
    public static function find() {

            return new <?= $className ?>Query(get_called_class());
    }
    <?php endif;?>
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * @inheritdoc
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
}
<?php if(isset($tableSchema->columns['df'])): ?>
class <?= $className ?>Query extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => <?= $className ?>::NOT_DELETED]);
    }

}
<?php endif;?>
