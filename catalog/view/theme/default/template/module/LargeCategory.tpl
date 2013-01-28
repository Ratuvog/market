<div class="row-fluid" style="margin-left: -12px;">
    <span class="span12">
        <ul class="nav nav-pills">
            <?php foreach ($categories as $category) { ?>
            <?php if ($category['category_id'] == $category_id) { ?>
            <li class="active">
            <? } else { ?>
            <li>
            <? } ?>
                <a href="<?php echo $child['href']; ?>"><?=$category['name'];?></a>
            </li>
            <?php } ?>
        </ul>
    </span>
</div>
