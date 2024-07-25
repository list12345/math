<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CatalogItem $model */

$this->title = 'Update Catalog Item: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Catalog Items', 'url' => ['index', 'catalog_category_id' => $model->catalog_category_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="catalog-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
