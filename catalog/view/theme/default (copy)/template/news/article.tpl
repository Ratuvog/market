<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
 <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
   <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
     <?php } ?>
 </div>
 <?php if (isset($news_info)) { ?>
 <h1><?php echo $heading_title; ?></h1>
 <div class="border">
  <div style="display: block;">
    <?php if ($thumb) { ?>
     <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img class="article-image" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
    <?php } ?>
    <?php echo $description; ?>
    <br />
	<div class="article-share">
	 <!-- AddThis Button BEGIN -->
	 <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
	 <a class="addthis_button_preferred_1"></a>
	 <a class="addthis_button_preferred_2"></a>
	 <a class="addthis_button_preferred_3"></a>
	 <a class="addthis_button_preferred_4"></a>
	 <a class="addthis_button_compact"></a>
	 <a class="addthis_counter addthis_bubble_style"></a>
	</div>
	<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f6a758d24474e98"></script>
	<!-- AddThis Button END -->
   </div>
   <?php if ($products) { ?>
   <div class="article-prelated-head"><?php echo $news_prelated; ?></div>
   <div class="article-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>
      <div>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><span><?php echo $button_cart; ?></span></a></div>
      <?php } ?>
    </div>
   </div>
   <?php } ?>
   <?php if ($acom != 0) { ?>
    <div class="line-article-coments"><span class="title-coments"><?php echo $text_coms; ?></span> "<?php echo $heading_title; ?>" <span class="title-coments">-</span> <span class="article-coments"><?php echo $title_comments; ?></span> <span class="title-coments"><?php echo $item_comments; ?></span></div>
	<?php if ($comment) { ?>
     <?php foreach ($comment as $comment) { ?>
      <div class="article-content"><div class="article-author-head"><b><?php echo $comment['author']; ?></b> - <?php echo $comment['date_added']; ?></div>
      <br />
      <?php echo $comment['text']; ?></div>
     <?php } ?>
     <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>
    <div class="article-content">
     <h2 id="review-title"><?php echo $writec; ?></h2>
     <b><?php echo $entry_name; ?></b><br />
     <input type="text" name="name" value="" />
     <br />
     <br />
     <b><?php echo $entry_review; ?></b>
     <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
     <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
     <br />
     <b><?php echo $entry_captcha; ?></b><br />
     <input type="text" name="captcha" value="" />
     <br />
     <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
     <br />
     <div class="buttons">
      <div class="right"><a id="button-comment" class="button"><span><?php echo $text_send; ?></span></a></div>
     </div>
    </div>
    <?php } ?>
	<div class="buttons">
       <div class="right"><a onclick="location='<?php echo $news; ?>'" class="button"><?php echo $button_news; ?></a></div>
	</div>
   </div>
   <?php } ?>
  </div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	overlayClose: true,
	opacity: 0.5
});
//--></script> 
<script type="text/javascript"><!--
$('#button-comment').bind('click', function() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=news/article/writecomment&news_id=<?php echo $news_id; ?>',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-comment').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-comment').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#review-title').after('<div class="warning">' + data.error + '</div>');
			}
			
			if (data.success) {
				$('#review-title').after('<div class="success">' + data.success + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<?php echo $footer; ?> 