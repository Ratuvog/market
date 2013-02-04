<?php if ($products || $vouchers) { ?>
<li id="cart-total"><a href=""><i class="icon-download-alt"></i> <?=$text_count_products;?> <i class="icon-shopping-cart"></i><?=$text_price;?></a></li>
<? }?>
<?php if ($products || $vouchers) { ?>
<div class="mini-cart-info">
  <table>
    <?php foreach ($products as $product) { ?>
    <tr>
      <td class="image"><?php if ($product['thumb']) { ?>
        <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
        <?php } ?></td>
      <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
        <div>
          <?php foreach ($product['option'] as $option) { ?>
          - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
          <?php } ?>
        </div></td>
      <td class="quantity">x&nbsp;<?php echo $product['quantity']; ?></td>
      <td class="total"><?php echo $product['total']; ?></td>
      <td class="remove"><img src="catalog/view/theme/default/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="$('#cart').load('index.php?route=module/cart&remove=<?php echo $product['key']; ?> #cart > *');" /></td>
    </tr>
    <?php } ?>
    <?php foreach ($vouchers as $voucher) { ?>
    <tr>
      <td class="image"></td>
      <td class="name"><?php echo $voucher['description']; ?></td>
      <td class="quantity">x&nbsp;1</td>
      <td class="total"><?php echo $voucher['amount']; ?></td>
      <td class="remove"><img src="catalog/view/theme/default/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="$('#cart').load('index.php?route=module/cart&remove=<?php echo $voucher['key']; ?> #cart > *');" /></td>
    </tr>
    <?php } ?>
  </table>
</div>
<div class="mini-cart-total">
  <table>
    <?php foreach ($totals as $total) { ?>
    <tr>
      <td align="right"><b><?php echo $total['title']; ?>:</b></td>
      <td align="right"><?php echo $total['text']; ?></td>
    </tr>
    <?php } ?>
  </table>
</div>
<div class="checkout"><a href="<?php echo $cart; ?>" class="button"><?php echo $text_cart; ?></a> <a href="<?php echo $checkout; ?>" class="button"><?php echo $text_checkout; ?></a></div>
<?php } else { ?>
<li><a href=""><i class="icon-shopping-cart"></i> Товаров нет</a></li>
<?php } ?>
