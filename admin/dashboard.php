<?php
ob_start();
session_start();
require '../_app/Config.inc.php';

if (isset($_SESSION['userLogin']) && isset($_SESSION['userLogin']['user_level']) && $_SESSION['userLogin']['user_level'] >= 6):
    $Read = new Read;
    $Read->FullRead("SELECT user_level FROM " . DB_USERS . " WHERE user_id = :user", "user={$_SESSION['userLogin']['user_id']}");
    if (!$Read->getResult() || $Read->getResult()[0]['user_level'] < 6):
        unset($_SESSION['userLogin']);
        header('Location: ./index.php');
    else:
        $Admin = $_SESSION['userLogin'];
        $Admin['user_thumb'] = (!empty($Admin['user_thumb']) && file_exists("../uploads/{$Admin['user_thumb']}") && !is_dir("../uploads/{$Admin['user_thumb']}") ? $Admin['user_thumb'] : '../admin/_img/no_avatar.jpg');
        $DashboardLogin = true;
    endif;
else:
    unset($_SESSION['userLogin']);
    header('Location: ./index.php');
endif;

$AdminLogOff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
if ($AdminLogOff):
    $_SESSION['trigger_login'] = Erro("<b>LOGOFF:</b> Olá {$Admin['user_name']}, você desconectou com sucesso do " . ADMIN_NAME . ", volte logo!");
    unset($_SESSION['userLogin']);
    header('Location: ./index.php');
endif;

$getViewInput = filter_input(INPUT_GET, 'wc', FILTER_DEFAULT);
$getView = ($getViewInput == 'home' ? 'home' . ADMIN_MODE : $getViewInput);

//SITEMAP GENERATE (1X DAY)
$SiteMapCheck = fopen('sitemap.txt', "a+");
$SiteMapCheckDate = fgets($SiteMapCheck);

if ($SiteMapCheckDate != date('Y-m-d')):
    $SiteMapCheck = fopen('sitemap.txt', "w");
    fwrite($SiteMapCheck, date('Y-m-d'));
    fclose($SiteMapCheck);

    $SiteMap = new Sitemap;
    $SiteMap->exeSitemap(DB_AUTO_PING);
    $SiteMap->exeRSS();
