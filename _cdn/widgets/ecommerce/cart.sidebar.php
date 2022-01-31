<?php
if (!empty($_SESSION['wc_order'])) :
    $OderDetail = $_SESSION['wc_order'];
    $OderCupom = (!empty($_SESSION['wc_cupom']) ? $_SESSION['wc_cupom'] : null);
?><section class='workcontrol_order_details'>
        <h5 style="border-bottom: #dedede dotted  1px; padding-bottom: 5px;">Resumo do pedido</h5>
        <?php
        $SideTotalCart = 0;
        $thumb_width = THUMB_W / 10;
        $thumb_height = THUMB_H / 10;

        foreach ($OderDetail as $SideItemId => $SideItemAmount) :
            $Read->ExeRead(DB_PDT, "WHERE pdt_id = :id", "id={$SideItemId}");
            if ($Read->getResult()[0]) :
                $SideProduct = $Read->getResult()[0];
                $SideProductPrice = ($SideProduct['pdt_offer_price'] && $SideProduct['pdt_offer_start'] <= date('Y-m-d H:i:s') && $SideProduct['pdt_offer_end'] >= date('Y-m-d H:i:s') ? $SideProduct['pdt_offer_price'] : $SideProduct['pdt_price']);
                echo "<p>";
                echo "<img title='{$SideProduct['pdt_title']}' alt='{$SideProduct['pdt_title']}' src='https://donnaglam.com.br/saf/uploads/{$SideProduct['pdt_cover']}' />";
                echo "<span>" . Check::Chars($SideProduct['pdt_title'], 42) . "<br>{$SideItemAmount} * R$ " . number_format($SideProductPrice, '2', ',', '.') . "</span>";
                echo "</p>";
                $SideTotalCart += $SideProductPrice * $SideItemAmount;
            endif;
        endforeach;

        $SideTotalPrice = (!empty($_SESSION['wc_cupom']) ? $SideTotalCart * ((100 - $_SESSION['wc_cupom']) / 100) : $SideTotalCart);
        ?>
        <div class="workcontrol_order_details_total">
            <div class="wc_cart_total">Sub-total: <b>R$ <span><?= number_format($SideTotalCart, '2', ',', '.'); ?></span></b></div>
            <?php if ($OderCupom) : ?>
                <div class="wc_cart_discount">Desconto: <b><strike>R$ <span><?= number_format($SideTotalCart * ($OderCupom / 100), '2', ',', '.'); ?></span></strike></b></div>
            <?php endif; ?>
            <div class="wc_cart_shiping">Frete: <b>R$ <span><?= number_format((!empty($_SESSION['wc_shipment']['wc_shipprice']) ? $_SESSION['wc_shipment']['wc_shipprice'] : 0), '2', ',', '.'); ?></span></b></div>
            <div class="wc_cart_price">Total: <b>R$ <span><?= number_format((!empty($_SESSION['wc_shipment']['wc_shipprice']) ? $SideTotalPrice + $_SESSION['wc_shipment']['wc_shipprice'] : $SideTotalPrice), '2', ',', '.'); ?></span></b></div>
        </div>
    </section><?php


            endif;
