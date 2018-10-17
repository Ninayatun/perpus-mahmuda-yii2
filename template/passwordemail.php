<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="row">
<center>
<img src="https://scontent-sit4-1.xx.fbcdn.net/v/t1.0-9/43527301_335953880493708_2071501334321823744_n.jpg?_nc_cat=103&oh=880bb10c3627cb83ae004c12d8db9d8a&oe=5C586B0E" style="width: 250px; height: 250px;">
<hr width="60%">
<h3>Yang Terhormat.</h3>
<h1><?= @$model->nama ?></h1>
<p>Apakah anda yakin ingin merubah password akun perpustakaan anda?</p>
<p>Jika ingin mengubah password anda silahkan klik tombol dibawah ini.</p>
<button type="button" style="background: #00b894; border:none; font-size:14px; padding:15px 25px; text-align: center; font-weight: bold; color:#000000; font-color: black;">
<?= Html::a('New Password', 'https://localhost/perpus-yii2/web/index.php?r=site/new-password&token='.@$model->user->token);?>
</button>
<hr width="60%">
</center>
</div>