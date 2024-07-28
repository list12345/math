<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LearningItem $model */

$this->title = 'Update Learning Item: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Learning Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="learning-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
