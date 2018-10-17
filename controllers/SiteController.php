<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Buku;
use app\models\User;
use Mpdf\Mpdf;
use app\models\RegisterForm;
use app\models\Anggota;
use app\models\ForgetPasswordForm;


class SiteController extends Controller
{
    // public $layout = 'main';
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


    public function actionSendEmail()
   {
       return Yii::$app->mail->compose()
       ->setFrom('mahmudanurinayatun@gmail.com')
       ->setTo('0896377@gmail.com')
       ->setSubject('Coba')
       ->setTextBody('<b>hallo guys</b>')
       ->send();
   }

   public function actionForget()
  {
      $this->layout = 'main-login';
      $model = new ForgetPasswordForm();

      if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          if (!$model->Email()) {
              Yii::$app->session->setFlash('Gagal', 'Email tidak ditemukan');
              return $this->refresh();
          }
          else
          {
              Yii::$app->session->setFlash('Berhasil', 'Cek Email Anda');
              return $this->redirect(['site/login']);
          }
      }
      return $this->render('forget', [
          'model' => $model,
      ]);
  }

    public function actionNewPassword($token)
    {
       $this->layout = 'main-login';
       $model = new NewPassword();

       // Untuk mendapatkan token yang ada di tabel user yang dimana sudah di relasikan di anggota model
       $user = User::findOne(['token' => $token]);

       if ($user === null) {
           throw new NotFoundHttpException("Halaman tidak ditemukan", 404);
       }

       if ($model->load(Yii::$app->request->post()) && $model->validate()) {
           $user->password = Yii::$app->getSecurity()->generatePasswordHash($model->new_password);
           $user->token = Yii::$app->getSecurity()->generateRandomString(50);
           $user->save();
           return $this->redirect(['site/login']);
       }

       return $this->render('new_password', [
           'model' => $model,
       ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main';

        if (User::isAdmin() || User::isAnggota() || User::isPetugas()) {
            return $this->render('index');
        } else {
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'main';

        // if (!Yii::$app->user->isGuest) {
        //     return $this->goHome();
        // }

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

    public function actionRegister()
   {
       //agar secara otomatis membuat sendiri
       $this->layout='main-login';
       //$model untuk layout register
       $model = new RegisterForm();

       if ($model->load(Yii::$app->request->post()) && $model->validate()) {

           $anggota = new Anggota();
           $anggota->nama = $model->nama;
           $anggota->alamat = $model->alamat;
           $anggota->telepon = $model->telepon;
           $anggota->email = $model->email;
           $anggota->save();

           $user = new User();
           $user->username = $model->username;
           $user->password = $model->password;
           $user->id_anggota = $anggota->id;
           $user->id_petugas = 0;
           $user->id_user_role = 2;
           $user->status = 2;
           $user->save();

           return $this->redirect(['site/login']);
       }

       //untuk memunculkan form dari halaman register
       return $this->render('register', ['model'=>$model]);
   }

}
