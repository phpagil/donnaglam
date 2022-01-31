<form id="<?= $pdt_id; ?>" class="wc_cart_add" name="cart_add" method="post" enctype="multipart/form-data">
    <input name="pdt_id" type="hidden" value="<?= $pdt_id; ?>" />
    <button id="<?= $pdt_id; ?>" class="wc_cart_less cart_more less">-
    </button>
    <input name="item_amount" type="text" value="1" max="<?= $pdt_inventory; ?>" />
    <button id="<?= $pdt_id; ?>" class="wc_cart_plus cart_more plus">+</button>


    <!-- 
    <span class="quantity">
        <input type="text" class="input-text qty text" title="Qty" value="1" max="<?= $pdt_inventory; ?>" name="item_amount">
        <input id="<?= $pdt_id; ?>" type="button" class="minus wc_cart_less cart_more less" value="-">
        <input id="<?= $pdt_id; ?>" type="button" class="plus wc_cart_plus cart_more plus" value="+">
    </span>
    <span><a class="btn rd-stroke-btn border_2px dart-btn-sm" href="#">+ Carrinho</a></span>
    <span><button class="btn <?= (!empty($CartBtn) ? $CartBtn : 'btn_green'); ?>"><?= ECOMMERCE_BUTTON_TAG; ?></button></span>
    
-->
</form>