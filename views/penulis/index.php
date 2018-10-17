<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PenulisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penulis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penulis-index box box-primary">
    <div class="box-header">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Penulis', ['create'], ['class' => 'btn btn btn-warning']) ?>

        <?= Html::a('<i class="fa fa-print"></i> Export Word', ['penulis/daftar-penulis'], ['class' => 'btn btn-info btn-flat']); ?>

        <?= Html::a('<i class="fa fa-print"></i> Export Pdf', ['penulis/export-pdf'], ['class' => 'btn btn-danger btn-flat']); ?>

        <?= Html::a('<i class="fa fa-print"></i> Export Excel', ['penulis/export-excel'], ['class' => 'btn btn-success btn-flat']); ?>
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
            'alamat:ntext',
            'telepon',
            'email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