endif;
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title><?= ADMIN_NAME; ?> - <?= SITE_NAME; ?></title>
        <meta name="description" content="<?= ADMIN_DESC; ?>"/>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="robots" content="noindex, nofollow"/>

        <link rel="icon" href="_img/favicon.png" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Source+Code+Pro:300,500' rel='stylesheet' type='text/css'>
        <link rel="base" href="<?= BASE; ?>/admin/">

        <link rel="stylesheet" href="_css/reset.css"/>        
        <link rel="stylesheet" href="_css/workcontrol.css"/>
        <link rel="stylesheet" href="_css/workcontrol-860.css" media="screen and (max-width: 860px)"/>
        <link rel="stylesheet" href="_css/workcontrol-480.css" media="screen and (max-width: 480px)"/>
        <link rel="stylesheet" href="_css/fonticon.css"/>

        <script src="../_cdn/jquery.js"></script>
        <script src="../_cdn/jquery.form.js"></script>
        <script src="_js/workcontrol.js"></script>

        <script src="_js/tinymce/tinymce.min.js"></script>
        <script src="_js/maskinput.js"></script>
        <script src="_js/workplugins.js"></script>
    </head>
    <body class="dashboard_main">
        
        <div class="workcontrol_upload">
            <div class="workcontrol_upload_bar">
                <span class="workcontrol_upload_progrees">0%</span>
                <p>Aguarde, enviando arquivos!</p>
            </div>
        </div>
        
        <div class="dashboard_fix">
            <?php
            if (isset($_SESSION['trigger_controll'])):
                echo "<div class='trigger_modal'>";
                Erro("<span class='icon-warning'>{$_SESSION['trigger_controll']}</span>", E_USER_ERROR);
                echo "</div>";
                unset($_SESSION['trigger_controll']);
            endif;
            ?>

            <nav class="dashboard_nav">
                <div class="dashboard_nav_admin">
                    <img class="dashboard_nav_admin_thumb rounded" alt="" title="" src="../tim.php?src=uploads/<?= $Admin['user_thumb']; ?>&w=76&h=76"/>
                    <p><a href="dashboard.php?wc=users/create&id=<?= $Admin['user_id']; ?>" title="Meu Perfil"><?= $Admin['user_name']; ?> <?= $Admin['user_lastname']; ?></a></p>
                </div>
                <ul class="dashboard_nav_menu">
                    <li class="dashboard_nav_menu_li <?= $getViewInput == 'home' ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-home" title="Dashboard" href="dashboard.php?wc=home">Dashboard</a></li>

                    <?php if (APP_POSTS): ?>
                        <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'posts/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-blog" title="Posts" href="dashboard.php?wc=posts/home">Posts</a>
                            <ul class="dashboard_nav_menu_sub">
                                <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'posts/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Ver Posts" href="dashboard.php?wc=posts/home">&raquo; Ver Posts</a></li>
                                <li class="dashboard_nav_menu_sub_li <?= strstr($getViewInput, 'posts/categor') ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Categorias" href="dashboard.php?wc=posts/categories">&raquo; Categorias</a></li>
                                <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'posts/create' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Novo Post" href="dashboard.php?wc=posts/create">&raquo; Novo Post</a></li>
                            </ul>
                        </li>
                        <?php
                    endif;
                    //USER LEVEL 7 TO E-COMMERCE FUNCTIONS
                    if ($Admin['user_level'] >= 7):
                        if (APP_PRODUCTS):
                            ?>
                            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'products/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-books" title="Produtos" href="dashboard.php?wc=products/home">Produtos</a>
                                <ul class="dashboard_nav_menu_sub">
                                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'products/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Ver Produtos" href="dashboard.php?wc=products/home">&raquo; Ver Produto</a></li>
                                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'products/outsale' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Fora de Estoque" href="dashboard.php?wc=products/outsale">&raquo; Fora de Estoque</a></li>
                                    <li class="dashboard_nav_menu_sub_li <?= strstr($getViewInput, 'products/categor') ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Categorias de Produtos" href="dashboard.php?wc=products/categories">&raquo; Categorias</a></li>
                                    <li class="dashboard_nav_menu_sub_li <?= strstr($getViewInput, 'products/bran') ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Marcas ou Fabricantes" href="dashboard.php?wc=products/brands">&raquo; Fabricantes</a></li>
                                    <li class="dashboard_nav_menu_sub_li <?= strstr($getViewInput, 'products/coupons') ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Cupons de Desconto" href="dashboard.php?wc=products/coupons">&raquo; Cupons de Desconto</a></li>
                                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'products/create' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Novo Produto" href="dashboard.php?wc=products/create">&raquo; Novo Produto</a></li>
                                </ul>
                            </li>
                            <?php
                        endif;
                        if (APP_ORDERS):
                            ?>
                            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'orders/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-cart" title="Pedidos" href="dashboard.php?wc=orders/home">Pedidos</a>
                                <ul class="dashboard_nav_menu_sub">
                                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'orders/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Ver Pedidos" href="dashboard.php?wc=orders/home">&raquo; Ver Pedidos</a></li>
                                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'orders/completed' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Pedidos Completos" href="dashboard.php?wc=orders/completed">&raquo; Concluídos</a></li>
                                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'orders/canceled' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Pedidos Cancelados" href="dashboard.php?wc=orders/canceled">&raquo; Cancelados</a></li>
                                </ul>   
                            </li>
                            <?php
                        endif;

                        if (APP_IMOBI):
                            ?>
                            <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'imobi/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-home3" title="Imóveis" href="dashboard.php?wc=imobi/home">Imóveis</a>
                                <ul class="dashboard_nav_menu_sub">
                                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'imobi/home' || $getViewInput == 'imobi/search' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Ver Imóveis" href="dashboard.php?wc=imobi/home">&raquo; Ver Imóveis</a></li>
                                    <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'imobi/create' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Novo Imóvel" href="dashboard.php?wc=imobi/create">&raquo; Novo Imóvel</a></li>
                                </ul>
                            </li>
                            <?php
                        endif;
                    endif;

                    if (APP_COMMENTS):
                        ?>
                        <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'comments/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-bubbles2" title="Comentários" href="dashboard.php?wc=comments/home">Comentários</a></li>
                        <?php
                    endif;

                    if (APP_SLIDE):
                        ?>
                        <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'slide/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-images" title="Em destaque" href="dashboard.php?wc=slide/home">Em destaque</a>
                            <ul class="dashboard_nav_menu_sub">
                                <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'slide/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Destaques ativos" href="dashboard.php?wc=slide/home">&raquo; Em Destaque</a></li>
                                <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'slide/end' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Agendados ou Inativos" href="dashboard.php?wc=slide/end">&raquo; Agendados ou Inativos</a></li>
                            </ul>
                        </li>
                        <?php
                    endif;

                    if (APP_PAGES):
                        ?>
                        <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'pages/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-pagebreak" title="Páginas" href="dashboard.php?wc=pages/home">Páginas</a></li>
                        <?php
                    endif;

                    if ($Admin['user_level'] >= 8 && APP_USERS):
                        ?>
                        <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'users/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-users" title="Usuários" href="dashboard.php?wc=users/home">Usuários</a>
                            <ul class="dashboard_nav_menu_sub">
                                <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'users/home' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Ver Usuários" href="dashboard.php?wc=users/home">&raquo; Ver Usuários</a></li>
                                <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'users/customers' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Clientes" href="dashboard.php?wc=users/customers">&raquo; Clientes</a></li>
                                <!--<li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'users/subscribers' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Assinantes" href="dashboard.php?wc=users/subscribers">&raquo; Assinantes</a></li>-->
                                <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'users/team' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Equipe" href="dashboard.php?wc=users/team">&raquo; Equipe</a></li>
                                <li class="dashboard_nav_menu_sub_li <?= $getViewInput == 'users/create' ? 'dashboard_nav_menu_active' : ''; ?>"><a title="Novo Usuário" href="dashboard.php?wc=users/create">&raquo; Novo Usuário</a></li>
                            </ul>
                        </li>
                        <?php
                    endif;

                    if ($Admin['user_level'] >= 10):
                        ?>
                        <li class="dashboard_nav_menu_li <?= strstr($getViewInput, 'config/') ? 'dashboard_nav_menu_active' : ''; ?>"><a class="icon-cogs" title="Configurações" href="dashboard.php?wc=config/home">Configurações</a></li>
                        <?php
                    endif;
                    ?>
                    <!--
                    <li class="dashboard_nav_menu_li"><a class="icon-lifebuoy" title="Suporte" href="dashboard.php?wc=home">Suporte</a></li>
                    -->
                    <li class="dashboard_nav_menu_li"><a target="_blank" class="icon-forward" title="Ver Site" href="<?= BASE; ?>">Ver Site</a></li>
                </ul>
            </nav>

            <div class="dashboard">
                <?php
                if (file_exists('../DATABASE.sql')):
                    echo "<div style='padding: 20px;'>";
                    echo Erro("<span class='al_center'><b class='icon-warning'>IMPORTANTE:</b> Para sua segurança delete o arquivo DATABASE.sql da pasta do projeto! <a class='btn btn_red' href='dashboard.php?wc=home&database=true' title=''>Deletar Agora!</a></span>", E_USER_WARNING);
                    echo "</div>";

                    $DeleteDatabase = filter_input(INPUT_GET, 'database', FILTER_VALIDATE_BOOLEAN);
                    if ($DeleteDatabase):
                        unlink('../DATABASE.sql');
                        header('Location: dashboard.php?wc=home');
                    endif;
                endif;
                ?>
                <div class="dashboard_sidebar">
                    <span class="mobile_menu btn btn_blue icon-menu icon-notext"></span>
                    <div class="fl_right">
                        <span class="dashboard_sidebar_welcome m_right">Bem-vindo(a) ao <?= ADMIN_NAME; ?>, Hoje <?= date('d/m/y H\hi'); ?></span>
                        <a class="icon-exit btn btn_red" title="Desconectar do <?= ADMIN_NAME; ?>!" href="dashboard.php?wc=home&logoff=true">Sair!</a>
                    </div>
                </div>

                <?php
                //QUERY STRING
                if (!empty($getView)):
                    $includepatch = __DIR__ . '/_sis/' . strip_tags(trim($getView) . '.php');
                else:
                    $includepatch = __DIR__ . '/_sis/' . 'dashboard.php';
                endif;

                if (file_exists($includepatch)):
                    require_once($includepatch);
                else:
                    $_SESSION['trigger_controll'] = "<b>DESCULPE:</b> O controlador <b class='fontred'>_sis/{$getView}.php</b> não foi encontrado ou não existe no destino especificado!";
                    header('Location: dashboard.php?wc=home');
                endif;
                ?>
            </div>
        </div>
    </body>
</html>
<?php
ob_end_flush();
