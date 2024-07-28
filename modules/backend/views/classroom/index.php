<?php

use app\models\Classroom;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ClassroomSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Classrooms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classroom-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Classroom', [
            'create',
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
                'template' => '{category} {update} {delete}',
                'contentOptions' => ['width' => '10%'],
                'buttons' => [
                    'category' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', [
                            'class' => 'bi bi-card-list',
                            'style' => ['margin-left' => '5%']
                        ]), $url, [
                            'title' => 'Categories',
                            'aria-label' => 'Learning Categories',
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
                    'delete' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', [
                            'class' => 'bi bi-trash',
                            'style' => ['margin-left' => '5%']
                        ]), $url, [
                            'title' => 'Delete',
                            'aria-label' => 'Delete',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    /** @var $model \app\models\CatalogCategory */
                    if ($action === 'category') {
                        return ['learning-category/index/', 'classroom_id' => $key];
                    }

                    return [
                        $action,
                        'id' => $key,
                    ];
                },
            ],
        ],
    ]); ?>

</div>
