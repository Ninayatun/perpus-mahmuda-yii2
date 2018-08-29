<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?php $form = ActiveForm::begin()?>
                    <h1>Login Form</h1>
                    <?= $form->field($model, 'username')->textInput(['placeholder'=>'Username'], ['autofocus' => true])->label(false); ?>

                    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password'])->label(false); ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                    <div class="clearfix"></div>
                    <div class="separator">
                        <p class="change_link">Don't Have an Account ?
                          <!-- <a href="#signup" class="to_register"> Create Account </a> -->
                          <?= Html::a('Create Account', ['site/signup']) ?>
                        </p>
                      </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </section>
        </div>
    </div>
</div>