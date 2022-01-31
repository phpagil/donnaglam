<?php
ob_start();
session_start();

require './_app/Config.inc.php';

//READ CLASS AUTO INSTANCE
if (empty($Read)):
    $Read = new Read();
endif;

$Sesssion = new Session(SIS_CACHE_TIME);

//USER SESSION VALIDATION
if (!empty($_SESSION['userLogin'])):
    if (empty($Read)):
        $Read = new Read();
    endif;
    $Read->ExeRead(
        DB_USERS,
        'WHERE user_id = :user_id',
        "user_id={$_SESSION['userLogin']['user_id']}"
    );
    if ($Read->getResult()):
        $_SESSION['userLogin'] = $Read->getResult()[0];
    else:
        unset($_SESSION['userLogin']);
    endif;
endif;

$getURL = strip_tags(trim(filter_input(INPUT_GET, 'url', FILTER_DEFAULT)));
$setURL = empty($getURL) ? 'index' : $getURL;
$URL = explode('/', $setURL);
$SEO = new Seo($setURL);

//PESQUISA
$Search = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($Search && !empty($Search['s'])):
    $Search = urlencode(strip_tags(trim($Search['s'])));
    header('Location: ' . BASE . '/pesquisa/' . $Search);
endif;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="mit" content="001182">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Donna Glam - Cosméticos</title>
    <meta name="description" content="">
    <meta name="robots" content="index, follow" />
    <meta name="author" content="">
    <link rel="icon" href="images\favicon.ico">


    <!-- Bootstrap core CSS -->
    <link href="<?= BASE ?>/_cdn/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?= BASE ?>/_cdn/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="<?= BASE ?>/_cdn/jquery.js"></script>
    <script src="<?= BASE ?>/_cdn/workcontrol.js"></script>
    <script src="<?= BASE ?>/_cdn/maskinput.js"></script>
    <script src="<?= BASE ?>/_cdn/shadowbox/shadowbox.js"></script>
    <?php if (file_exists('themes/' . THEME . '/scripts.js')):
        echo '<script src="' . INCLUDE_PATH . '/scripts.js"></script>';
    endif; ?>

    <!-- Custom Fonts -->
    <link href="<?= BASE ?>/_cdn/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- template CSS - OK -->
    <link href="<?= BASE ?>/_cdn/css/style.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= BASE ?>/_cdn/css/custom.css" rel="stylesheet">

    <!-- Base MasterSlider style sheet -->
    <link rel="stylesheet" href="<?= BASE ?>/_cdn/vendor/masterslider/style/masterslider.css">

    <!-- Master Slider Skin -->
    <link href="<?= BASE ?>/_cdn/vendor/masterslider/skins/default/style.css" rel="stylesheet" type="text/css">

    <!-- masterSlider Template Style -->
    <link href="<?= BASE ?>/_cdn/vendor/masterslider/style/ms-layers-style.css" rel="stylesheet" type="text/css">

    <!-- owl Slider Style -->
    <link rel="stylesheet" href="<?= BASE ?>/_cdn/vendor/owlcarousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= BASE ?>/_cdn/vendor/owlcarousel/dist/assets/owl.theme.default.min.css">

</head>

<body id="home">

    <div>
        <?php var_dump($URL); ?>
        <div class="main_header_cart"><?php require '_cdn/widgets/ecommerce/cart.bar.php'; ?></div>
        <div class="main_header_user"><?php require '_cdn/widgets/account/account.bar.php'; ?></div>
    </div>

    <!-- loader start -->

    <div class="loader">
        <div id="awsload-pageloading">
            <div class="awsload-wrap">
                <ul class="awsload-divi">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- loader end -->

    <!-- HEADER INICIO -->
    <?php //HEADER
