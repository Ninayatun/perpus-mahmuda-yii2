<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KategoriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kategori';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategori-index box box-primary">
    <div class="box-header">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Kategori', ['create'], ['class' => 'btn btn-warning']) ?>

        <?= Html::a('<i class="fa fa-print"> Export Word </i>', ['kategori/daftar-kategori'], ['class' => 'btn btn-info btn-flat']); ?>

        <?= Html::a('<i class="fa fa-print"> Export Pdf </i>', ['kategori/export-pdf'], ['class' => 'btn btn-danger btn-flat']); ?>

        <?= Html::a('<i class="fa fa-print"> Export Excel </i>', ['kategori/export-excel'], ['class' => 'btn btn-success btn-flat']); ?>
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
                'header' => 'Jumlah Buku',
                'value' => function($model) {
                    return $model->getJumlahBuku();
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
