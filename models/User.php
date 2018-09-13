<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $id_anggota
 * @property int $id_petugas
 * @property int $id_user_role
 * @property int $status
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['id_anggota', 'id_petugas', 'id_user_role', 'status'], 'integer'],
            [['username'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'id_anggota' => 'Anggota',
            'id_petugas' => 'Petugas',
            'id_user_role' => 'Id User Role',
            'status' => 'Status',
        ];
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $Type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey; 
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    public static function validatePassword($password) 
    {
        return self::findOne(['password' => $password]);
    }

    public function getAnggota()
    {
        $model = Anggota::findOne($this->id_anggota);

        if ($model != null){
            return $model->nama;
        } else {
            return null;
        }

    }

    public function getPetugas()
    {
        $model = Petugas::findOne($this->id_petugas);

        if ($model != null){
            return $model->nama;
        } else {
            return null;
        }

    }

    public static function isAdmin()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $model = User::findOne(['username' => Yii::$app->user->identity->username]);
        if ($model == null){
            return false;
        } elseif ($model->id_user_role == 1) {
            return true;
        }
        return false;
    }

    public static function isAnggota()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $model = User::findOne(['username' => Yii::$app->user->identity->username]);
        if ($model == null){
            return false;
        } elseif ($model->id_user_role == 2) {
            return true;
        }
        return false;
    }

    public static function isPetugas()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $model = User::findOne(['username' => Yii::$app->user->identity->username]);
        if ($model == null){
            return false;
        } elseif ($model->id_user_role == 3) {
            return true;
        }
        return false;
    }
}
