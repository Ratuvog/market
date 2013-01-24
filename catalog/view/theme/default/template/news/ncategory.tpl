<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <div class="border">
  <?php if ($thumb || $description) { ?>
  <div class="category-info">
    <?php if ($thumb) { ?>
    <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
    <?php } ?>
    <?php if ($description) { ?>
    <?php echo $description; ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if ($ncategories) { ?>
  <h2><?php echo $text_refine; ?></h2>
  <div class="category-list" style="border-bottom: 1px solid #eee;">
    <?php if (count($ncategories) <= 5) { ?>
    <ul>
      <?php foreach ($ncategories as $ncategory) { ?>
      <li><a href="<?php echo $ncategory['href']; ?>"><?php echo $ncategory['name']; ?></a></li>
      <?php } ?>
    </ul>
    <?php } else { ?>
    <?php for ($i = 0; $i < count($ncategories);) { ?>
    <ul>
      <?php $j = $i + ceil(count($ncategories) / 4); ?>
      <?php for (; $i < $j; $i++) { ?>
      <?php if (isset($ncategories[$i])) { ?>
      <li><a href="<?php echo $ncategories[$i]['href']; ?>"><?php echo $ncategories[$i]['name']; ?></a></li>
      <?php } ?>
      <?php } ?>
    </ul>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if ($article) { ?>
  <div class="product-list">
    <?php foreach ($article as $articles) { ?>
    <div>
	<?php if ($articles['thumb']) { ?>
      <div class="image"><a href="<?php echo $articles['href']; ?>"><img src="<?php echo $articles['thumb']; ?>" title="<?php echo $articles['name']; ?>" alt="<?php echo $articles['name']; ?>" /></a></div>
      <?php } ?>
      <div class="name"><a href="<?php echo $articles['href']; ?>"><?php echo $articles['name']; ?></a> <span class="headlines-text-coments">- <?php echo $articles['date_added']; ?></span></div>
      <div class="description"><?php echo $articles['description']; ?></div>
	  <?php if ($articles['acom']) { ?>
	  <span class="headlines-text-coments"><?php echo $text_comments; ?>: <?php echo $articles['total_comments']; ?></span>
	  <?php } ?>
	  <div class="button-more"><a class="button" href="<?php echo $articles['href']; ?>"><span><?php echo $button_more; ?></span></a></div>
    </div>
    <?php } ?>
  </div>
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } ?>
  <?php if (!$ncategories && !$article) { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
  </div>
  <?php } ?>
  </div>
  <?php echo $content_bottom; ?></div>

<?php echo $footer; ?>