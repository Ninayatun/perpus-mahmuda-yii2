<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kategori */

$this->title = 'Edit Kategori : ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Kategori', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kategori-update box box-primary">
	<div class="box-header">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
</div>
