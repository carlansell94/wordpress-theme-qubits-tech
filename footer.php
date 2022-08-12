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
        <p id="site-info">
            <span id="copyright-text">
                <?= get_theme_mod( 'site_copyright', 'Copyright &copy;' ) ?>
            </span>
            <span id="copyright-year">
                <?php if (get_theme_mod( 'show_copyright_dates', 1 )): ?>
                    <?php
                        $year = get_theme_mod( 'site_start_year', date('Y') );
                        $year >= date('Y') ? $year = date('Y') : $year .= ' - ' . date('Y');
                        echo $year;
                    ?>
                <?php endif; ?>
            </span>
            - 
            <a href="https://github.com/carlansell94/wordpress-theme-qubits-tech">
                Using the Qubits Tech Theme
            </a>
        </p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
