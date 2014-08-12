<!-- html here for like box -->

<div class="wcgr-like-box">
	<a href="javascript:;" class="like-this-post" data-post_id="<?php the_ID(); ?>">Click to like</a>
	<span class="like-count" id="count-<?php the_ID(); ?>">
		<?php echo intval( get_post_meta( get_the_ID(), 'like_count', 1 ) ); ?>
	</span>
</div>
<div class="clear clearfix"></div>