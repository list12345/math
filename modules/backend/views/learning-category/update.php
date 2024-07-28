<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LearningCategory $model */

$this->title = 'Update Learning Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Learning Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="learning-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
