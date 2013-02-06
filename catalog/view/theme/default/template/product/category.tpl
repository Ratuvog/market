<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <?php echo $column_right; ?>
    <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
    <?php echo $content_top; ?>
    <div class="row-fluid products">
    <?php foreach ($products as $product) { ?>
        <div class="category-product-card span3 row-fluid ">
            <div class="minicard-header"><?=$product['name'];?></div>
            <div class="minicard-content">
                <table style="width: 100%">
                    <tbody><tr>
                            <td style="width: 40%"><img class="product-img" src="<?=$product['thumb'];?>" alt="<?=$product['name'];?>"></td>
                            <td style="width: 60%">
                                <span class="span12 muted" style="margin-left: 5px;"><?=$product['category_name'];?></span>
                                <span class="span12 price-product"><h5><?=$product['price'];?></h5></span>
                                <span class="span12">от 950 грамм</span>
                                <span class="span12">
                                    <? $i=1;
                                        for($j=1;$j<=5;$j++) {
                                        ?>
                                        <? if($j==$product['rating']) { ?>
                                        <input name="star<?=$product['name'].$j;?>" type="radio" class="star" checked="checked" disabled="disabled"/>
                                        <? } else { ?>
                                        <input name="star<?=$product['name'].$j;?>" type="radio" class="star" disabled="disabled"/>
                                        <? } ?>
                                        <? }?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="span6">
                                    <table>
                                        <tbody><tr class="cart-button" onclick="addToCart('<?php echo $product['product_id']; ?>');">
                                                <td class="cart-button-image"></td>
                                                <td class="cart-button-text">В корзину</td>
                                            </tr>
                                        </tbody></table>
                                </div>
                                <div class="span4">
                                    <a href="<?=$product['href'];?>">Подробнее...</a>
                                </div>
                            </td>
                        </tr>
                    </tbody></table>
            </div>
        </div>
    <? } ?>
    </div>

  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>