<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();
        $currentId = get_the_ID();
        ?>
            <div class="myproduct">
                <div class="left">
                    <?php the_post_thumbnail('full')?>
                </div>
                <div class="right">
                    <h1><?php the_title()?></h1>
                    
                    <p><span>Mã sản phẩm:</span> <?php echo get_post_meta(get_the_ID(), 'wpcf-sku', true)?></p>
                    <p><span>Tình trạng:</span> <?php echo get_post_meta(get_the_ID(), 'wpcf-status', true)?></p>
                    <div class="lienhenow">
                        Liên hệ với chúng tôi: <br>
                        <span class="add33">439/29 Tam Kỳ, Quảng Nam</span><br>
                        <span class="phone33">086 6810415/ 0902359377</span><br>
                        <span class="email33">quoccuongmykolor@gmail.com</span><br>
                        
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="entry-content">
                    <h2 class="mota">Mô tả</h2>
                    
                    <?php the_content()?>
                </div>
                
            </div>
        <?php
        endwhile;
        wp_reset_query();
		?>
		</div><!-- #content -->
        
        <div class="relatedProduct">
            <h2 class="mota">Sản phẩm liên quan</h2>
            <?php
            $args = array(
            	'post_type' => 'product',
                'posts_per_page' => 4,
                'post__not_in'=>array($currentId)
            );
			query_posts($args);
			while ( have_posts() ) : the_post();
				?>
                <div class="productbox productbox4">
                    <div>
                        <a title="<?php the_title()?>" href="<?php the_permalink()?>"><?php the_post_thumbnail('medium')?></a>
                        <h2><a title="<?php the_title()?>" href="<?php the_permalink()?>"><?php the_title()?></a></h2>
                    </div>
                </div>
                <?php
			endwhile;
            wp_reset_query();
            echo '<div class="clear"></div>';
		?>
        </div>
	</div><!-- #primary -->
    <?php get_sidebar( 'content' );?>
    <div class="clear"></div>
<?php

get_footer();
