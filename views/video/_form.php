<?php

use app\models\Tag;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VIdeo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => 255]) ?>

    <?= $form->field($model, 'embed_code')->textarea(['maxlength' => 255]) ?>
    <?php
    echo '<label class="control-label">Tags</label>';
    echo Select2::widget([
        'name' => 'tags',
        'value' => $model->getStringTags(),
        'options' => [
            'name' => 'tag_list',
            'placeholder' => 'Select a color ...',
            'class' => 'form-control'
        ],
        'pluginOptions' => [
            'tags' => $model->getDropTags(),
            'maximumInputLength' => 10
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
