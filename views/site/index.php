<?php

use yii\helpers\Html;
use app\models\Buku;
use app\models\Anggota;
use app\models\Petugas;
use app\models\Penulis;
use app\models\Peminjaman;
use app\models\Kategori;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;
use app\models\User;
/* @var $this yii\web\View */

$this->title = 'Perpustakaan';
?>

<?php if (User::isAdmin()) { ?>
<div class="site-index">
<div class="row">

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <p>Jumlah Anggota</p>

                <h3><?= Yii::$app->formatter->asInteger(Anggota::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-building"></i>
            </div>
            <a href="<?=Url::to(['anggota/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
            <div class="inner">
                <p>Jumlah Petugas</p>

                <h3><?= Yii::$app->formatter->asInteger(Petugas::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="<?=Url::to(['petugas/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <p>Jumlah Buku</p>

                <h3><?= Yii::$app->formatter->asInteger(Buku::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-times"></i>
            </div>
            <a href="<?=Url::to(['buku/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <p>Jumlah Peminjaman</p>

                <h3><?= Yii::$app->formatter->asInteger(Peminjaman::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-warning"></i>
            </div>
            <a href="<?=Url::to(['peminjaman/index']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
      <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Buku Berdasarkan Kategori</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
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
    </div>

      <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Buku Berdasarkan Penulis</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
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
    <div class="col-sm-6">
        <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Area Chart</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                        <?=Highcharts::widget([
                            'options' => [
                                'credits' => false,
                                'title' => ['text' => 'PENULIS BUKU'],
                                'exporting' => ['enabled' => true],
                                'plotOptions' => [
                                    'area' => [
                                        'cursor' => 'pointer',
                                    ],
                                ],
                                'series' => [
                                    [
                                        'type' => 'area',
                                        'name' => 'Penulis',
                                        'data' => Penulis::getGrafikList(),
                                    ],
                                ],
                            ],
                        ]);?>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
    </div>
</div>
</div>
<?php } elseif (User::isAnggota()) { ?>
<div class="site-index">
<div class="row">
      <div class="col-sm-6">
        <div class="box box-primary">
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
    </div>

      <div class="col-sm-6">
        <div class="box box-primary">
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
</div>
<?php } elseif (User::isPetugas()) { ?>
    <div class="site-index">
<div class="row">

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <p>Jumlah Anggota</p>

                <h3><?= Yii::$app->formatter->asInteger(Anggota::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-building"></i>
            </div>
        </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
            <div class="inner">
                <p>Jumlah Petugas</p>

                <h3><?= Yii::$app->formatter->asInteger(Petugas::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <p>Jumlah Buku</p>

                <h3><?= Yii::$app->formatter->asInteger(Buku::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-times"></i>
            </div>
        </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <p>Jumlah Peminjaman</p>

                <h3><?= Yii::$app->formatter->asInteger(Peminjaman::getCount()); ?></h3>
            </div>
            <div class="icon">
                <i class="fa fa-warning"></i>
            </div>
        </div>
    </div>
</div>
<div class="row">
      <div class="col-sm-6">
        <div class="box box-primary">
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
    </div>

      <div class="col-sm-6">
        <div class="box box-primary">
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
</div>
<?php } ?>

