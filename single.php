<?php
/**
 * @package QubitsTech
 */

get_header(); ?>

<div id="page-container">
    <main>
	    <header>
	        <h1><?= the_title(); ?></h1>
	    </header>
	    <div id="meta">
            <div>
	            <img class="meta-icon" src="<?= get_bloginfo('template_url') ?>/assets/calendar-blk.svg" height="1" width="1" alt="calendar" />
	            <p><?= get_the_date() ?></p>
            </div>	    
		    <?php if ($cats = get_the_category()) : ?>
                <div>
                    <img class="meta-icon" src="<?= get_bloginfo('template_url') ?>/assets/categories.svg" height="1" width="1" alt="categories" />
                    <div>
                        <?php foreach ($cats as $cat) : ?>
                            <a class='category' href='<?= get_category_link($cat) ?>'><?= $cat->name ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($tags = get_the_tags()) : ?>
                <div>
                    <img class="meta-icon" src="<?= get_bloginfo('template_url') ?>/assets/tags.svg" height="1" width="1" alt="tags" />
                    <div>
                        <?php foreach ($tags as $tag) : ?>
                            <a class='tag' href='<?= get_tag_link($tag) ?>'><?= $tag->name ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (get_comments_number() != 0) : ?>
                <div>
                    <img class="meta-icon" src="<?= get_bloginfo('template_url') ?>/assets/comments.svg" height="1" width="1" alt="comments" />
                    <p><?= comments_number() ?>
                </div>
            <?php endif; ?>
        </div>
        <article id="post-content">
            <h2 class="hidden-header">Content:</h2>
		    <?php the_content(); ?>
		</article>
	    <nav><?= wp_link_pages(); ?></nav>
	    <?php if ($qb_related_posts = qb_related_posts(3)): ?>
	        <aside>
	            <h2>Related Posts:</h2>
	            <div class="posts-container" id="related">
	                <?php foreach ($qb_related_posts as $qb_post): ?>
	                    <a href="<?= $qb_post['slug'] ?>">
                            <img src="<?= $qb_post['thumb'] ?>" alt="<?= $qb_post['title'] ?>" />
	                        <h3><?= $qb_post['title'] ?></h3>
	                    </a>
	                <?php endforeach; ?>
	            </div>
	        </aside>
	    <?php endif; ?>
        <?php comments_template(); ?>
    </main>
    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