//HEADER
?>if (file_exists(REQUIRE_PATH . '/inc/header.php')):
    require REQUIRE_PATH . '/inc/header.php';
    else:
    trigger_error('Crie um arquivo /inc/header.php na pasta do tema!');
    endif; ?>
    <!-- HEADER FIM -->

    <!-- router-outlet inicio -->
    <div class="router-outlet">
        <?php
        //CONTENT
        $URL[1] = empty($URL[1]) ? null : $URL[1];

        $Pages = [];
        $Read->FullRead(
            'SELECT page_name FROM ' . DB_PAGES . ' WHERE page_status = 1'
        );
        if ($Read->getResult()):
            foreach ($Read->getResult() as $SinglePage):
                $Pages[] = $SinglePage['page_name'];
            endforeach;
        endif;

        if (
            in_array($URL[0], $Pages) &&
            file_exists(REQUIRE_PATH . '/pagina.php') &&
            empty($URL[1])
        ):
            if (file_exists(REQUIRE_PATH . "/page-{$URL[0]}.php")):
                require REQUIRE_PATH . "/page-{$URL[0]}.php";
            else:
                require REQUIRE_PATH . '/pagina.php';
            endif;
        elseif (file_exists(REQUIRE_PATH . '/' . $URL[0] . '.php')):
            if (
                $URL[0] == 'artigos' &&
                file_exists(REQUIRE_PATH . "/cat-{$URL[1]}.php")
            ):
                require REQUIRE_PATH . "/cat-{$URL[1]}.php";
            else:
                require REQUIRE_PATH . '/' . $URL[0] . '.php';
            endif;
        elseif (
            file_exists(REQUIRE_PATH . '/' . $URL[0] . '/' . $URL[1] . '.php')
        ):
            require REQUIRE_PATH . '/' . $URL[0] . '/' . $URL[1] . '.php';
        else:
            if (file_exists(REQUIRE_PATH . '/404.php')):
                require REQUIRE_PATH . '/404.php';
            else:
                trigger_error(
                    'Não foi possível incluir o arquivo themes/' .
                        THEME .
                        "/{$getURL}.php <b>(O arquivo 404 também não existe!)</b>"
                );
            endif;
        endif;

        //FOOTER
        if (file_exists(REQUIRE_PATH . '/inc/footer.php')):
            require REQUIRE_PATH . '/inc/footer.php';
        else:
            trigger_error('Crie um arquivo /inc/footer.php na pasta do tema!');
        endif;
        ?>
    </div>
    <!-- router-outlet fim -->

    <section class="product-slide">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div role="tabpanel" class="tabSix text-center">
                        <!--Style 6-->

                        <!-- Nav tabs -->
                        <ul id="tabSix" class="nav nav-tabs">
                            <li class="active">
                                <a href="#contentSix-one" data-toggle="tab">
                                    <p>Mais Vendidos</p>
                                </a>
                            </li>
                            <li>
                                <a href="#contentSix-two" data-toggle="tab">
                                    <p>Lançamentos</p>
                                </a>
                            </li>
                            <li>
                                <a href="#contentSix-three" data-toggle="tab">
                                    <p>Mais Pedidos</p>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane in active" id="contentSix-one">
                                <div class="tab-pane" id="contentSix-2">
                                    <div class="owl-carousel owl-theme">
                                        <div class="wa-theme-design-block">
                                            <figure class="dark-theme">
                                                <img src="<?= BASE ?>/_cdn/images/product\product-1.jpg" alt="Product">
                                                <div class="ribbon"><span>New</span></div>
                                                <span class="block-sticker-tag1">
                                                    <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                                <span class="block-sticker-tag2">
                                                    <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                                <span class="block-sticker-tag3">
                                                    <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                        data-target="#quickView"><strong><i class="fa fa-eye"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                            </figure>
                                            <div class="block-caption1">
                                                <div class="price">
                                                    <span class="sell-price">$120.00</span>
                                                    <span class="actual-price">$170.00</span>
                                                </div>
                                                <div class="clear"></div>
                                                <h4>Chevron pique shift</h4>
                                            </div>
                                        </div>
                                        <div class="wa-theme-design-block">
                                            <figure class="dark-theme">
                                                <img src="<?= BASE ?>/_cdn/images/product\product-2.jpg" alt="Product">
                                                <span class="block-sticker-tag1">
                                                    <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                                <span class="block-sticker-tag2">
                                                    <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                                <span class="block-sticker-tag3">
                                                    <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                        data-target="#quickView"><strong><i class="fa fa-eye"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                            </figure>
                                            <div class="block-caption1">
                                                <div class="price">
                                                    <span class="sell-price">$120.00</span>
                                                    <span class="actual-price">$170.00</span>
                                                </div>
                                                <div class="clear"></div>
                                                <h4>Chevron pique shift</h4>
                                            </div>
                                        </div>
                                        <div class="wa-theme-design-block">
                                            <figure class="dark-theme">
                                                <img src="<?= BASE ?>/_cdn/images/product\product-3.jpg" alt="Product">
                                                <span class="block-sticker-tag1">
                                                    <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                                <span class="block-sticker-tag2">
                                                    <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                                <span class="block-sticker-tag3">
                                                    <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                        data-target="#quickView"><strong><i class="fa fa-eye"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                            </figure>
                                            <div class="block-caption1">
                                                <div class="price">
                                                    <span class="sell-price">$120.00</span>
                                                    <span class="actual-price">$170.00</span>
                                                </div>
                                                <div class="clear"></div>
                                                <h4>Chevron pique shift</h4>
                                            </div>
                                        </div>
                                        <div class="wa-theme-design-block">
                                            <figure class="dark-theme">
                                                <img src="<?= BASE ?>/_cdn/images/product\product-4.jpg" alt="Product">
                                                <span class="block-sticker-tag1">
                                                    <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                                <span class="block-sticker-tag2">
                                                    <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                                <span class="block-sticker-tag3">
                                                    <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                        data-target="#quickView"><strong><i class="fa fa-eye"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                            </figure>
                                            <div class="block-caption1">
                                                <div class="price">
                                                    <span class="sell-price">$120.00</span>
                                                    <span class="actual-price">$170.00</span>
                                                </div>
                                                <div class="clear"></div>
                                                <h4>Chevron pique shift</h4>
                                            </div>
                                        </div>
                                        <div class="wa-theme-design-block">
                                            <figure class="dark-theme">
                                                <img src="<?= BASE ?>/_cdn/images/product\product-5.jpg" alt="Product">
                                                <span class="block-sticker-tag1">
                                                    <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                                <span class="block-sticker-tag2">
                                                    <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                                <span class="block-sticker-tag3">
                                                    <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                        data-target="#quickView"><strong><i class="fa fa-eye"
                                                                aria-hidden="true"></i></strong></span>
                                                </span>
                                            </figure>
                                            <div class="block-caption1">
                                                <div class="price">
                                                    <span class="sell-price">$120.00</span>
                                                    <span class="actual-price">$170.00</span>
                                                </div>
                                                <div class="clear"></div>
                                                <h4>Chevron pique shift</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="contentSix-two">
                                <div class="owl-carousel owl-theme">
                                    <div class="wa-theme-design-block">
                                        <figure class="dark-theme">
                                            <img src="<?= BASE ?>/_cdn/images/product\product-6.jpg" alt="Product">
                                            <span class="block-sticker-tag1">
                                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag2">
                                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag3">
                                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                        </figure>
                                        <div class="block-caption1">
                                            <div class="price">
                                                <span class="sell-price">$120.00</span>
                                                <span class="actual-price">$170.00</span>
                                            </div>
                                            <div class="clear"></div>
                                            <h4>Chevron pique shift</h4>
                                        </div>
                                    </div>
                                    <div class="wa-theme-design-block">
                                        <figure class="dark-theme">
                                            <img src="<?= BASE ?>/_cdn/images/product\product-7.jpg" alt="Product">
                                            <span class="block-sticker-tag1">
                                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag2">
                                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag3">
                                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                        </figure>
                                        <div class="block-caption1">
                                            <div class="price">
                                                <span class="sell-price">$120.00</span>
                                                <span class="actual-price">$170.00</span>
                                            </div>
                                            <div class="clear"></div>
                                            <h4>Chevron pique shift</h4>
                                        </div>
                                    </div>
                                    <div class="wa-theme-design-block">
                                        <figure class="dark-theme">
                                            <img src="<?= BASE ?>/_cdn/images/product\product-8.jpg" alt="Product">
                                            <span class="block-sticker-tag1">
                                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag2">
                                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag3">
                                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                        </figure>
                                        <div class="block-caption1">
                                            <div class="price">
                                                <span class="sell-price">$120.00</span>
                                                <span class="actual-price">$170.00</span>
                                            </div>
                                            <div class="clear"></div>
                                            <h4>Chevron pique shift</h4>
                                        </div>
                                    </div>
                                    <div class="wa-theme-design-block">
                                        <figure class="dark-theme">
                                            <img src="<?= BASE ?>/_cdn/images/product\product-9.jpg" alt="Product">
                                            <div class="ribbon"><span>New</span></div>
                                            <span class="block-sticker-tag1">
                                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag2">
                                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag3">
                                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                        </figure>
                                        <div class="block-caption1">
                                            <div class="price">
                                                <span class="sell-price">$120.00</span>
                                                <span class="actual-price">$170.00</span>
                                            </div>
                                            <div class="clear"></div>
                                            <h4>Chevron pique shift</h4>
                                        </div>
                                    </div>
                                    <div class="wa-theme-design-block">
                                        <figure class="dark-theme">
                                            <img src="<?= BASE ?>/_cdn/images/product\product-10.jpg" alt="Product">
                                            <span class="block-sticker-tag1">
                                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag2">
                                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag3">
                                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                        </figure>
                                        <div class="block-caption1">
                                            <div class="price">
                                                <span class="sell-price">$120.00</span>
                                                <span class="actual-price">$170.00</span>
                                            </div>
                                            <div class="clear"></div>
                                            <h4>Chevron pique shift</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="contentSix-three">
                                <div class="owl-carousel owl-theme">
                                    <div class="wa-theme-design-block">
                                        <figure class="dark-theme">
                                            <img src="<?= BASE ?>/_cdn/images/product\product-11.jpg" alt="Product">
                                            <span class="block-sticker-tag1">
                                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag2">
                                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag3">
                                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                        </figure>
                                        <div class="block-caption1">
                                            <div class="price">
                                                <span class="sell-price">$120.00</span>
                                                <span class="actual-price">$170.00</span>
                                            </div>
                                            <div class="clear"></div>
                                            <h4>Chevron pique shift</h4>
                                        </div>
                                    </div>
                                    <div class="wa-theme-design-block">
                                        <figure class="dark-theme">
                                            <img src="<?= BASE ?>/_cdn/images/product\product-12.jpg" alt="Product">
                                            <span class="block-sticker-tag1">
                                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag2">
                                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag3">
                                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                        </figure>
                                        <div class="block-caption1">
                                            <div class="price">
                                                <span class="sell-price">$120.00</span>
                                                <span class="actual-price">$170.00</span>
                                            </div>
                                            <div class="clear"></div>
                                            <h4>Chevron pique shift</h4>
                                        </div>
                                    </div>
                                    <div class="wa-theme-design-block">
                                        <figure class="dark-theme">
                                            <img src="<?= BASE ?>/_cdn/images/product\product-13.jpg" alt="Product">
                                            <div class="ribbon"><span>New</span></div>
                                            <span class="block-sticker-tag1">
                                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag2">
                                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag3">
                                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                        </figure>
                                        <div class="block-caption1">
                                            <div class="price">
                                                <span class="sell-price">$120.00</span>
                                                <span class="actual-price">$170.00</span>
                                            </div>
                                            <div class="clear"></div>
                                            <h4>Chevron pique shift</h4>
                                        </div>
                                    </div>
                                    <div class="wa-theme-design-block">
                                        <figure class="dark-theme">
                                            <img src="<?= BASE ?>/_cdn/images/product\product-14.jpg" alt="Product">
                                            <span class="block-sticker-tag1">
                                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag2">
                                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag3">
                                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                        </figure>
                                        <div class="block-caption1">
                                            <div class="price">
                                                <span class="sell-price">$120.00</span>
                                                <span class="actual-price">$170.00</span>
                                            </div>
                                            <div class="clear"></div>
                                            <h4>Chevron pique shift</h4>
                                        </div>
                                    </div>
                                    <div class="wa-theme-design-block">
                                        <figure class="dark-theme">
                                            <img src="<?= BASE ?>/_cdn/images/product\product-15.jpg" alt="Product">
                                            <span class="block-sticker-tag1">
                                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag2">
                                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                            <span class="block-sticker-tag3">
                                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                                            aria-hidden="true"></i></strong></span>
                                            </span>
                                        </figure>
                                        <div class="block-caption1">
                                            <div class="price">
                                                <span class="sell-price">$120.00</span>
                                                <span class="actual-price">$170.00</span>
                                            </div>
                                            <div class="clear"></div>
                                            <h4>Chevron pique shift</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

    <section class="featured-product">
        <div class="container">
            <div class="row">
                <div class="dart-headingstyle-one dart-mb-60 text-center">
                    <!--Style 1-->
                    <h2 class="dart-heading">Produtos Donna Glam</h2>
                    <img src="<?= BASE ?>/_cdn/images/Icon-sep.png" alt="img">
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="wa-theme-design-block">
                        <figure class="dark-theme">
                            <img src="<?= BASE ?>/_cdn/images/product\product-16.jpg" alt="Product">
                            <div class="ribbon"><span>New</span></div>
                            <span class="block-sticker-tag1">
                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                            <span class="block-sticker-tag2">
                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                            <span class="block-sticker-tag3">
                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                        </figure>
                        <div class="block-caption1">
                            <div class="price">
                                <span class="sell-price">$120.00</span>
                                <span class="actual-price">$170.00</span>
                            </div>
                            <div class="clear"></div>
                            <h4>Chevron pique shift</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="wa-theme-design-block">
                        <figure class="dark-theme">
                            <img src="<?= BASE ?>/_cdn/images/product\product-17.jpg" alt="Product">
                            <span class="block-sticker-tag1">
                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                            <span class="block-sticker-tag2">
                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                            <span class="block-sticker-tag3">
                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                        </figure>
                        <div class="block-caption1">
                            <div class="price">
                                <span class="sell-price">$120.00</span>
                                <span class="actual-price">$170.00</span>
                            </div>
                            <div class="clear"></div>
                            <h4>Chevron pique shift</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="wa-theme-design-block">
                        <figure class="dark-theme">
                            <img src="<?= BASE ?>/_cdn/images/product\product-18.jpg" alt="Product">
                            <span class="block-sticker-tag1">
                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                            <span class="block-sticker-tag2">
                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                            <span class="block-sticker-tag3">
                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                        </figure>
                        <div class="block-caption1">
                            <div class="price">
                                <span class="sell-price">$120.00</span>
                                <span class="actual-price">$170.00</span>
                            </div>
                            <div class="clear"></div>
                            <h4>Chevron pique shift</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="wa-theme-design-block">
                        <figure class="dark-theme">
                            <img src="<?= BASE ?>/_cdn/images/product\product-19.jpg" alt="Product">
                            <span class="block-sticker-tag1">
                                <span class="off_tag"><strong><i class="fa fa-shopping-basket"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                            <span class="block-sticker-tag2">
                                <span class="off_tag1"><strong><i class="fa fa-heart-o"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                            <span class="block-sticker-tag3">
                                <span class="off_tag2 btn-action btn-quickview" data-toggle="modal"
                                    data-target="#quickView"><strong><i class="fa fa-eye"
                                            aria-hidden="true"></i></strong></span>
                            </span>
                        </figure>
                        <div class="block-caption1">
                            <div class="price">
                                <span class="sell-price">$120.00</span>
                                <span class="actual-price">$170.00</span>
                            </div>
                            <div class="clear"></div>
                            <h4>Chevron pique shift</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="newsletter-bg" style="height: 120px;">

        <div class="container">

            <div class="col-md-6 col-xs-6 text-center">
                <span class="fa-2x"><i class="fa fa-instagram fa-2x"></i> @_donnaglam</span>
            </div>
            <div class="col-md-6 col-xs-6 text-center"></div>
            <span class="fa-2x"><i class="fa fa-facebook fa-2x"></i> #donnaglam</span>
        </div>

        </div>

        <!--div class="container">
    		<div class="row">
    			<div class="dart-headingstyle-one dart-mb-20 text-center">
					<h2 class="dart-heading">Newsletter</h2>
			    </div>
    		</div>
    		<div class="row">
    			<div class="col-md-12">
    				<form class="form-inline">
						<div class="newsletter">
						  <div class="form-group">
							<input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
						  </div>
						  <button type="submit" class="btn btn-default">Subcribe<i class="fa fa-envelope-o"></i></button>
						</div>
					</form>
    			</div>
    		</div>
    	</div-->
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="footer-block about">
                        <h3>Quem Somos</h3>
                        <p>A Donna Glam é a melhor amiga da sua beleza! Venha fazer o seu rancho com a gente! Aqui
                            você pode ser linda por muito menos que na concorrência!
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="footer-block twitter">
                        <h3>INSTAGRAM</h3>
                        <p>Siga-nos no @_donnaglam<br><a
                                href="https://www.instagram.com/_donnaglam/">https://www.instagram.com/_donnaglam/</a>
                            <br>Lá tem muitas dicas e prêmios para você!
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="footer-block contact">
                        <h3>CONTATO</h3>
                        <p>
                            Atendemos de Segunda a Sábado<br>
                            <a href="https://api.whatsapp.com/send?1=pt_BR&phone=5592993627584"> <i
                                    class="fa fa-whatsapp"></i> (92) 99362-7584</a>
                            <br> <i class="fa fa-truck"></i> Fazemos entregas
                        </p>
                    </div>
                </div>
                <div class="col-md-12  col-sm-12">
                    <div class="social">
                        <h5>SIGA-NOS</h5>
                        <ul class="list-inline">
                            <!--li><a href="#"><i class="fa fa-twitter"></i></a></li-->
                            <li><a href="https://www.facebook.com/donnaglamm"><i class="fa fa-facebook-f"></i></a></li>
                            <!--li><a href="#"><i class="fa fa-pinterest-p"></i></a></li-->
                            <li><a href="https://www.instagram.com/_donnaglam/"><i class="fa fa-instagram"></i></a></li>
                            <!--li><a href="#"><i class="fa fa-rss"></i></a></li-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="copy">
                    <p>© 2010 <span>Donna Glam</span>. Desenvolvido por <a href="http://mduarth.com.br">MDUARTH</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?= BASE ?>/_cdn/js/ie10-viewport-bug-workaround.js"></script>

    <!-- jQuery -->
    <script src="<?= BASE ?>/_cdn/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= BASE ?>/_cdn/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Nav JavaScript - IMPORTADO -->
    <script src="<?= BASE ?>/_cdn/js/awesomenav.js"></script>

    <!-- jQuery - IMPORTADO -->
    <!--<script src="vendor/masterslider/jquery.min.js"></script>-->
    <script src="<?= BASE ?>/_cdn/vendor/masterslider/jquery.easing.min.js"></script>

    <!-- Master Slider - IMPORTADO -->
    <script src="<?= BASE ?>/_cdn/vendor/masterslider/masterslider.min.js"></script>

    <!-- custom JavaScript - IMPORTADO -->
    <script src="<?= BASE ?>/_cdn/js/custom.js"></script>

    <!-- owl Slider JavaScript - IMPORTADO -->
    <script src="<?= BASE ?>/_cdn/vendor/owlcarousel/dist/owl.carousel.min.js"></script>

    <!-- Counter required files - IMPORTADO -->
    <script type="text/javascript" src="<?= BASE ?>/_cdn/js/dscountdown.min.js"></script>

    <!-- template JavaScript - IMPORTADO -->
    <script src="<?= BASE ?>/_cdn/js/template.js"></script>


</body>

</html>

<?php
ob_end_flush();

if (!file_exists('.htaccess')):
    $htaccesswrite =
        "RewriteEngine On\r\nOptions All -Indexes\r\n\r\nRewriteCond %{SCRIPT_FILENAME} !-f\r\nRewriteCond %{SCRIPT_FILENAME} !-d\r\nRewriteRule ^(.*)$ index.php?url=$1\r\n\r\n<IfModule mod_expires.c>\r\nExpiresActive On\r\nExpiresByType image/jpg 'access 1 year'\r\nExpiresByType image/jpeg 'access 1 year'\r\nExpiresByType image/gif 'access 1 year'\r\nExpiresByType image/png 'access 1 year'\r\nExpiresByType text/css 'access 1 month'\r\nExpiresByType application/pdf 'access 1 month'\r\nExpiresByType text/x-javascript 'access 1 month'\r\nExpiresByType application/x-shockwave-flash 'access 1 month'\r\nExpiresByType image/x-icon 'access 1 year'\r\nExpiresDefault 'access 2 days'\r\n</IfModule>";
    $htaccess = fopen('.htaccess', 'w');
    fwrite($htaccess, str_replace("'", '"', $htaccesswrite));
    fclose($htaccess);
endif;