<?php

namespace app\models;

use Yii;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "kategori".
 *
 * @property int $id
 * @property string $nama
 */
class Kategori extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Kategori',
        ];
    }

    /**
     * @inheritdoc
     * @return array untuk dropdown
     */
    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'nama');
    }

    public function getJumlahBuku()
    {
        return Buku::find()
            ->andWhere(['id_kategori' => $this->id])
            ->count();
    }

    public function findAllBuku()
    {
        return Buku::find()
            ->andWhere(['id_kategori' => $this->id])
            ->orderBy(['nama' => SORT_DESC])
            ->all();
    }

    public function getManyBuku()
    {
        return $this->hasMany(Buku::class, ['id_kategori' => 'id']);
    }

    public static function getGrafikList()
    {
        $data = [];
        foreach (static::find()->all() as $kategori) {
            $data[] = [StringHelper::truncate($kategori->nama, 20), (int) $kategori->getManyBuku()->count()];
        }
        return $data;
    }
}
