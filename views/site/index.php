<?php

use yii\helpers\Html;
use app\models\Buku;
use app\models\Anggota;
use app\models\Petugas;
use app\models\Penulis;
use app\models\Peminjaman;
use app\models\Kategori;
use miloschuman\highcharts\Highcharts;
/* @var $this yii\web\View */

$this->title = 'Perpustakaan';
?>
<div class="site-index">

	<div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-users"></i></div>
                  <div class="count"><?= Yii::$app->formatter->asInteger(Anggota::getCount()); ?></div>
                  <h3>Anggota</h3>
                  <p><?= Html::a('More Info', ['anggota/index']) ?> <i class="fa fa-arrow-right"></i></p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-user"></i></div>
                  <div class="count"><?= Yii::$app->formatter->asInteger(Petugas::getCount()); ?></div>
                  <h3>Petugas</h3>
                  <p><?= Html::a('More Info', ['petugas/index']) ?> <i class="fa fa-arrow-right"></i></p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-book"></i></div>
                  <div class="count"><?= Yii::$app->formatter->asInteger(Buku::getCount()); ?></div>
                  <h3>Buku</h3>
                  <p><?= Html::a('More Info', ['buku/index']) ?> <i class="fa fa-arrow-right"></i></p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-check-square-o"></i></div>
                  <div class="count"><?= Yii::$app->formatter->asInteger(Peminjaman::getCount()); ?></div>
                  <h3>Peminjaman</h3>
                  <p><?= Html::a('More Info', ['peminjaman/index']) ?> <i class="fa fa-arrow-right"></i></p>
                </div>
              </div>
            </div>

<div class="row">
      <div class="col-sm-6">
        
            <div class="box-header with-border">
                <h3 class="box-title">Buku Berdasarkan Kategori</h3>
            </div>
            <div class="box-body">
                <?=Highcharts::widget([
                    'options' => [
                        'credits' => false,
                        'title' => ['text' => 'KATEGORI BUKU'],
                        'exporting' => ['enabled' => true],
                        'plotOptions' => [
                            'pie' => [
                                'cursor' => 'pointer',
                            ],
                        ],
                        'series' => [
                            [
                                'type' => 'pie',
                                'name' => 'Kategori',
                                'data' => Kategori::getGrafikList(),
                            ],
                        ],
                    ],
                ]);?>
            </div>

    </div>

      <div class="col-sm-6">
        
            <div class="box-header with-border">
                <h3 class="box-title">Buku Berdasarkan Penulis</h3>
            </div>
            <div class="box-body">
                <?=Highcharts::widget([
                    'options' => [
                        'credits' => false,
                        'title' => ['text' => 'PENULIS BUKU'],
                        'exporting' => ['enabled' => true],
                        'plotOptions' => [
                            'pie' => [
                                'cursor' => 'pointer',
                            ],
                        ],
                        'series' => [
                            [
                                'type' => 'pie',
                                'name' => 'Penulis',
                                'data' => Penulis::getGrafikList(),
                            ],
                        ],
                    ],
                ]);?>
            </div>

    </div>
</div>
    
</div>
