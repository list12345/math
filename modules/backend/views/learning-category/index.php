<?php

use app\models\LearningCategory;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\LearningCategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Learning Categories';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="learning-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Learning Category', [
            'create',
            'classroom_id' => $searchModel->classroom_id,
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
                    /* @var $data \app\models\LearningCategory */
                    return $data->getStateName($data->state);
                },
            ],
            [
                'class' => \yii\grid\ActionColumn::class,
                'header' => 'Actions',
                'template' => '{item} {update} {delete}',
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
                    /** @var $model LearningCategory */
                    if ($action === 'item') {
                        return ['learning-item/index/', 'learning_category_id' => $key];
                    }

                    return [
                        $action,
                        'id' => $key,
                        'classroom_id' => $model->classroom_id,
                    ];
                },
            ],
        ],
    ]); ?>

</div>
