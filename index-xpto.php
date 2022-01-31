<?php
ob_start();
session_start();

require './_app/Config.inc.php';

//READ CLASS AUTO INSTANCE
if (empty($Read)) :
    $Read = new Read;
endif;

$Sesssion = new Session(SIS_CACHE_TIME);

//USER SESSION VALIDATION
if (!empty($_SESSION['userLogin'])) :
    if (empty($Read)) :
        $Read = new Read;
    endif;
    $Read->ExeRead(DB_USERS, "WHERE user_id = :user_id", "user_id={$_SESSION['userLogin']['user_id']}");
    if ($Read->getResult()) :
        $_SESSION['userLogin'] = $Read->getResult()[0];
    else :
        unset($_SESSION['userLogin']);
    endif;
endif;

$getURL = strip_tags(trim(filter_input(INPUT_GET, 'url', FILTER_DEFAULT)));
$setURL = (empty($getURL) ? 'index' : $getURL);
$URL = explode('/', $setURL);
$SEO = new Seo($setURL);


//PESQUISA
$Search = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($Search && !empty($Search['s'])) :
    $Search = urlencode(strip_tags(trim($Search['s'])));
    header('Location: ' . BASE . '/pesquisa/' . $Search);
endif;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="mit" content="001182">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= $SEO->getTitle(); ?></title>
    <link rel="base" href="<?= BASE; ?>" />
    <link rel="shortcut icon" href="<?= INCLUDE_PATH; ?>/images/favicon.png" />
    <link href='https://fonts.googleapis.com/css?family=<?= SITE_FONT_NAME; ?>:<?= SITE_FONT_WHIGHT; ?>' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="<?= BASE; ?>/_cdn/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= BASE; ?>/_cdn/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- template CSS - OK -->
    <link href="<?= BASE; ?>/_cdn/css/style.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= BASE; ?>/_cdn/css/custom.css" rel="stylesheet">

    <!-- Base MasterSlider style sheet -->
    <link rel="stylesheet" href="<?= BASE; ?>/_cdn/vendor/masterslider/style/masterslider.css">

    <!-- Master Slider Skin -->
    <link href="<?= BASE; ?>/_cdn/vendor/masterslider/skins/default/style.css" rel="stylesheet" type="text/css">

    <!-- masterSlider Template Style -->
    <link href="<?= BASE; ?>/_cdn/vendor/masterslider/style/ms-layers-style.css" rel="stylesheet" type="text/css">

    <!-- owl Slider Style -->
    <link rel="stylesheet" href="<?= BASE; ?>/_cdn/vendor/owlcarousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= BASE; ?>/_cdn/vendor/owlcarousel/dist/assets/owl.theme.default.min.css">

    <link rel="stylesheet" href="<?= BASE; ?>/_cdn/shadowbox/shadowbox.css" />
    <link rel="stylesheet" href="<?= BASE; ?>/_cdn/bootcss/reset.css" />
    <link rel="stylesheet" href="<?= INCLUDE_PATH; ?>/style.css" />

    <!-- Material+Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <!--[if lt IE 9]>
            <script src="<?= BASE; ?>/_cdn/html5shiv.js"></script>
        <![endif]-->

    <script src="<?= BASE; ?>/_cdn/jquery.js"></script>
    <script src="<?= BASE; ?>/_cdn/workcontrol.js"></script>
    <script src="<?= BASE; ?>/_cdn/maskinput.js"></script>
    <script src="<?= BASE; ?>/_cdn/shadowbox/shadowbox.js"></script>
    <?php
    if (file_exists('themes/' . THEME . '/scripts.js')) :
        echo '<script src="' . INCLUDE_PATH . '/scripts.js"></script>';
    endif;
    ?>

</head>

