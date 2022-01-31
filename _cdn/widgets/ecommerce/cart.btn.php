<form class="wc_cart_add" id="form_add_<?= $pdt_id; ?>" name="cart_add" method="post" enctype="multipart/form-data">
    <input name="pdt_id" type="hidden" value="<?= $pdt_id; ?>" />
    <input name="item_amount" type="hidden" value="1" />
    <button style="border: none; background: none;">
        <strong>
            <i class="fa fa-shopping-basket" aria-hidden="true" onclick="console.log(document.getElementById('form_add_<?= $pdt_id; ?>').submit)"></i>
        </strong>
    </button>
</form>