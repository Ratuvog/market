<div class="box">
 <div class="box-heading"><?php echo $heading_title; ?> - <a href="<?php echo $newslink; ?>"><?php echo $text_headlines; ?></a></div>
 <div class="box-content">
  <div class="box-news-story">
    <?php foreach ($news as $news_story) { ?>
     <div>
	  <div class="news-story-title"><a href="<?php echo $news_story['href']; ?>"><?php echo $news_story['title']; ?></a></div>
      <?php echo $news_story['short_description2']; ?>
	  <?php if ($news_story['acom']) { ?>
	   <div class="news-story-coments"><?php echo $text_comments; ?> <?php echo $news_story['total_comments']; ?></div> 
	  <?php } ?>
	  <div class="news-story-read-more"><a href="<?php echo $news_story['href']; ?>" class="button"><?php echo $text_read_more; ?></a></div>
	 </div>
    <?php } ?>
  </div>
 </div>
</div>

