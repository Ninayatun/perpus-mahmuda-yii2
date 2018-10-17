<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Anggota;
use app\models\User;


class ForgetPasswordForm extends Model

{
    // DEKLARASI  //
    
    public $email;
    public $verifyCode;
    public $token;

   
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['token'],'safe'],
            ['verifyCode', 'captcha'],
          
        ];
    }

    public function Email()
    {
        $model = Anggota::findOne(['email'=>$this->email]);
        if ($model !== null) {
            return Yii::$app->mail->compose('@app/template/email', ['model'=> $model])
             ->setFrom('mahmudanurinayatun@gmail.com')
             ->setTo($this->email)
             ->setSubject('Test')
             ->send();

             return true;

        }
        return false;
    }
}