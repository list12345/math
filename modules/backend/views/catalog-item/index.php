<?php

use app\models\CatalogItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CatalogItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Catalog Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Catalog Item', ['create', 'catalog_category_id' => $searchModel->catalog_category_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'contentOptions' => ['width' => '10%'],
            ],
            'code',
            'name',
            'type',
            [
                'attribute' => 'order_id',
                'contentOptions' => ['width' => '10%'],
            ],
            [
                'attribute' => 'state',
                'contentOptions' => ['width' => '20%'],
                'filter' => $searchModel->getStateList(),
                'value' => function ($data) {
                    /* @var $data \app\models\CatalogCategory */
                    return $data->getStateName($data->state);
                },
            ],
            [
                'class' => ActionColumn::class,
                'contentOptions' => ['width' => '10%'],
                'urlCreator' => function ($action, CatalogItem $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
