<?php
/**
 * Template used for pages. If the page has children, page-parent.php is displayed.
 * Otherwise, page-content.php is used.
 * 
 * @package QubitsTech
 */

get_header(); 
$qb_pages = qb_list_child_pages();
?>
<div id="page-container">
    <main>
	    <header>
	        <h1><?= the_title(); ?></h1>
	    </header>
	    <?php if ($qb_pages):
	        get_template_part( 'page', 'parent', array( 'qb_pages' => $qb_pages ) );
	    else:
	        get_template_part( 'page', 'content' );
	    endif; ?>
	    <nav><?= wp_link_pages(); ?></nav>
    </main>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
