<?php

use app\models\Tag;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Video */
/* @var $image app\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => 255]) ?>

    <?= $form->field($model, 'embed_code')->textarea(['maxlength' => 255]) ?>
    <?php
    echo '<label class="control-label">Tags</label>';
    echo Select2::widget([
        'name' => 'tags',
        'value' => $model->getStringTags($model->id),
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

<!--    --><?//= $form->field($upload, 'file[]')->fileInput(['multiple' => true]) ?>

   <?php
   echo $form->field($upload, 'file[]')->widget(FileInput::classname(), [
    'options'=>['accept'=>'image/*','multiple' => true],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']],
    ]);
   ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
