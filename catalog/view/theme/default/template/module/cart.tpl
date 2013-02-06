<ul class="nav pull-right">
    <li class="divider-vertical"></li>
    <?php if ($products || $vouchers) { ?>
    <li id="cart-total"><a href="<?php echo $checkout; ?>"><i class="icon-download-alt"></i> <span id="quantityProduct"><?=$text_count_products;?></span> <i class="icon-shopping-cart"></i><span id="totalProduct"><?=$text_price;?></span></a></li>
    <? } else { ?>
    <li id="cart-total"><a href="<?php echo $checkout; ?>"><i class="icon-shopping-cart"></i> Товаров нет</a></li>
    <?php } ?></ul>
