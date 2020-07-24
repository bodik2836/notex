<?php

namespace app\controllers;

use app\models\Code;
use app\models\HomeForm;
use app\models\Posts;
use app\models\User;
use app\models\UserIdentity;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
        $user_id = Yii::$app->user->id;
        $posts = Posts::getPosts($user_id);
        $model = new HomeForm();

        if (Yii::$app->user->isGuest)
        {
            return $this->render('index');
        } else {

            if ($model->load(Yii::$app->request->post()) && $model->addPost($user_id)) {
                return $this->refresh();
            }

            return $this->render('home', [
                'posts' => $posts,
                'model' => $model
            ]);
        }

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
    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionHome()
    {
        $user_id = Yii::$app->user->id;
        $posts = Posts::getPosts($user_id);
        $model = new HomeForm();

        if ($model->load(Yii::$app->request->post()) && $model->addPost($user_id)) {
            return $this->refresh();
        }

        return $this->render('home', [
            'model' => $model,
            'posts' => $posts
        ]);
    }

    public function actionDelete($post_id) {

        if (!ctype_digit($post_id)) {
            return $this->redirect(['site/home']);
        }

        $post = Posts::findOne($post_id);
        $post->delete();

        return $this->redirect(['site/home']);
    }


}
