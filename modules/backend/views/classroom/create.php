<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Classroom $model */

$this->title = 'Create Classroom';
$this->params['breadcrumbs'][] = ['label' => 'Classrooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classroom-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
