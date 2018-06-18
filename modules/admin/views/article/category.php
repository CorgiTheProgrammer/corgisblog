<?


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::dropDownList('category', $selectedCategory, $categories, ['class'=>'form-control']) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Set image', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
