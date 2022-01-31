<? $CartTotal = 0; ?>
<div class="attr-nav">
    <ul>
        <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
        <li class="dropdown">
            <a href="<?= BASE; ?>/pedido/home" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-shopping-bag"></i>
                <span class="badge">
                    <?php if (isset($_SESSION['wc_order'])) {
                        echo count($_SESSION['wc_order']);
                    } else {
                        echo '0';
                    }
                    ?>
                </span>
            </a>
            <ul class="dropdown-menu cart-list">
                <?php
                if (isset($_SESSION['wc_order'])) :

                    foreach ($_SESSION['wc_order'] as $ItemId => $ItemAmount) :
                        $Read->ExeRead(DB_PDT, "WHERE pdt_status = 1 AND (pdt_inventory IS NULL OR pdt_inventory >= 1) AND pdt_id = :id", "id={$ItemId}");
                        if ($Read->getResult()) :
                            extract($Read->getResult()[0]);
                            $ItemPrice = ($pdt_offer_price && $pdt_offer_start <= date('Y-m-d H:i:s') && $pdt_offer_end >= date('Y-m-d H:i:s') ? $pdt_offer_price : $pdt_price);
                            $CartTotal += $ItemPrice * $ItemAmount;
                ?>
                            <li>
                                <a href="#" class="photo">
                                    <?= "<img title='{$pdt_title}' class='cart-thumb' alt='{$pdt_title}' src='https://donnaglam.com.br/saf/uploads/" . $pdt_cover . "' />"; ?>
                                </a>
                                <h6><a href="<?= BASE . "/produto/{$pdt_name}"; ?>"><?= $pdt_title; ?></a></h6>
                                <p><?= $ItemAmount; ?>x - <span class="price">
                                        <?= ($pdt_price != $ItemPrice ? "<span class='discount'>De R$ <strike>" . number_format($pdt_price, '2', ',', '.') . "</strike></span>Por " : '') . "R$ " . number_format($ItemPrice, '2', ',', '.'); ?>
                                    </span></p>
                            </li>
                <?php
                        else :
                            unset($_SESSION['wc_order'][$ItemId]);
                        endif;
                    endforeach;
                endif;
                ?>
                <li class="total">
                    <span class="pull-right"><strong>Total</strong>: <?= number_format($CartTotal, 2, ',', '.'); ?></span>
                    <a href="<?= BASE; ?>/pedido/home" class="btn btn-default btn-cart">Carrinho</a>
                </li>
            </ul>
        </li>
        <li class="side-menu"><a href="#"><i class="fa fa-bars"></i></a></li>
    </ul>
</div>