<?php
/**
 * The Content Sidebar
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<div id="content-sidebar" class="content-sidebar widget-area" role="complementary">
    <div>
        <img src="<?php echo get_template_directory_uri()?>/images/pic1.png" />
    </div>
    <div class="clear"></div>
    
    <div class="widget divbar">
        <div>
            <h1 class="widget-title">SẢN PHẨM NỔI BẬT</h1>
            <script type="text/javascript">
            (function($) {
            	$(function() {
            		$("#scroller").simplyScroll({orientation:'vertical',customClass:'vert',pauseOnHover : true});
            	});
            })(jQuery);
            </script>
            <div>
                <ul id="scroller">
                    <?php 
                    query_posts('posts_per_page=10&post_type=product');
                    while ( have_posts() ) : the_post();
                    ?>
                        <li><a href="<?php the_permalink()?>" title="<?php the_title()?>"><?php the_title()?></a></li>
                    <?php
    				endwhile;
                    wp_reset_query();
                    ?>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="widget widget2 divbar">
        <div>
            <h1 class="widget-title">Tin tức mới nhất</h1>
            <script type="text/javascript">
            (function($) {
            	$(function() {
            		$("#scroller2").simplyScroll({orientation:'vertical',customClass:'vert',pauseOnHover : true});
            	});
            })(jQuery);
            </script>
            <div>
                <ul id="scroller2">
                    <?php 
                    query_posts('posts_per_page=10&post_type=post&cat=5');
                    while ( have_posts() ) : the_post();
                    ?>
                        <li><a href="<?php the_permalink()?>" title="<?php the_title()?>"><?php the_title()?></a></li>
                    <?php
    				endwhile;
                    wp_reset_query();
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</div><!-- #content-sidebar -->
