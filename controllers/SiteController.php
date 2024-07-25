<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\forms\UserForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout', 'create',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\Exception
     * @throws \Exception
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new UserForm();
        $form->setScenario($form::SCENARIO_INSERT);
        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {
                $model = new User();
                $model->setAttributes($form->toArray());
                $model->generateAuthKey();
                $model->setPassword($form->password);
                if ($model->save()) {
                    $this->saveUserRoles($model->getId(), ['user']);

                    return $this->redirect(['index']);
                }
                $form->addErrors($model->getErrors());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param $user_id
     * @param array $roles
     *
     * @throws \Exception
     */
    protected function saveUserRoles($user_id, array $roles = [])
    {
        /** @var DbManager $auth */
        $auth = Yii::$app->authManager;
        // revoke roles
        /** @var array $available_roles */
        $available_roles = array_keys($auth->getRoles());
        foreach ($available_roles as $name) {
            $auth->revoke($auth->getRole($name), $user_id);
        }

        // assigning roles
        foreach ($roles as $name) {
            if (!array_key_exists($name, $auth->getRolesByUser($user_id))) {
                $auth->assign($auth->getRole($name), $user_id);
            }
        }
    }
}
