<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header(); ?>

<div id="page-container">
    <main>
        <header>
            <?php if (!is_archive()): ?>
                <h1>Blog Posts:</h1>
            <?php elseif (is_category()): ?>
                <h1>Posts in the <?= get_the_archive_title(); ?></h1>
            <?php else: ?>
                <h1>Posts with the <?= get_the_archive_title(); ?></h1>
            <?php endif; ?>
        </header>
        <section class="posts-container">
            <h2 class="hidden-header">Post List:</h2>
            <?php while (have_posts()) : the_post(); ?>
                <article class="post-container">
                    <div class="post-date">
                        <img src="<?= bloginfo('template_url') ?>/assets/calendar.svg" alt="calendar-icon" />
                        <?= get_the_date(); ?>
                    </div>
                    <a href=<?= the_permalink() ?>>
                        <?= qb_post_thumbnail(get_the_ID()); ?>
                        <div>
                            <h3 class="post-title"><?= the_title(); ?></h3>
                            <p class="excerpt"><?= get_the_excerpt(); ?></p>
                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        </section>
        <nav id="pagination">
            <?php the_posts_pagination( array(
                'prev_text' => __( '&lt;', 'textdomain' ),
                'next_text' => __( '&gt;', 'textdomain' ),
            ) ); ?>
        </nav>
    </main>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>

