<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CatalogCategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\CatalogCategory $parent_model */

$this->title = 'Catalog Categories';
$this->params['breadcrumbs'][] = [
    'label' => 'Parent Catalog Categories',
    'url' => [
        'index',
        'parent_id' => $parent_model instanceof \app\models\CatalogCategory ? $parent_model->parent_id : null
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Catalog Category', [
            'create',
            'parent_id' => $searchModel->parent_id
        ], ['class' => 'btn btn-primary btn-sm']) ?>
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
            'name',
            'order_id',
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
                'class' => \yii\grid\ActionColumn::class,
                'header' => 'Actions',
                'template' => '{category} {item} {update}',
                'contentOptions' => ['width' => '10%'],
                'buttons' => [
                    'category' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', [
                            'class' => 'bi bi-card-list',
                            'style' => ['margin-left' => '5%']
                        ]), $url, [
                            'title' => 'Categories',
                            'aria-label' => 'Categories',
                            'data-pjax' => '0',
                        ]);
                    },
                    'item' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', [
                            'class' => 'bi bi-folder',
                            'style' => ['margin-left' => '5%']
                        ]), $url, [
                            'title' => 'Items',
                            'aria-label' => 'Items',
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', [
                            'class' => 'bi bi-pencil',
                            'style' => ['margin-left' => '5%']
                        ]), $url, [
                            'title' => 'Edit',
                            'aria-label' => 'Edit',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    /** @var $model \app\models\CatalogCategory */
                    if ($action === 'category') {
                        return ['catalog-category/index/', 'parent_id' => $key];
                    }
                    if ($action === 'item') {
                        return ['catalog-item/index/', 'catalog_category_id' => $key];
                    }

                    return [
                        $action,
                        'id' => $key,
                        'parent_id' => $model->parent_id,
                    ];
                },
            ],
        ],
    ]); ?>

</div>
