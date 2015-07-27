<?php

use application\Session; ?>
<header id="header">
    <p class="pull-right" style="color: #ffffff; position: absolute; right: 20px; margin-top: 10px; font-size: 14px;"><?php print Session::get('nome'); ?> (<a href="<?php print URL ?>login/logof">Sair</a>)</p>

    <hgroup>
        <h1 class="site_title" style="position: absolute; left: 600px;">
                <?php if (Session::get('nivel') == "gestor"): $menu = "dashboard"; ?>
                <a class="brand" href="#">Painel de Gestão</a>

                <?php endif; ?>

                <?php if (Session::get('nivel') == "docente"): $menu = "dashboard/docente/"; ?>
                    <a class="brand" href="#">Painel de Docente</a>

                <?php endif; ?>

                <?php if (Session::get('nivel') == "aluno"): $menu = "dashboard/aluno/"; ?>
                    <a class="brand" href="#">Painel de Aluno</a>

                <?php endif; ?>

                <?php if (Session::get('nivel') == "administrador"): $menu = "dashboard/admin/"; ?>
                    <a class="brand" href="#">Painel de Administrador</a>

                <?php endif; ?>


        </h1>
        <h2 class="section_title"><?php if (isset($this->titulo)): echo $this->titulo;
                endif; ?></h2>
    </hgroup>
</header> <!-- end of header bar -->

<section id="secondary_bar" class="">
    <div class="user">
        <!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
    </div>
    <div class="breadcrumbs_container">
        <article class="breadcrumbs"><a href="<?php print URL . $menu ?>">Menu Principal</a> <div class="breadcrumb_divider"></div> <a class="current">Dashboard</a></article>
    </div>
</section><!-- end of secondary bar -->
