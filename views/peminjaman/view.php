<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Peminjaman */

$this->title = $model->anggota->nama;

$this->params['breadcrumbs'][] = ['label' => 'Peminjaman', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peminjaman-view">

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
            // 'id_buku',
            [
                'label' => 'Buku',
                'value' => function($data)
                {
                  return $data->buku->nama;
                }
            ],
            [
                'label' => 'Anggota',
                'value' => function($data)
                {
                  return $data->anggota->nama;
                }
            ],
            'tanggal_pinjam',
            'tanggal_kembali',
        ],
    ]) ?>

</div>
