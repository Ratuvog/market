<div class="box">
 <div class="box-heading"><?php echo $heading_title; ?></div>
 <div class="box-content">
  <div class="box-news-side">
    <?php foreach ($news as $news_story) { ?>
      <div>
	   <div class="news-story-title"><a href="<?php echo $news_story['href']; ?>"><?php echo $news_story['title']; ?></a></div>
       <div class="description"><?php echo $news_story['short_description']; ?></div>
	   <div class="info">
	   <div class="news-story-read-more"><a href="<?php echo $news_story['href']; ?>"><?php echo $text_read_more; ?></a></div>
	   <?php if ($news_story['acom']) { ?>
	    <div class="news-story-coments"><?php echo $text_comments; ?> <?php echo $news_story['total_comments']; ?></div> 
	   <?php } ?>
	   </div>
	  </div>
    <?php } ?>
	<center><a class="button" href="<?php echo $newslink; ?>"><?php echo $text_headlines; ?></a></center>
  </div>
 </div>
</div>

