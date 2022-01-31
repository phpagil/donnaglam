<?php require '_cdn/widgets/ecommerce/cart.inc.php'; ?>

<!-- Start top area -->
<div class="top-container">
    <div class="container-fluid">
        <div class="row">
            <div class="top-column-left">
                <ul class="contact-line">
                    <li><i class="fa fa-envelope"></i> <?= SITE_ADDR_EMAIL; ?></li>
                    <li><i class="fa fa-phone"></i> <?= SITE_ADDR_PHONE_A; ?></li>
                </ul>
            </div>
            <div class="top-column-right">
                <div class="top-social-network">
                    <a href="https://www.facebook.com/donnaglamm" target="_blank"><i class="fa fa-facebook"></i></a>
                    <!-- <a href="#"><i class="fa fa-twitter"></i></a> -->
                    <!-- <a href="#"><i class="fa fa-google-plus"></i></a> -->
                    <!-- <a href="#"><i class="fa fa-linkedin"></i></a> -->
                    <a href="https://www.instagram.com/_donnaglam/" target="_blank"><i class="fa fa-instagram"></i></a>
                    <!-- <a href="#"><i class="fa fa-pinterest"></i></a> -->
                    <!-- <a href="#"><i class="fa fa-dribbble"></i></a> -->
                </div>
                <ul class="register">
                    <li><a href="<?= BASE; ?>/conta/login">Login</a></li>
                    <!-- <li><a href="#">Cadastro</a></li> -->
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End top area -->
<div class="clearfix"></div>

