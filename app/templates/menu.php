<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <?php
                if(!isset($_SESSION['idProject'])){
                    session_start();
                }

                print('<a href="/" class="site_title"><i class="fa fa-paw"></i> <span>' . $_SESSION['nameProject'] . '</a>');
            ?>

        </div>

        <div class="clearfix"></div>
        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Déploiement</h3>
                <ul class="nav side-menu">
                    <li><a href="/index.php?action=createlivraison"><i class="fa fa-home"></i>Livraison</a>
                    </li>
                </ul>
            </div>
            <div class="menu_section">
                <h3>Suivi Déploiement</h3>
                <ul class="nav side-menu">
                    <li><a href="/index.php?action=index"><i class="fa fa-home"></i>Graphique</a></li>
                    <li><a href="/index.php?action=historiqueopcaim"><i class="fa fa-home"></i>Historique</a></li>
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->


        <!-- /menu footer buttons -->

        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->

    </div>
</div>s