<body id="home" style="touch-action: pan-x pan-y !important;">

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
    <?php
    //HEADER
    if (file_exists(REQUIRE_PATH . "/inc/header.php")) :
        require REQUIRE_PATH . "/inc/header.php";
    else :
        trigger_error('Crie um arquivo /inc/header.php na pasta do tema!');
    endif;
    ?>
    <!-- HEADER FIM -->

    <!-- router-outlet inicio -->
    <div class="router-outlet">
        <?php

        //CONTENT
        $URL[1] = (empty($URL[1]) ? null : $URL[1]);

        $Pages = array();
        $Read->FullRead("SELECT page_name FROM " . DB_PAGES . " WHERE page_status = 1");
        if ($Read->getResult()) :
            foreach ($Read->getResult() as $SinglePage) :
                $Pages[] = $SinglePage['page_name'];
            endforeach;
        endif;

        if (in_array($URL[0], $Pages) && file_exists(REQUIRE_PATH . '/pagina.php') && empty($URL[1])) :
            if (file_exists(REQUIRE_PATH . "/page-{$URL[0]}.php")) :
                require REQUIRE_PATH . "/page-{$URL[0]}.php";
            else :
                require REQUIRE_PATH . '/pagina.php';
            endif;
        elseif (file_exists(REQUIRE_PATH . '/' . $URL[0] . '.php')) :
            if ($URL[0] == 'artigos' && file_exists(REQUIRE_PATH . "/cat-{$URL[1]}.php")) :
                require REQUIRE_PATH . "/cat-{$URL[1]}.php";
            else :
                require REQUIRE_PATH . '/' . $URL[0] . '.php';
            endif;
        elseif (file_exists(REQUIRE_PATH . '/' . $URL[0] . '/' . $URL[1] . '.php')) :
            require REQUIRE_PATH . '/' . $URL[0] . '/' . $URL[1] . '.php';
        else :
            if (file_exists(REQUIRE_PATH . "/404.php")) :
                require REQUIRE_PATH . '/404.php';
            else :
                trigger_error("Não foi possível incluir o arquivo themes/" . THEME . "/{$getURL}.php <b>(O arquivo 404 também não existe!)</b>");
            endif;
        endif;

        //FOOTER
        if (file_exists(REQUIRE_PATH . "/inc/footer.php")) :
            require REQUIRE_PATH . "/inc/footer.php";
        else :
            trigger_error('Crie um arquivo /inc/footer.php na pasta do tema!');
        endif;
        ?>
    </div>
    <!-- router-outlet fim -->

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= BASE; ?>/_cdn/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Nav JavaScript -->
    <script src="<?= BASE; ?>/_cdn/js/awesomenav.js"></script>

    <!-- jQuery -->
    <!--<script src="vendor/masterslider/jquery.min.js"></script>-->
    <script src="<?= BASE; ?>/_cdn/vendor/masterslider/jquery.easing.min.js"></script>

    <!-- Master Slider -->
    <script src="<?= BASE; ?>/_cdn/vendor/masterslider/masterslider.min.js"></script>

    <!-- custom JavaScript -->
    <script src="<?= BASE; ?>/_cdn/js/custom.js"></script>

    <!-- owl Slider JavaScript -->
    <script src="<?= BASE; ?>/_cdn/vendor/owlcarousel/dist/owl.carousel.min.js"></script>

    <!-- Counter required files -->
    <script type="text/javascript" src="<?= BASE; ?>/_cdn/js/dscountdown.min.js"></script>

    <!-- template JavaScript -->
    <script src="<?= BASE; ?>/_cdn/js/template.js"></script>


</body>

</html>

<?php
ob_end_flush();

if (!file_exists('.htaccess')) :
    $htaccesswrite = "RewriteEngine On\r\nOptions All -Indexes\r\n\r\nRewriteCond %{SCRIPT_FILENAME} !-f\r\nRewriteCond %{SCRIPT_FILENAME} !-d\r\nRewriteRule ^(.*)$ index.php?url=$1\r\n\r\n<IfModule mod_expires.c>\r\nExpiresActive On\r\nExpiresByType image/jpg 'access 1 year'\r\nExpiresByType image/jpeg 'access 1 year'\r\nExpiresByType image/gif 'access 1 year'\r\nExpiresByType image/png 'access 1 year'\r\nExpiresByType text/css 'access 1 month'\r\nExpiresByType application/pdf 'access 1 month'\r\nExpiresByType text/x-javascript 'access 1 month'\r\nExpiresByType application/x-shockwave-flash 'access 1 month'\r\nExpiresByType image/x-icon 'access 1 year'\r\nExpiresDefault 'access 2 days'\r\n</IfModule>";
    $htaccess = fopen('.htaccess', "w");
    fwrite($htaccess, str_replace("'", '"', $htaccesswrite));
    fclose($htaccess);
endif;
