<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Kategori;
use app\models\Penulis;
use app\models\Penerbit;


/* @var $this yii\web\View */
/* @var $searchModel app\models\BukuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buku';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buku-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Buku', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nama',
            // 'tahun_terbit',
           //  [
           //     'class' => 'yii\grid\DataColumn',
           //     'header' => 'Nama Penulis',
           //     'value' => 'penulis.nama',
           //     'filter' => Penulis::getList(),
           //     'value' => function ($data) {
           //          return @$data->penulis->nama;
           //      }
           // ],
            [
                'attribute' => 'id_penulis',
                'filter' => Penulis::getList(),
                'value' => function($data)
                {
                  return $data->getPenulis();
                }
            ],
            [
                'attribute' => 'id_penerbit',
                'filter' => Penerbit::getList(),
                'value' => function($data)
                {
                  return $data->getPenerbit();
                }
            ],
            [
                'attribute' => 'id_kategori',
                'filter' => Kategori::getList(),
                'value' => function($data)
                {
                  return $data->getKategori();
                }
            ],
            //'sinopsis:ntext',
            [
                'attribute' => 'sampul',
                'format' => 'raw',
                'value' => function ($model) {
                  if ($model->sampul != '') {
                    return Html::img('@web/upload/sampul/' . $model->sampul, ['class' => 'img-responsive', 'style' => 'height:100px']);
                  } else {
                    return '<div align="center"><h1>No Image</h1></div>';
                  }
                },
            ],
            [
                'attribute' => 'berkas',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->berkas != '') {
                        return '<a href="' . Yii::$app->homeUrl . '/../upload/berkas/' . $model->berkas . '"><div align="center"><button class="btn btn-primary glyphicon glyphicon-download-alt" type="submit"></button></div></a>';
                    } else { 
                        return '<div align="center"><h1>No File</h1></div>';
                    }
                },
            ],
            //'berkas',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
