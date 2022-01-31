<section class="featured-product">
    <div class="container">
        <div class="row">
            <div class="dart-headingstyle-one dart-mb-60 text-center">
                <!--Style 1-->
                <h2 class="dart-heading">Produtos Donna Glam</h2>
                <img src="<?= BASE; ?>/_cdn/images/Icon-sep.png" alt="img">
            </div>

            <div class="col-md-12">
                <?php
                $Page = (!empty($URL[1]) && filter_var($URL[1], FILTER_VALIDATE_INT) ? $URL[1] : 1);
                $Pager = new Pager(BASE . "/index/", "<<", ">>", 3);
                $Pager->ExePager($Page, 12);
                $Read->ExeRead(DB_PDT, "WHERE (pdt_inventory >= 1 OR pdt_inventory IS NULL) AND pdt_status = 1 AND NOT pdt_cover = '' ORDER BY pdt_title ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                if ($Read->getResult()) :
                    foreach ($Read->getResult() as $LastPDT) :
                        extract($LastPDT);
                        $PdtBox = 'col-md-3';
                        require 'inc/product.php';
                    endforeach;

                    echo "<br clear='all' />";
                    $Pager->ExePaginator(DB_PDT, "WHERE (pdt_inventory >= 1 OR pdt_inventory IS NULL) AND pdt_status = 1");
                    echo $Pager->getPaginator();

                else :
                    $Pager->ReturnPage();
                    Erro("Ainda Não Existe Produtos Cadastrados. Por favor, volte mais tarde.", E_USER_NOTICE);
                endif;
                ?>
            </div>

</section>