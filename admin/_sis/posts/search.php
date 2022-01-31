<?php
$AdminLevel = 6;
if (!APP_POSTS || empty($DashboardLogin) || empty($Admin) || $Admin['user_level'] < $AdminLevel) :
    die('<div style="text-align: center; margin: 5% 0; color: #C54550; font-size: 1.6em; font-weight: 400; background: #111111; float: left; width: 100%; padding: 30px 0;"><b>ACESSO NEGADO:</b> Você não esta logado<br>ou não tem permissão para acessar essa página!</div>');
endif;

$Search = filter_input_array(INPUT_POST);
if ($Search && $Search['s']) :
    $S = urlencode($Search['s']);
    header("Location: dashboard.php?wc=posts/search&s={$S}");
endif;

$GetSearch = filter_input(INPUT_GET, 's', FILTER_DEFAULT);
$ThisSearch = urldecode($GetSearch);
?>

<header class="dashboard_header">
    <div class="dashboard_header_title">
        <h1 class="icon-search">Pesquisar Posts:</h1>
        <p class="dashboard_header_breadcrumbs">
            &raquo; <?= ADMIN_NAME; ?>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=home">Dashboard</a>
            <span class="crumb">/</span>
            <a title="<?= ADMIN_NAME; ?>" href="dashboard.php?wc=posts/home">Posts</a>
            <span class="crumb">/</span>
            Pesquisa
        </p>
    </div>

    <div class="dashboard_header_search">
        <form name="searchPosts" action="" method="post" enctype="multipart/form-data" class="ajax_off">
            <input type="search" name="s" value="<?= htmlspecialchars($ThisSearch); ?>" placeholder="Pesquisar Artigo:" required />
            <button class="btn btn_green icon icon-search icon-notext"></button>
        </form>
    </div>

</header>
<div class="dashboard_content">
    <?php
    $getPage = filter_input(INPUT_GET, 'pg', FILTER_VALIDATE_INT);
    $Page = ($getPage ? $getPage : 1);
    $Paginator = new Pager("dashboard.php?wc=posts/search&s={$GetSearch}&pg=", '<<', '>>', 5);
    $Paginator->ExePager($Page, 12);

    $Read = new Read;
    $Read->ExeRead(DB_POSTS, "WHERE post_title LIKE '%' :s '%' OR post_content LIKE '%' :s '%' ORDER BY post_status ASC, post_date DESC LIMIT :limit OFFSET :offset", "s={$ThisSearch}&limit={$Paginator->getLimit()}&offset={$Paginator->getOffset()}");
    if (!$Read->getResult()) :
        $Paginator->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Olá {$Admin['user_name']}. Sua pesquisa para {$ThisSearch} não obteve resultados. Você pode tentar outros termos!</span>", E_USER_NOTICE);
    else :
        foreach ($Read->getResult() as $POST) :
            extract($POST);

            $PostCover = (file_exists("../uploads/{$post_cover}") && !is_dir("../uploads/{$post_cover}") ? "uploads/{$post_cover}" : 'admin/_img/no_image.jpg');
            $PostStatus = ($post_status == 1 ? '<span class="btn btn_green icon-checkmark icon-notext"></span>' : '<span class="btn btn_yellow icon-warning icon-notext"></span>');
            $post_title = (!empty($post_title) ? $post_title : 'Edite esse rascunho para poder exibir como artigo em seu site!');

            $Category = null;
            if (!empty($post_category)) :
                $Read->FullRead("SELECT category_name FROM " . DB_CATEGORIES . " WHERE category_id = :ct", "ct={$post_category}");
                if ($Read->getResult()) :
                    $Category = "<span class='icon-price-tags'>{$Read->getResult()[0]['category_name']}</span> ";
                endif;
            endif;

            if (!empty($post_category_parent)) :
                $Read->FullRead("SELECT category_name FROM " . DB_CATEGORIES . " WHERE category_id IN({$post_category_parent})");
                if ($Read->getResult()) :
                    foreach ($Read->getResult() as $SubCat) :
                        $Category .= "<span class='icon-price-tag'>{$SubCat['category_name']}</span> ";
                    endforeach;
                endif;
            endif;

            echo "<article class='box box25 post_single' id='{$post_id}'>
                <div class='post_single_cover'>
                    <img alt='{$post_title}' title='{$post_title}' src='../tim.php?src={$PostCover}&w=" . IMAGE_W . "&h=" . IMAGE_H . "'/>
                    <div class='post_single_status'><span class='btn'>" . str_pad($post_views, 4, 0, STR_PAD_LEFT) . "</span>{$PostStatus}</div>
                    <div class='post_single_cat'>{$Category}</div>
                </div>
                <div class='box_content'>
                    <h1 class='title'>" . Check::Chars($post_title, 60) . "</h1>
                    <a title='Ver artigo no site' target='_blank' href='" . BASE . "/artigo/{$post_name}' class='icon-notext icon-eye btn btn_green'></a>
                    <a title='Editar Artigo' href='dashboard.php?wc=posts/create&id={$post_id}' class='post_single_center icon-notext icon-pencil btn btn_blue'></a>
                    <span class='icon-notext icon-cancel-circle btn btn_red j_post_delete' id='{$post_id}'></span>
                    <span class='icon-warning btn btn_yellow j_post_delete_confirm' style='display: none' id='{$post_id}'>Deletar Post?</span>
                </div>
            </article>";
        endforeach;

        $Paginator->ExePaginator(DB_POSTS, "WHERE post_title LIKE '%' :s '%' OR post_content LIKE '%' :s '%'", "s={$ThisSearch}");
        echo $Paginator->getPaginator();
    endif;
    ?>
</div>