<!-- <article class="box <?= empty($PdtBox) ? 'box4' : $PdtBox; ?>">
    <div class="single_pdt">
        <div class="single_pdt_cover">
            <a href="<?= BASE; ?>/produto/<?= $pdt_name; ?>" title="Ver detalhes de <?= $pdt_title; ?>">
                <img alt="Detalhes do produto <?= $pdt_title; ?>" title="Detalhes do produto <?= $pdt_title; ?>" src="<?= BASE; ?>/tim.php?src=uploads/<?= $pdt_cover; ?>&w=<?= THUMB_W / 2; ?>&h=<?= THUMB_H / 2; ?>"/>
            </a>
            <?php
            $PdtStockeOut = ($pdt_inventory && $pdt_inventory <= 5 ? true : false);

            if ($pdt_offer_price && $pdt_offer_start <= date('Y-m-d H:i:s') && $pdt_offer_end >= date('Y-m-d H:i:s')) :
                $PdtDiscount = number_format(100 - ((100 / $pdt_price) * $pdt_offer_price), '0', '', '');
                $PdtIdentBox = (!empty($PdtStockeOut) ? ' single_pdt_offer_ident' : null);
                echo "<span class='single_pdt_offer{$PdtIdentBox}'>{$PdtDiscount}% OFF</span>";
            endif;

            if ($PdtStockeOut) :
                echo "<span class='single_pdt_stock'>Últimas Unidades</span>";
            endif;
            ?>
        </div>

        <header>
            <h1><a href="<?= BASE; ?>/produto/<?= $pdt_name; ?>" title="Ver detalhes de <?= $pdt_title; ?>"><?= $pdt_title; ?></a></h1>
            <p><?= Check::Words($pdt_subtitle, 10); ?></p>
        </header>

        <div class="single_pdt_price">
            <?php
            $PdtPrice = null;
            if ($pdt_offer_price && $pdt_offer_start <= date('Y-m-d H:i:s') && $pdt_offer_end >= date('Y-m-d H:i:s')) :
                $PdtPrice = $pdt_offer_price;
                echo "<span>de R$ <strike>" . number_format($pdt_price, '2', ',', '.') . "</strike> por</span>Apenas R$ " . number_format($pdt_offer_price, '2', ',', '.');
            else :
                $PdtPrice = $pdt_price;
                echo "<span class='font_white'>-</span>Apenas R$ " . number_format($pdt_price, '2', ',', '.');
            endif;

            if (ECOMMERCE_PAY_SPLIT) :
                $MakeSplit = intval($PdtPrice / ECOMMERCE_PAY_SPLIT_MIN);
                $NumSplit = (!$MakeSplit ? 1 : ($MakeSplit && $MakeSplit <= ECOMMERCE_PAY_SPLIT_NUM ? $MakeSplit : ECOMMERCE_PAY_SPLIT_NUM));
                $SplitPrice = number_format(($PdtPrice * (pow(1 + (ECOMMERCE_PAY_SPLIT_ACM / 100), $NumSplit - ECOMMERCE_PAY_SPLIT_ACN)) / $NumSplit), '2', ',', '.');
                echo "<p class='pdt_single_split'>Em até {$NumSplit}x de R$ {$SplitPrice}</p>";
            endif;
            ?>
        </div>

        <div class="single_pdt_btn">
            <?php require '_cdn/widgets/ecommerce/cart.btn.php'; ?>
        </div>
    </div>
</article> -->

<div class="<?= empty($PdtBox) ? 'col-md-3' : $PdtBox; ?>">
    <div class="wa-theme-design-block">
        <figure class="dark-theme">
            <img src="https://donnaglam.com.br/saf/uploads/<?= $pdt_cover; ?>" alt=" Product" style="cursor: pointer;" onclick="javascript: window.location.href = '<?= BASE; ?>/produto/<?= $pdt_name; ?>';">
            <div class="ribbon"><span>Novo</span></div>
            <span class="block-sticker-tag1">
                <span class="off_tag">
                    <!-- <strong><i class="fa fa-shopping-basket" aria-hidden="true"></i></strong> -->
                    <?php require '_cdn/widgets/ecommerce/cart.btn.php'; ?>
                </span>
            </span>
            <span class="block-sticker-tag2">
                <span class="off_tag2 btn-action btn-quickview" style="cursor: pointer;" onclick="javascript: window.location.href = '<?= BASE; ?>/produto/<?= $pdt_name; ?>';"><strong><i class="fa fa-eye" aria-hidden="true"></i></strong></span>
            </span>
            <!-- <span class="block-sticker-tag3">
                <span class="off_tag1"><strong><i class="fa fa-heart-o" aria-hidden="true"></i></strong></span>
            </span> -->
        </figure>
        <div class="block-caption1">
            <div class="price">
                <?php
                $PdtPrice = null;
                if ($pdt_offer_price && $pdt_offer_start <= date('Y-m-d H:i:s') && $pdt_offer_end >= date('Y-m-d H:i:s')) :
                    $PdtPrice = $pdt_offer_price;
                    echo "<span class='sell-price'>De R$ <strike>" . number_format($pdt_price, '2', ',', '.') . "</strike></span>";
                    echo "<span class='actual-price'>Por apenas R$ " . number_format($pdt_offer_price, '2', ',', '.');
                else :
                    $PdtPrice = $pdt_price;
                    echo "<span class='font_white'></span>Apenas R$ " . number_format($pdt_price, '2', ',', '.');
                endif;
                ?>
            </div>
            <div class="clear"></div>
            <h4>
                <a href="<?= BASE; ?>/produto/<?= $pdt_name; ?>"><?= $pdt_name; ?></a>
            </h4>
        </div>
    </div>
</div>