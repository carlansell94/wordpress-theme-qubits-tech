<?php
/**
 * Template used for pages that have children. Displays both page content, and a
 * list of child pages.
 * 
 * If a page has no parent, the latest content from all bottom-level pages under
 * the parent's children will display.
 * 
 * If a page has a parent, only children from the current page will display.
 * 
 * @package QubitsTech
 */

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = get_option('posts_per_page');
$total_pages = ceil(count($args['qb_pages']) / $posts_per_page);
 
$offset = ($paged - 1) * $posts_per_page;
$qb_pages_paginated = array_slice($args['qb_pages'], $offset, $posts_per_page);
 
?>

<section>
    <h2 class="hidden-header">Content:</h2>
    <?= the_content(); ?>
</section>
<?php if (wp_get_post_parent_id()): ?>
    <section class="posts-container">
        <h2>Guides:</h2>
        <?php foreach ($args['qb_pages'] as $qb_page): ?>
            <article class="post-container">
                <a href="<?= get_page_link($qb_page) ?>">
                    <?= qb_page_thumbnail($qb_page) ?>
                    <div>
                        <h3><?= get_the_title($qb_page) ?></h3>
                        <?php if (wp_get_post_parent_id()): ?>
                            <p><?= get_the_excerpt($qb_page) ?></p>
                        <?php endif; ?>
                    </div>
                </a>
            </article>
        <?php endforeach; ?>
    </section>
<?php else: ?>
    <section class="posts-container children">
        <h2 class="hidden-header">Categories:</h2>
        <?php $parent_ids = array();
        foreach ($args['qb_pages'] as $qb_page): ?>
            <a href="<?= get_page_link($qb_page) ?>">
                <?= qb_related_thumbnail($qb_page) ?>
                <h3><?= get_the_title($qb_page) ?></h3>
            </a>
            <?php $parent_ids[] = $qb_page->ID; ?>
        <?php endforeach; ?>
    </section>
    <?php $qb_pages = qb_latest_pages($parent_ids); ?>
    <?php if ($qb_pages): ?>
    <section>
        <h2>Latest Guides:</h2>
        <div class="posts-container">
            <?php while ($qb_pages->have_posts()): ?>
                <?php $qb_pages->the_post(); ?>
                <article class="post-container">
                    <a href="<?= get_page_link() ?>">
                        <?= qb_page_thumbnail(get_the_ID()) ?>
                        <div>
                            <h3><?= the_title() ?></h3>
                            <p><?= the_excerpt() ?></p>
                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_query(); ?>
    </section>
    <?php endif; ?>
<?php endif; ?>
<section id="pagination">
    <nav class="pagination navigation">
    <?php
        if ($total_pages > 1) {
            echo paginate_links(array(
                'current' => max(1, $paged),
                'total' => $total_pages,
                'prev_text' => __( '&lt;', 'textdomain' ),
                'next_text' => __( '&gt;', 'textdomain' ),
            ));
        }
    ?>
    </nav>
</section>