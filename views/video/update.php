<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VIdeo */

$this->title = 'Update Video: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="video-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'image' => $image,
        'upload' => $upload,
    ]) ?>

</div>
