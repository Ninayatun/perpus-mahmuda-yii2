<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Kategori;
use app\models\Penulis;
use app\models\Penerbit;

/* @var $this yii\web\View */
/* @var $model app\models\Buku */

$this->title = "Detail Buku : " . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Buku', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buku-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'label' => 'Nama (Tahun)',
                // 'attribute' => 'nama',
                'value' => $model->nama . ' (' . $model->tahun_terbit . ')'
            ],
            [
                'attribute' => 'tahun_terbit',
                'value' => $model->tahun_terbit . ' Masehi'
            ],
            [
               'label' => 'Penulis',
               'value' => function($data)
                {
                  return $data->penulis->nama;
                }
           ],
            [
               'label' => 'Penerbit',
               'value' => function($data)
                {
                  return $data->penerbit->nama;
                }
           ],
            [
               'label' => 'Kategori',
               'value' => function($data)
                {
                  return $data->kategori->nama;
                }
           ],
            'sinopsis:ntext',
            [
                'label' => 'Sampul',
                'format' => 'raw',
                'value' => function ($model) {
                  if ($model->sampul != '') {
                    return Html::img('@web/upload/sampul/' . $model->sampul, ['class' => 'img-responsive', 'style' => 'height:300px ']);
                  } else {
                    return '<div align="center"><h1>No Image</h1></div>';
                  }
                },
            ],
            'berkas',
        ],
    ]) ?>

</div>
