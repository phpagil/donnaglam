<?php
if (!APP_ORDERS) :
    require REQUIRE_PATH . '/404.php';
else :
?>
    <?php require '_cdn/widgets/ecommerce/cart.php'; ?>
    <div class="clear"></div>
<?php
endif;
