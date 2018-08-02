<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penulis".
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $telepon
 * @property string $email
 */
class Penulis extends \yii\db\ActiveRecord
{

    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penulis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['alamat'], 'string'],
            [['nama', 'telepon', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'telepon' => 'Telepon',
            'email' => 'Email',
        ];
    }

    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'nama');
    }

    public function findAllBuku()
    {
        return Buku::find()
            ->andWhere(['id_penulis' => $this->id])
            ->all();
    }

    public function getJumlahBuku()
    {
        return Buku::find()
            ->andWhere(['id_penulis' => $this->id])
            ->count();
    }
    
}
