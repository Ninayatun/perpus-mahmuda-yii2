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
            'tanggal_pinjam',
            'tanggal_kembali',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
