<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LearningItem $model */

$this->title = 'Create Learning Item';
$this->params['breadcrumbs'][] = ['label' => 'Learning Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
