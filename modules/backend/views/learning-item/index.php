<?php

use app\models\LearningItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\LearningItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Learning Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Learning Item', [
            'create',
            'learning_category_id' => $searchModel->learning_category_id,
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
            'code',
            'name',
            [
                'attribute' => 'order_id',
                'contentOptions' => ['width' => '10%'],
            ],
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
                'class' => ActionColumn::class,
                'contentOptions' => ['width' => '10%'],
                'urlCreator' => function ($action, LearningItem $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
