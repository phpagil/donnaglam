<?php
/*
$Read->ExeRead(DB_PDT_CATS, "WHERE cat_name = :cat", "cat={$URL[1]}");
if (!$Read->getResult()) :
    require '404.php';
else :
    extract($Read->getResult()[0]);

    $departament = null;
    if ($cat_parent) :
        $Read->FullRead("SELECT cat_title, cat_name FROM " . DB_PDT_CATS . " WHERE cat_id = :id", "id={$cat_parent}");
        $departament = " / <a title='{$Read->getResult()[0]['cat_title']} em " . SITE_NAME . "' href='" . BASE . "/produtos/{$Read->getResult()[0]['cat_name']}'>{$Read->getResult()[0]['cat_title']}</a>";
    endif;
?>
    <div class="container">
        <section class="content">
            <div class="col-md-12">
                <h1 class="breadcrumbs">
                    <a title="<?= SITE_NAME; ?>" href="<?= BASE; ?>"><?= SITE_NAME; ?></a>
                    <?= $departament; ?> /
                    <?= $cat_title; ?>
                </h1>
                <?php
                $Page = (!empty($URL[2]) && filter_var($URL[2], FILTER_VALIDATE_INT) ? $URL[2] : 1);
                $Pager = new Pager(BASE . "/produtos/{$URL[1]}/", "<<", ">>", 3);
                $Pager->ExePager($Page, 9);
                $Read->ExeRead(DB_PDT, "WHERE (pdt_category = :cat OR pdt_subcategory = :cat) AND (pdt_inventory >= 1 OR pdt_inventory IS NULL) AND pdt_status = 1 ORDER BY pdt_title ASC LIMIT :limit OFFSET :offset", "cat={$cat_id}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                if ($Read->getResult()) :
                    foreach ($Read->getResult() as $LastPDT) :
                        extract($LastPDT);
                        $PdtBox = 'box3';
                        require 'inc/product.php';
                    endforeach;

                    $Pager->ExePaginator(DB_PDT, "WHERE (pdt_category = :cat OR pdt_subcategory = :cat) AND (pdt_inventory >= 1 OR pdt_inventory IS NULL) AND pdt_status = 1", "cat={$cat_id}");
                    echo $Pager->getPaginator();

                else :
                    $Pager->ReturnPage();
                    Erro("Não existem produtos cadastrados em {$cat_title}. Mas temos outras opções! :)", E_USER_NOTICE);
                endif;
                ?>
            </div>

            <?php // require 'inc/sidebar.php';
            ?>

            <div class="clear"></div>
        </section>
    </div>
<?php
endif;
*/
?>



<?php

$Read->ExeRead(DB_PDT_CATS, "WHERE cat_name = :cat", "cat={$URL[1]}");
if (!$Read->getResult()) :
    require '404.php';
else :
    extract($Read->getResult()[0]);

    $departament = null;
    if ($cat_parent) :
        $Read->FullRead("SELECT cat_title, cat_name FROM " . DB_PDT_CATS . " WHERE cat_id = :id", "id={$cat_parent}");
        $departament = " / <a title='{$Read->getResult()[0]['cat_title']} em " . SITE_NAME . "' href='" . BASE . "/produtos/{$Read->getResult()[0]['cat_name']}'>{$Read->getResult()[0]['cat_title']}</a>";
    endif;

endif;
?>

<!-- TITULO DA PAGINA -INICIO -->
<div class="page_title_ctn">
    <div class="container-fluid">
        <h2>Loja</h2>

        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active"><span>Loja</span></li>
        </ol>

    </div>
</div>
<!-- TITULO DA PAGINA - FIM -->

<!-- PAGINA COM SIDEBAR - INICIO DA SECAO-->