<!-- MENU INICIO -->
<nav class="navbar navbar-default navbar-sticky awesomenav">
    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container-fluid">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->
    <div class="container-fluid">

        <!-- Start Cart Bar -->
        <?php require '_cdn/widgets/ecommerce/cart.bar.php'; ?>
        <!-- End Cart Bar -->


        <!-- Start Header Navigation -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="<?= BASE; ?>">
                <?php
                echo '<img  src="' . BASE . '/themes/' . THEME . '/images/logo_princ.png" class="logo" alt="" height="40" />';
                ?>
            </a>
        </div>
        <!-- End Header Navigation -->

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="nav navbar-nav navbar-center" data-in="fadeInDown" data-out="fadeOutUp">
                <li class="active"><a href="<?= BASE; ?>">Inicio</a></li>
                <li class="dropdown megamenu-fw">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">PRODUTOS</a>
                    <ul class="dropdown-menu megamenu-content" role="menu">
                        <li>
                            <div class="row">
                                <!-- <div class="col-menu col-md-3">
                                    <h6 class="title">Cuidados Corporais</h6>
                                    <div class="content">
                                        <ul class="menu-col">
                                            <li><a href="products.html">Sabonetes</a></li>
                                            <li><a href="products.html">Gels</a></li>
                                            <li><a href="products.html">Cuidados com a pele</a></li>
                                            <li><a href="products.html">Massagem</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-menu col-md-3">
                                    <h6 class="title">Maquiagem</h6>
                                    <div class="content">
                                        <ul class="menu-col">
                                            <li><a href="products.html">Olhos</a></li>
                                            <li><a href="products.html">Rosto</a></li>
                                            <li><a href="products.html">Unhas</a></li>
                                            <li><a href="products.html">Acessórios</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-menu col-md-3">
                                    <h6 class="title">Fragâncias</h6>
                                    <div class="content">
                                        <ul class="menu-col">
                                            <li><a href="products.html">Mistas</a></li>
                                            <li><a href="products.html">Doces</a></li>
                                            <li><a href="products.html">Quentes</a></li>
                                            <li><a href="products.html">Donna Glam</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-menu col-md-3">
                                    <h6 class="title">Presentes</h6>
                                    <div class="content">
                                        <ul class="menu-col">
                                            <li><a href="products.html">Combos</a></li>
                                            <li><a href="products.html">Cesta de Namorados</a></li>
                                            <li><a href="products.html">Caixa de Presentes</a></li>
                                            <li><a href="products.html">Cartões de Presente</a></li>
                                        </ul>
                                    </div>
                                </div> -->
                                <?php
                                $Read->FullRead("SELECT c.cat_id, c.cat_title, c.cat_name, (SELECT COUNT(*) FROM " . DB_PDT . " p WHERE p.pdt_category = c.cat_id AND NOT p.pdt_cover = '') qt_products FROM " . DB_PDT_CATS . " c WHERE c.cat_parent IS NULL ORDER BY cat_title ASC");
                                if ($Read->getResult()) :

                                    foreach ($Read->getResult() as $NavSectors) :
                                        if ($NavSectors['qt_products'] > 0) {
                                            echo "<div class='col-menu col-md-2'>";
                                            echo "<a class='link-menu color_home' title='{$NavSectors['cat_title']}' href='" . BASE . "/produtos/{$NavSectors['cat_name']}'>";
                                            echo "<h6 class='title' style='padding-bottom: 0px;'>{$NavSectors['cat_title']}</h6>";
                                            echo "</a>";

                                            echo "<div class='content' style='margin: 0px; padding-top: 12px;'>";
                                            echo "<ul class='menu-col'>";
                                            $Read->FullRead("SELECT s.cat_title, s.cat_name, (SELECT COUNT(*) FROM " . DB_PDT . " p WHERE p.pdt_subcategory = s.cat_id AND p.pdt_category = s.cat_parent AND NOT p.pdt_cover = '') qt_products_sub FROM " . DB_PDT_CATS . " s WHERE s.cat_parent = :cat_id ORDER BY cat_title ASC", "cat_id={$NavSectors['cat_id']}");
                                            if ($Read->getResult()) :
                                                foreach ($Read->getResult() as $NavProductsCat) :
                                                    if ($NavProductsCat['qt_products_sub'] > 0) {
                                                        echo "<li><a title='{$NavProductsCat['cat_title']}' href='" . BASE . "/produtos/{$NavProductsCat['cat_name']}'>";
                                                        echo "{$NavProductsCat['cat_title']}  ({$NavProductsCat['qt_products_sub']})</a></li>";
                                                    }
                                                endforeach;
                                                echo "</ul>";
                                            endif;
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                    endforeach;
                                endif;


                                ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Vídeos</a>
                    <ul class="dropdown-menu">
                        <li><a href="blog.html">Tutotiais de Maquiagem</a></li>
                        <li><a href="blog-single.html">Lançamento de Produtos</a></li>
                    </ul>
                </li> -->

                <?php
                $Read->FullRead("SELECT page_title, page_name FROM " . DB_PAGES . " WHERE page_status = 1 ORDER BY page_order ASC, page_name ASC");
                if ($Read->getResult()) :
                    foreach ($Read->getResult() as $NavPage) :
                        echo "<li><a title='{$NavPage['page_title']}' href='" . BASE . "/{$NavPage['page_name']}'>{$NavPage['page_title']}</a></li>";
                    endforeach;
                endif;
                ?>

                <!-- <li><a href="<?= BASE; ?>/contact">CONTATO</a></li> -->
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>

    <!-- Start Side Menu -->
    <div class="side">
        <a href="#" class="close-side"><i class="fa fa-times"></i></a>
        <div class="widget">
            <h6 class="title">Loja</h6>
            <ul class="link">
                <li><a href="<?= BASE; ?>/conta/home">Minha Conta</a></li>
                <li><a href="<?= BASE; ?>/pedido/endereco#cart">Fechar Pedido</a></li>
                <li><a href="<?= BASE; ?>/pedido/home#cart">Carrinho</a></li>
                <!-- <li><a href="index.html">Perguntas Frequentes</a></li>
                <li><a href="contact.html">Política de Privacidade</a></li> -->
            </ul>
        </div>
    </div>
    <!-- End Side Menu -->

</nav>
<!-- MENU FIM -->

<!--SLIDER INICIO-->
<?php
// Se estivermos na pagina inicial, chama os slides do template
if (empty($getURL) || $getURL == 'index') {
    $SlideSeconts = 3;
    require '_cdn/widgets/slide/slide.wc.php';
?>

    <!-- SLIDER FIM -->

    <div class="clearfix"></div>

    <!-- CARDS INFORMATIVOS FRETE / CONTATO / PGTO - INICIO -->
    <div class="information d-sm-none" style="background-color:#464646;">

        <div class="container">

            <div class="row">

                <div class="col-md-4 col-xs-4">
                    <div class="footer-block about">
                        <h4 style="color:white !important;"><i class="fa fa-truck"></i> FRETE</h4>
                        <p style="color:white !important;">Entregas para pedidos a partir de R$ 50,00. <br>Consulte as taxas de entrega!</p>
                    </div>
                </div>
                <div class="col-md-4 col-xs-4">
                    <div class="footer-block twitter">
                        <h4 style="color:white !important;"><i class="fa fa-envelope"></i> CONTATO</h4>
                        <p style="color:white !important;">
                            <i class="fa fa-instagram"></i> @_donnaglam <br />
                            <i class="fa fa-facebook"></i> DonnaGlam <br />
                            <i class="fa fa-whatsapp"></i> (92) 99362-7584<br />
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-block contact">
                        <h4 style="color:white !important;"><i class="fa fa-credit-card"></i> PAGAMENTO</h4>
                        <p style="color:white !important;">
                            <i class="fa fa-money"></i> Dinheiro<br />
                            <i class="fa fa-cc-mastercard"></i> Todos os Cartões<br />
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- CARDS INFORMATIVOS FRETE / CONTATO / PGTO - INICIO -->

<?php } ?>