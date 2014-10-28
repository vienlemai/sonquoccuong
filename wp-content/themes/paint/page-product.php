<?php
/**
 * Template Name: Products Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
            <h1 class="entry-title"><?php the_title()?></h1>
			<?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				query_posts('posts_per_page=18&post_type=product&paged='.$paged);
				while ( have_posts() ) : the_post();
					?>
                    <div class="productbox">
                        <div>
                            <a title="<?php the_title()?>" href="<?php the_permalink()?>"><?php the_post_thumbnail('medium')?></a>
                            <h2><a title="<?php the_title()?>" href="<?php the_permalink()?>"><?php the_title()?></a></h2>
                        </div>
                    </div>
                    <?php
				endwhile;
                echo '<div class="clear"></div>';
                twentyfourteen_paging_nav();
			?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
    <div class="clear"></div>
</div><!-- #main-content -->

<?php
get_footer();
