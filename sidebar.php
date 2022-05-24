<?php 
/**
 * @package QubitsTech
 */

if (!is_active_sidebar( 'sidebar-main' )) {
	return;
}
?>

<aside id="sidebar">
    <h2 class="hidden-header">Sidebar:</h2>
	<?php dynamic_sidebar( 'sidebar-main' ); ?>
</aside>
