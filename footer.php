<?php
/**
 * The template for displaying the footer. Contains a widget area, a navigation area,
 * and displays the site copyright info.
 *
 * @package QubitsTech
 */
?>
<footer>
    <div id="footer-widgets">
	    <?php dynamic_sidebar( 'footer-main' ); ?>
    </div>
	    <?php if ( has_nav_menu( 'footer' ) ) : ?>
		    <nav id="footer-navigation" role="navigation">
			    <?php wp_nav_menu( array(
				    'theme_location' => 'footer',
					'menu_id'        => 'footer',
					'container'      => false,
					'depth'          => 1,
				) ); ?>
			</nav>
		<?php endif; ?>
	<p id="site-info">Design © qubitsandbytes.co.uk 2016 - <?= date( 'Y' ); ?></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
