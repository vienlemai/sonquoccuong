<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="main-content" class="main-content">
   

	<div id="primary" class="content-area">
		<div class="myslider">
            <?php echo do_shortcode('[metaslider id=23]')?>
        </div>
        
        <div class="featuredProduct">
            <?php 
            query_posts('posts_per_page=1&post_type=product');
			while ( have_posts() ) : the_post();
				?>
                <div class="left"><?php the_post_thumbnail('medium')?></div>
                <div class="right">
                    <h3 class="title22"><?php the_title()?></h3>
                    <?php the_excerpt()?>
                    <a href="<?php the_permalink()?>" class="readmore">Chi tiết</a>
                </div>
                <div class="clear"></div>
                <?php
			endwhile;
            wp_reset_query();
            ?>
            
        </div>
        
        <div class="phoimaudep">
            <img src="<?php echo get_template_directory_uri(); ?>/images/nhadep.png" />
            <a class="link1" href="#">Nhà phố</a>
            <a class="link2" href="#">Biệt thự</a>
        </div>
        
        <div class="otherSupport">
            <h2>Các hổ trợ khác</h2>
            
            <div>
                <div class="box">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/img1.jpg" />
                        <p>Phần mền phối màu trên SmartPhone </p>
                    </a>
                </div>
                <div class="box">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/img2.jpg" />
                        <p> 	Phối màu sơn nhà 3D trên phần mềm KOLORMAX </p>
                    </a>
                </div>
                <div class="box">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/img3.jpg" />
                        <p>Câu hỏi thường gặp </p>
                    </a>
                </div>
                <div class="clear"></div>
            </div>
        </div>
	</div><!-- #primary -->
    
     <?php get_sidebar( 'content' ); ?>
     
    <div class="clear"></div>
</div><!-- #main-content -->

<?php
get_footer();
