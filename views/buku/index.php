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
<div class="buku-index box box-primary">

    <div class="box-header">
    
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Buku', ['create'], ['class' => 'btn btn-warning']) ?>

        <?= Html::a('<i class="fa fa-print"></i> Export Word', ['buku/jadwal-pl'], ['class' => 'btn btn-primary btn-flat']); ?>

        <?= Html::a('<i class="fa fa-print"></i> Export Pdf', ['buku/export-pdf'], ['class' => 'btn btn-danger btn-flat']); ?>

        <?= Html::a('<i class="fa fa-print"></i> Export Excel', ['buku/export-excel'], ['class' => 'btn btn-success btn-flat']); ?>

        <?= Html::a('<i class="fa fa-print"></i> SURAT CERAI', ['buku/surat-cerai2'], ['class' => 'btn btn-primary btn-flat']); ?>
    </p>
    </div>


    <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'No',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center']
            ],
            'nama',
            [
                'attribute' => 'tahun_terbit',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center'],
            ],
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
                  return @$data->penulis->nama;
                },
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center']

            ],
            [
                'attribute' => 'id_penerbit',
                'filter' => Penerbit::getList(),
                'value' => function($data)
                {
                  return @$data->penerbit->nama;
                },
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center']
            ],
            [
                'attribute' => 'id_kategori',
                'filter' => Kategori::getList(),
                'value' => function($data)
                {
                  return @$data->kategori->nama;
                },
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center']
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
</div>
