<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
   <div class="box-category">
    <ul>
      <?php foreach ($informations as $information) { ?>
      <li><img src="catalog/view/theme/<?php echo $template; ?>/image/info-arrow.png"><a style="padding-left:7px;" href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
      <?php } ?>
      <li><img src="catalog/view/theme/<?php echo $template; ?>/image/info-arrow.png"><a style="padding-left:7px;" href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
      <li><img src="catalog/view/theme/<?php echo $template; ?>/image/info-arrow.png"><a style="padding-left:7px;" href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
    </ul>
   </div>
  </div>
</div>
