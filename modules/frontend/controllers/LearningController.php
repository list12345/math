<?php

namespace app\modules\frontend\controllers;

use app\models\CatalogCategory;
use app\models\CatalogItem;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CatalogController implements the CRUD actions for CatalogItem model.
 */
class LearningController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all CatalogItem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $categories = CatalogCategory::find()->where(['state' => 1])->orderBy(['level' => SORT_DESC, 'order_id' => SORT_ASC])->all();
        $menu = [];
        $root_id =1;
        foreach ($categories as $category) {
            /** @var CatalogCategory $category */
            if ($category->parent_id != null) {
                if(empty($menu['c-' . $category->id])) {
                    if ($category->level > 1) {
                        $menu['c-' . $category->parent_id][$category->order_id] =   ['label' => $category->name, 'url' => ['catalog/index', 'id' => $category->id]];
                    } else {
                        $menu[$category->order_id] =   ['label' => $category->name, 'url' => ['catalog/index', 'id' => $category->id]];
                    }
                } else {
                    if ($category->level > 1) {
                        $menu['c-' . $category->parent_id][$category->order_id] =  ['label' => $category->name, 'items' => $menu['c-' . $category->id], 'linkOptions' => [
                            'class' => 'nav-link',
                        ]];
                    } else {
                        $menu[$category->order_id] =  ['label' => $category->name, 'items' => $menu['c-' . $category->id]];
                    }
                    unset($menu['c-' . $category->id]);
                }
            }
        }

        return $this->render('index', ['menu' => $menu]);
    }

    /**
     * Displays a single CatalogItem model.
     *
     * @param int $id ID
     *
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CatalogItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new CatalogItem();
        $model->catalog_category_id = Yii::$app->request->get('catalog_category_id');
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CatalogItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id ID
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CatalogItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id ID
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CatalogItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     *
     * @return CatalogItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatalogItem::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
