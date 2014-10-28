<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

<div class="listpost">
    <div>
        <div class="left">
            <a href="<?php the_permalink()?>">
                <?php if(has_post_thumbnail()){
                    the_post_thumbnail('thumbnail');
                } else{
                ?>
                <img src="<?php echo get_template_directory_uri()?>/images/logo.png" />
                <?php    
                }
                ?>
            </a>
        </div>
        <div class="right">
            <h3><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
            <?php the_excerpt()?>
            <a href="<?php the_permalink()?>" class="readmore">Chi tiết</a>
        </div>
        <div class="clear"></div>
    </div>
</div>
