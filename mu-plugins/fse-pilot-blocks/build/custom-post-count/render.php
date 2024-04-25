<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<div class="fse-post-grid-comment-count-wrapper">
	   <i class="fa-regular fa-comment"></i>
	   <p class="fse-post-grid-count-comment"><?php echo get_comments_number(get_the_ID());?></p>
</div>
