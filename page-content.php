<?php
/**
 * Template file used for bottom-level pages. If the page has a parent, it shows
 * other pages under the same parent.
 * 
 * @package QubitsTech
 */
?>
<article id="post-content">
    <h2 class="hidden-header">Content:</h2>
    <?php the_content(); ?>
</article>
<nav><?= wp_link_pages(); ?></nav>
<div id="content-end">
	<?php dynamic_sidebar( 'content-end' ); ?>
</div>    
<?php if (wp_get_post_parent_id()): ?>
    <?php if ($related_pages = qb_related_pages(3)): ?>
        <aside>
            <h2>Related Tutorials:</h2>
            <section class="posts-container" id="related">
                <?php foreach ($related_pages as $qb_page_id): ?>
                    <a href="<?= get_page_link($qb_page_id) ?>">
                        <?= qb_page_thumbnail($qb_page_id); ?>
                        <h3><?= get_the_title($qb_page_id) ?></h3>
                    </a>
                <?php endforeach; ?>
            </section>
        </aside>
    <?php endif; ?>
    <?= comments_template(); ?>
<?php endif; ?>
