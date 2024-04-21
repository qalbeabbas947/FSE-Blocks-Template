<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$post_type = [];
$post_type_slugs = [];
if( isset( $attributes['post_type'] ) && !empty( $attributes['post_type'] ) ) { 
    $post_type = json_decode($attributes['post_type']);
    foreach( $post_type as $ptype ) {
        $post_type_slugs[] = $ptype->value;
    }
}


// $is_featured = 0;
// if( isset( $attributes['is_featured'] ) && !empty( $attributes['is_featured'] ) ) { 
// 	$is_featured = $attributes['is_featured'];
// }

$category = [];
$category_ids = [];
$args = [];
$args['posts_per_page'] = 1;
$exclude_id = 0;
if( isset( $attributes['category'] ) && !empty( $attributes['category'] ) ) { 
    $category = json_decode($attributes['category']);
    foreach( $category as $ctype ) {
        $category_ids[] = $ctype->value;
    }

    $args['category__in'] = $category_ids;
    
} else {
    $args['post_type'] = $post_type_slugs;
}

?>

<div class="fse-pd-post-list-wrapper">
    <?php
        $query = new WP_Query( $args );
        while ($query->have_posts()):
            $query->the_post(); 
            $exclude_id = get_the_ID();
            ?>
            <div class="feature-pd-post-wrapper">
                
                <?php the_post_thumbnail( 'large', ['class' => 'feature-pd-image', 'alt' => get_the_title(), 'title' => get_the_title()] );?>
                <div class="post-pd-details">
                    <span class="fse-pd-feature-category"><?php the_category();?></span>
                    <h2 class="fse-pd-feature-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p class="fse-pd-feature-description"><?php the_excerpt(  ); ?></p>
                    <div class="fse-pd-feature-metadata">
                        <span class="fse-pd-date"><?php the_time('F j, Y');?></span>
                        <span class="fse-pd-comments">
                            <i class="fa-regular fa-comment"></i>
                            <p class="fse-pd-side-comment-count"><?php echo get_comments_number(get_the_ID());?></p>
                        </span>
                    </div>
                </div>
            </div>
        <?php    
        endwhile; 
        wp_reset_postdata();   
    ?>
    
    <div class="fse-pd-right-side-post-list">
        <!-- Right Side Grid 1 -->
        <?php
        $args['posts_per_page'] = 3;
        $args['post__not_in'] = [$exclude_id];
        
        $query = new WP_Query( $args );
        while ($query->have_posts()):
            $query->the_post(); ?>
            <div class="fse-pd-side-grid">
                <div class="side-pd-grid-feature-image">
                    <?php the_post_thumbnail( 'thumbnail', ['class' => 'fse-pd-side-feature-image', 'alt' => get_the_title(), 'title' => get_the_title()] );?>
                </div>
                <div class="fse-pd-side-metadata">
                    <span class="category-pd"><?php the_category();?></span>
                    <h3 class="fse-pd-side-grid-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="date-pd-and-comment-wrapper">
                        <span class="fse-pd-date"><?php the_time('F j, Y');?></span>
                        <span class="fse-pd-comments">
                            <i class="fa-regular fa-comment"></i>
                            <p class="fse-pd-side-comment-count"><?php echo get_comments_number(get_the_ID());?></p>
                        </span>
                    </div>
                </div>
            </div>
        <?php    
            endwhile; 
            wp_reset_postdata();   
        ?>
        <!-- Right Side Grid 2 -->
        <!-- <div class="fse-pd-side-grid">
            <div class="side-pd-grid-feature-image">
                <img class="fse-pd-side-feature-image" src="assets/images/image2.png" alt="Feature Image">
            </div>
            <div class="fse-pd-side-metadata">
                <span class="category-pd">Reviews</span>
                <h3 class="fse-pd-side-grid-title">We’ve Tested the LEGO Ideas Twilight Set</h3>
                <div class="date-pd-and-comment-wrapper">
                    <span class="fse-pd-date">Dec 22, 2023</span>
                    <span class="fse-pd-comments">
                        <i class="fa-regular fa-comment"></i>
                        <p class="fse-pd-side-comment-count">1</p>
                    </span>
                </div>
            </div>
        </div> -->
        <!-- Right Side Grid 3 -->
        <!-- <div class="fse-pd-side-grid">
            <div class="side-pd-grid-feature-image">
                <img class="fse-pd-side-feature-image" src="assets/images/image4.png" alt="Feature Image">
            </div>
            <div class="fse-pd-side-metadata">
                <span class="category-pd">Reviews</span>
                <h3 class="fse-pd-side-grid-title">Which Video Game Console Is Next To Be LEGO-Ified?</h3>
                <div class="date-pd-and-comment-wrapper">
                    <span class="fse-pd-date">Dec 22, 2023</span>
                    <span class="fse-pd-comments">
                        <i class="fa-regular fa-comment"></i>
                        <div class="fse-pd-side-comment-count">1</div>
                    </span>
                </div>
            </div>
        </div> -->
    </div>
</div>

