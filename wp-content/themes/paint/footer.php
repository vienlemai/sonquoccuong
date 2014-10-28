<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

		</div><!-- #main -->

		<footer id="colophon" class="site-footer" role="contentinfo">
            <div>
                <div>
                    <div class="info">
	                   <?php dynamic_sidebar('sidebar-3')?>
                    </div>
                    
                    <div class="menuft">
                        <h3>CHĂM SÓC KHÁCH HÀNG</h3>
                        <?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_class' => 'nav-menu' ) ); ?>
                    </div>
                    <div class="socialicons">
                       <?php dynamic_sidebar('sidebar-4')?> 
                    </div>
                    <div class="copyright"><img src="<?php echo get_template_directory_uri()?>/images/tuananh.png" /></div>
               </div>
            </div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>