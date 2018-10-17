<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';
$this->params['breadcrumbs'][] = $this->title;
// $fieldOptions1 = [
//     'options' => ['class' => 'form-group has-feedback'],
//     'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
// ];

// $fieldOptions2 = [
//     'options' => ['class' => 'form-group has-feedback'],
//     'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
// ];
?>

<div  class="login-pages">
            <div class="login-logo">
              <img src="../web/img/admin.png" style="height: 100px;">
              <p style="font-weight: bold; color: #F5C316">PERPUSTAKAAN</p>
              <p class="txt-l" style="font-weight: bold">Politeknik Negeri Indramayu</p>
            </div>

<div class="login-box">
    <!-- <div class="login-logo">
        <a href="#"><b>PERPUSTAKAAN</b></a>
    </div> -->
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Silahkan login terlebih dahulu</p>

        <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-signin'],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['placeholder'=>'Username'])->label(false); ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password'])->label(false); ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::className()) ?>

        <div class="row">
            <!-- <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div> -->
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <div class="row">
            <div class="col-xs-4">
                <?= Html::a('Register', ['site/register'], ['class' => 'btn btn-success']) ?>
            </div>
            <div class="col-xs-4">
                <?= Html::a('Forget Password', ['site/forget'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
