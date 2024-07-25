<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CatalogCategory $model */

$this->title = 'Create Catalog Category';
$this->params['breadcrumbs'][] = ['label' => 'Catalog Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Parent Catalog Categories', 'url' => ['index', 'parent_id' => $model->parent_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
