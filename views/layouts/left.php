<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="img/photo.png" style="height: 80px;" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Nurinay Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Home', 'icon' => 'dashboard','url' => ['site/index'],],
                    ['label' => 'Buku', 'options' => ['class' => 'header']],
                    ['label' => 'Buku', 'icon' => 'book','url' => ['buku/index'],],
                    ['label' => 'Penulis', 'icon' => 'user', 'url' => ['penulis/index'],],
                    ['label' => 'Penerbit', 'icon' => 'user', 'url' => ['penerbit/index'],],
                    ['label' => 'Kategori', 'icon' => 'list', 'url' => ['kategori/index'],],
                    ['label' => 'User', 'options' => ['class' => 'header']],
                    ['label' => 'User', 'icon' => 'users', 'url' => ['user/index'],],
                    ['label' => 'User Role', 'icon' => 'list-ol', 'url' => ['user-role/index'],],
                    ['label' => 'Login', 'options' => ['class' => 'header']],
                    ['label' => 'Logout', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    // [
                    //     'label' => 'Master Buku',
                    //     'icon' => 'share',
                    //     'url' => '#',
                    //     'items' => [
                            
                    //         [
                    //             'label' => 'Level One',
                    //             'icon' => 'circle-o',
                    //             'url' => '#',
                    //             'items' => [
                    //                 ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                    //                 [
                    //                     'label' => 'Level Two',
                    //                     'icon' => 'circle-o',
                    //                     'url' => '#',
                    //                     'items' => [
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                     ],
                    //                 ],
                    //             ],
                    //         ],
                    //     ],
                    // ],
                ],
            ]
        ) ?>

    </section>

</aside>
