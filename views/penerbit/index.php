<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PenerbitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penerbit';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penerbit-index box box-primary">
    <div class="box-header">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Penerbit', ['create'], ['class' => 'btn btn-warning']) ?>

        <?= Html::a('<i class="fa fa-print"> Export Word </i>', ['penerbit/daftar-penerbit'], ['class' => 'btn btn-info btn-flat']); ?>

        <?= Html::a('<i class="fa fa-print"> Export Pdf </i>', ['penerbit/export-pdf'], ['class' => 'btn btn-danger btn-flat']); ?>

        <?= Html::a('<i class="fa fa-print"> Export Excel </i>', ['penerbit/export-excel'], ['class' => 'btn btn-success btn-flat']); ?>
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
