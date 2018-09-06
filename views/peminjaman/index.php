<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\PeminjamanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Peminjaman';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peminjaman-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Peminjaman', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php 
        //$tanggal = date('Y-m-d');
        //$haribaru = "Senin Selasa Rabu Kamis Jumat Sabtu Minggu";
        //$Pecah = explode( "-", $haribaru );
        //Menampilkan otomatis menggunakan for
        //for ( $i = 0; $i < count( $Pecah ); $i++ ) {
        //echo $Pecah[$i] . "<br />";
        //}
        //Menampilkan secara manual dengan mengakses indexnya
        //echo "Tanggal : " . $Pecah[0] . "<br />";
        //echo "Bulan : " . $Pecah[1] . "<br />";
        //echo "Tahun : " . $Pecah[2] . "<br />";
    ?>

    <br>

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
            [
                'attribute' => 'id_buku',
                'value' => function($data)
                {
                  return $data->buku->nama;
                }
            ],
            [
                'attribute' => 'id_anggota',
                'value' => function($data)
                {
                  return $data->anggota->nama;
                }
            ],
            [
                'attribute' => 'tanggal_pinjam',
                'format' => 'date',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center']
            ],
            [
                'attribute' => 'tanggal_kembali',
                'format' => 'date',
                'headerOptions' => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'text-align:center']
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
