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
			    
<?php if (wp_get_post_parent_id()): ?>
    <?php if ($related_pages = qb_related_pages(3)): ?>
        <aside>
            <h2>Related Tutorials:</h2>
            <section class="posts-container" id="related">
                <?php foreach ($related_pages as $qb_pages): ?>
                    <a href="<?= $qb_pages['slug'] ?>">
                        <img src="<?= $qb_pages['thumb'] ?>" alt="<?= $qb_pages['title'] ?>" />
                        <h3><?= $qb_pages['title'] ?></h3>
                    </a>
                <?php endforeach; ?>
            </section>
        </aside>
    <?php endif; ?>
    <?= comments_template(); ?>
<?php endif; ?>
