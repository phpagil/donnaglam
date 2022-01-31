<?php
if (!empty($Read)) :
    $Read = new Read;
endif;

$Read->ExeRead(DB_PDT, "WHERE pdt_name = :nm AND (pdt_inventory >= 1 OR pdt_inventory IS NULL) AND pdt_status = 1 AND NOT pdt_cover = '' ", "nm={$URL[1]}");
if (!$Read->getResult()) :
    header('Location: ' . BASE . "/404.php");
else :
    extract($Read->getResult()[0]);
    $CommentKey = $pdt_id;
    $CommentType = 'product';

    $PdtViewUpdate = ['pdt_views' => $pdt_views + 1, 'pdt_lastview' => date('Y-m-d H:i:s')];
    $Update = new Update;
    $Update->ExeUpdate(DB_PDT, $PdtViewUpdate, "WHERE pdt_id = :id", "id={$pdt_id}");

    $Read->FullRead("SELECT brand_name, brand_title FROM " . DB_PDT_BRANDS . " WHERE brand_id = :id", "id={$pdt_brand}");
    $Brand = ($Read->getResult() ? $Read->getResult()[0] : '');

    $Read->FullRead("SELECT cat_name, cat_title FROM " . DB_PDT_CATS . " WHERE cat_id = :id", "id={$pdt_subcategory}");
    $Category = ($Read->getResult() ? $Read->getResult()[0] : '');

    $CommentModerate = (COMMENT_MODERATE ? " AND (status = 1 OR status = 3)" : '');
    $Read->FullRead("SELECT id FROM " . DB_COMMENTS . " WHERE pdt_id = :pid{$CommentModerate}", "pid={$pdt_id}");
    $Aval = $Read->getRowCount();

    $Read->FullRead("SELECT SUM(rank) as total FROM " . DB_COMMENTS . " WHERE pdt_id = :pid{$CommentModerate}", "pid={$pdt_id}");
    $TotalAval = $Read->getResult()[0]['total'];
    $TotalRank = $Aval * 5;
    $getRank = ($TotalAval ? (($TotalAval / $TotalRank) * 50) / 10 : 0);
    $Rank = str_repeat("&starf;", intval($getRank)) . str_repeat("&star;", 5 - intval($getRank));
endif;
?>


<!-- SINGLE PRODUCT - START -->

<!--Page Title-->

<div class="page_title_ctn">
    <div class="container-fluid">
        <h2><?= $pdt_name; ?></h2>

        <ol class="breadcrumb">
            <li><a href="<?= BASE; ?>">Inicio</a></li>
            <?= isset($cat_title) ? "<li>$cat_title</li>" : ""; ?>
        </ol>

    </div>
</div>

<!--Shoping with Sidebar Section-->
<div class="shop-pages">
    <section class="product-single-wrap section-padding">
        <div class="container">
            <div class="product-content-wrap">
                <div class="row">
                    <div class="col-md-6 col-sm-8 col-sm-offset-2 col-md-offset-0">

                        <!-- template -->
                        <div class="ms-showcase2-template ms-showcase2-vertical">
                            <!-- masterslider -->
                            <div class="master-slider ms-skin-default" id="masterslidershop">
                                <div class="ms-slide">
                                    <img src="<?= BASE; ?>\_cdn\vendor\masterslider\style\blank.gif" data-src="https://donnaglam.com.br/saf/uploads/<?= file_exists("./uploads/$pdt_code.jpeg") ? $pdt_cover : $pdt_cover; ?>" alt="lorem ipsum dolor sit">
                                </div>

                            </div>
                            <!-- end of masterslider -->
                        </div>
                        <!-- end of template -->
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="product-content dart-mt-30">
                            <div class="product-title">
                                <h2><?= $pdt_title; ?></h2>
                                <!-- <a href="#" class="pagination-next-prev"> <span class="fa fa-long-arrow-right"></span> </a> -->
                            </div>
                            <div class="product-price-review">
                                <span class="font-semibold black-color">R$ <?= $pdt_price; ?></span>
                                <div class="rating">
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star active"></span>
                                    <span class="star"></span>
                                    <span class="text"><?= rand(5, 1000); ?> avaliações</span>
                                </div>
                            </div>
                            <div class="product-description">
                                <p><?= $pdt_subtitle; ?></p>
                                <p><?= utf8_decode($pdt_content); ?></p>
                                <ul class="list-unstyled">
                                    <li>- COD. BARRAS: <?= $pdt_code; ?></li>
                                    <li>- CATEGORIA: <?= $Category['cat_title']; ?></li>
                                    <li>- <?= $pdt_inventory > 0 ? 'Disponivel em Estoque' : 'Produto Indisponivel'; ?></li>
                                </ul>
                                <div class="qty-add-wish-btn">
                                    <form class="wc_cart_add" id="form_add_<?= $pdt_id; ?>" name="cart_add" method="post" enctype="multipart/form-data">
                                        <input name="pdt_id" type="hidden" value="<?= $pdt_id; ?>" />
                                        <input name="item_amount" type="hidden" value="1" />
                                        <span><button class="btn btn_green" <?= $pdt_inventory <= 0 ? 'disabled' : ''; ?> onclick="console.log(document.getElementById('form_add_<?= $pdt_id; ?>').submit)">COMPRAR</button></span>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- SINGLE PRODUCT - END -->