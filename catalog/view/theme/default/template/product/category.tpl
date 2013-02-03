<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <?php echo $column_right; ?>

    <?php echo $content_top; ?>
    <div class="row-fluid">
    <?php foreach ($products as $product) { ?>
        <div class="span3 row-fluid category-product-card">
            <div class="minicard-header"><?=$product['name'];?></div>
            <div class="minicard-content">
                <table>
                    <tbody><tr>
                            <td><img src="<?=$product['thumb'];?>" alt="<?=$product['name'];?>"></td>
                            <td>
                                <span class="span12 muted" style="margin-left: 5px;">Протеин</span>
                                <span class="span12 price-product"><h5><?=$product['price'];?></h5></span>
                                <span class="span12">от 950 грамм</span>
                                <span class="span12">
                                    <div class="statVal rating_1">
                                        <div class="statVal">
                                            <span class="ui-rater-starsOff" style="width: 90px; cursor: pointer; "><span class="ui-rater-starsOn" style="width: 63px; cursor: pointer; "></span></span>
                                        </div>
                                    </div>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="span6">
                                    <table>
                                        <tbody><tr class="cart-button">
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
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>