<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LearningCategory $model */

$this->title = 'Create Learning Category';
$this->params['breadcrumbs'][] = ['label' => 'Learning Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