<section class="sidebar-shop shop-pages dart-pt-20">

    <div class="container">
        <div class="content-wrap ">
            <!-- FILTROS - INICIO -->
            <div class="shorter">
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <span class="showing-result">Mostrando 1–12 de 30 produtos</span>
                    </div>
                    <div class="col-sm-6 col-xs-6 text-right">
                        <div class="short-by">
                            <span>Ordenar por</span>
                            <select class="selectpicker form-control">
                                <option>Lançamentos</option>
                                <option>Preço</option>
                                <option>Marca</option>
                                <option>Promoção</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FILTROS - FIM -->

            <div class="row">
                <!-- CATEGORIAS - INICIO -->
                <div class="col-sm-3 col-md-4 col-lg-3">
                    <div class="shop-sidebar mt-20">
                        <aside class="widget">
                            <h2 class="widget-title">CATEGORIAS</h2>
                            <div class="panel-group shop-links-widget" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Maquiagem<span class="caret"></span></a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <ul class="list-unstyled">
                                                <li><a href="#">Base</a></li>
                                                <li><a href="#">Batom</a></li>
                                                <li><a href="#">Pincel</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Cílios</a>
                                        </h4>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Cuidados Corporais</a>
                                        </h4>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Batom e Gloss<span class="caret"></span></a>
                                        </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                        <div class="panel-body">
                                            <ul class="list-unstyled">
                                                <li><a href="#">Batom</a></li>
                                                <li><a href="#">Gloss</a></li>
                                                <li><a href="#">Batom Líquido</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFive">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">Pó Compacto</a>
                                        </h4>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingSix">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">Bases</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <aside class="widget">
                            <h2 class="widget-title">Marcas</h2>
                            <ul class="list-unstyled">
                                <li> <a href="#">Donna Glam</a> </li>
                                <li> <a href="#">Ruby Rose</a> </li>
                                <li> <a href="#">Playboy</a> </li>
                                <li> <a href="#">Vult</a> </li>
                                <li> <a href="#">Tracta</a> </li>
                            </ul>
                        </aside>

                        <!--
							<aside class="widget widget_size">
								<h2 class="widget-title">Categorias</h2>
								<ul class="list-unstyled">
									<li> <a href="#">p</a> </li>
									<li> <a href="#">s</a> </li>
									<li> <a href="#">m</a> </li>
									<li> <a href="#">l</a> </li>
									<li> <a href="#">xl</a> </li>
								</ul>
								<ul class="list-unstyled">
									<li> <a href="#">2</a> </li>
									<li> <a href="#">2</a> </li>
									<li> <a href="#">6</a> </li>
									<li> <a href="#">8</a> </li>
									<li> <a href="#">10</a> </li>
								</ul>
							</aside>
							-->

                        <!--<aside class="widget widget_size">
                                    <h2 class="widget-title">Price</h2>
                                    <div class="widget-content">
                                        <div id="slider-range" class="slider-range"></div>
                                        <label  for="amount">Price</label> <input type="text" id="amount" readonly />
                                        <span><a class="btn filter-btn btn-default" href="#">Filter</a></span>
                                    </div>
                                </aside>-->
                    </div>
                </div>
                <!-- CATEGORIAS - FIM -->

                <!-- LISTA DE PRODUTOS - INICIO -->
                <div class="col-sm-9 col-md-8 col-lg-9 border-lft">
                    <div class="product-wrap">
                        <div class="row">
                            <?php
                            $Page = (!empty($URL[2]) && filter_var($URL[2], FILTER_VALIDATE_INT) ? $URL[2] : 1);
                            $Pager = new Pager(BASE . "/produtos/{$URL[1]}/", "<span class='fa fa-long-arrow-left'></span>", "<span class='fa fa-long-arrow-right'></span>", 3);
                            $Pager->ExePager($Page, 12);
                            $Read->ExeRead(DB_PDT, "WHERE (pdt_category = :cat OR pdt_subcategory = :cat) AND (pdt_inventory >= 1 OR pdt_inventory IS NULL) AND pdt_status = 1  AND NOT pdt_cover = ''  ORDER BY pdt_title ASC LIMIT :limit OFFSET :offset", "cat={$cat_id}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                            if ($Read->getResult()) :
                                foreach ($Read->getResult() as $LastPDT) :
                                    extract($LastPDT);
                                    $PdtBox = 'col-md-4';
                                    require 'inc/product.php';
                                endforeach;

                                $Pager->ExePaginator(DB_PDT, "WHERE (pdt_category = :cat OR pdt_subcategory = :cat) AND (pdt_inventory >= 1 OR pdt_inventory IS NULL) AND pdt_status = 1  AND NOT pdt_cover = '' ", "cat={$cat_id}");
                                echo $Pager->getPaginator();

                            else :
                                $Pager->ReturnPage();
                                Erro("Não existem produtos cadastrados em {$cat_title}. Mas temos outras opções! :)", E_USER_NOTICE);
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <!-- LISTA DE PRODUTOS - FIM -->
            </div>

        </div>
    </div>
</section>

<!-- PAGINA COM SIDEBAR - FIM DA SECAO-->