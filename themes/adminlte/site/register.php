<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>REGISTER</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Silahkan register terlebih dahulu</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

       <?= $form
           ->field($model, 'username', $fieldOptions1)
           ->label(false)
           ->textInput(['minlength'=>6,'placeholder' => $model->getAttributeLabel('username')]) ?>

       <?= $form
           ->field($model, 'password', $fieldOptions1)
           ->label(false)
           ->passwordInput(['minlength'=>6,'placeholder' => $model->getAttributeLabel('password')]) ?>
       
       <?= $form
           ->field($model, 'nama', $fieldOptions1)
           ->label(false)
           ->textInput(['minlength'=>4,'placeholder' => $model->getAttributeLabel('nama')]) ?>

       <?= $form
           ->field($model, 'alamat', $fieldOptions1)
           ->label(false)
           ->textInput(['minlength'=>6,'placeholder' => $model->getAttributeLabel('alamat')]) ?>

       <?= $form
           ->field($model, 'telepon', $fieldOptions1)
           ->label(false)
           ->textInput(['minlength'=>11,'maxlength'=>13,'placeholder' => $model->getAttributeLabel('telepon')]) ?>

       <?= $form
           ->field($model, 'email', $fieldOptions1)
           ->label(false)
           ->textInput(['minlength'=>6,'placeholder' => $model->getAttributeLabel('email')]) ?>

       <?= $form->field($model, 'verifyCode')->widget(Captcha::className()) ?>

       <div class="row">
           <!-- /.col -->
           <div class="col-xs-4">
               <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
           </div>
           <!-- /.col -->
       </div>


       <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
