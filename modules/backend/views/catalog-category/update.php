<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CatalogCategory $model */

$this->title = 'Update Catalog Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Catalog Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="catalog-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
