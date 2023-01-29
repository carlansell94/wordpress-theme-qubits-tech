<?php
/**
 * Inlcuded on every page, contains both the HTML head element, plus the
 * header bar, top navigation/search areas and site banner.
 *
 * @package QubitsTech
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="site_name" property="og:site_name" content="<?= get_bloginfo('name') ?>">
        <?php if (is_home()): ?>
            <meta name="title" property="og:title" content="<?= get_bloginfo('name') ?>">
            <meta name="description" property="og:description" content="<?= get_bloginfo('description') ?>">
        <?php else: ?>
            <meta name="url" property="og:url" content="<?=get_permalink() ?>">
            <meta name="title" property="og:title" content="<?= the_title() ?>">
            <?php if (has_excerpt()): ?>
                <meta name="description" property="og:description" content="<?= str_replace("\n", " ", get_the_excerpt()) ?>">
            <?php endif; ?>
            <meta name="image" property="og:image" content="<?= wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ) ?>">
            <meta name="type" property="og:type" content="article">
            <meta property="article:published_time" content="<?= get_post_time("Y-m-d") ?>">
            <?php if (has_tag()):
                $keywords = array();
                foreach (get_the_tags() as $tag):
                    $keywords[] = $tag->name; ?>
                    <meta property="article:tag" content="<?= $tag->name ?>">
                <?php endforeach; ?>
                <meta name="keywords" content="<?= implode(',', $keywords) ?>">
            <?php endif; ?>
            <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "<?php if (get_post_type() == 'page') {echo "Article";} else {echo "BlogPosting";} ?>",
                "headline": "<?= the_title() ?>",
                "image": [
                    "<?= wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ) ?>"
                ],
                "datePublished": "<?= get_post_time("Y-m-d\TH:i:s+00:00") ?>",
                "dateModified": "<?= get_the_modified_date("Y-m-d\TH:i:s+00:00") ?>",
                "author": [{
                    "@type": "Organization",
                    "name": "<?= get_bloginfo('name') ?>",
                    "url": "<?= get_site_url() ?>"
                }],
                "commentCount": <?= get_comments_number() ?>,
                "keywords": "<?php if (isset($keywords)) {echo implode(',', $keywords);} ?>"
            }
            </script>
        <?php endif; ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
        <?php if (get_theme_mod('colour_browser_theme_preference', true)): ?>
            <meta name="color-scheme" content="light dark">
            <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() . '/style-dark.css'; ?>">
        <?php endif; ?>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <script>
            window.addEventListener('load', () => {
                const mainHeader = document.querySelector('#main-header');
                const navMenu = mainHeader.querySelector('nav');
                const button = mainHeader.querySelector('button');
                const dropdowns = document.querySelectorAll('.sub-menu');

                dropdowns.forEach((dropdown) => {
                    const a = dropdown.parentNode.querySelector('a');
                    const div = document.createElement('div');

                    dropdown.parentNode.removeChild(a);
                    a.classList.add('menu-item');
                    div.appendChild(a);

                    const navLinkIconContainer = document.createElement('div');
                    const navLinkIcon = document.createElement('p');

                    navLinkIconContainer.classList.add('menu-item-icon-container');
                    navLinkIcon.innerHTML = '&#9660;';
                    navLinkIcon.classList.add('menu-item-icon');

                    navLinkIconContainer.appendChild(navLinkIcon);
                    div.appendChild(navLinkIconContainer);
                    dropdown.parentNode.prepend(div);

                    navLinkIcon.parentNode.addEventListener('click', () => {
                        if (dropdown.style.display == 'block') {
                            hideDropDown(dropdown);
                            navLinkIcon.style.removeProperty('transform');
                        } else {
                            showDropDown(dropdown);
                            navLinkIcon.style.transform = "rotate(180deg)";
                        }
                    });

                    dropdown.parentNode.addEventListener('mouseover', () => {
                        if (window.innerWidth > 992) {
                            showDropDown(dropdown);
                        }
                    });

                    dropdown.parentNode.addEventListener('mouseout', () => {
                        if (window.innerWidth > 992) {
                            hideDropDown(dropdown);
                        }
                    });
                });

                button.addEventListener('click', () => {
                    navMenu.style.display == 'flex' ? navMenu.style.display = 'none' : navMenu.style.display = 'flex';
                });

                window.addEventListener('resize', () => {
                    if (navMenu.style.display == 'none' && window.innerWidth > 992) {
                        navMenu.style.display = 'flex';
                    } else if (navMenu.style.display == 'flex' && window.innerWidth <= 992) {
                        navMenu.style.display = 'none';
                    }
                });
            });
            
            function showDropDown(dropdown) {
                dropdown.parentNode.classList.add('active-menu');
                dropdown.style.display = 'block';
            }

            function hideDropDown(dropdown) {
                dropdown.parentNode.classList.remove('active-menu');
                dropdown.style.display = 'none';
            }
        </script>
        <?php wp_head(); ?>
    </head>
<body>
<header id="main-header">
    <a id="logo" href="<?= get_option( 'siteurl' ) ?>">
        <?php if( has_custom_logo() ):
            $custom_logo_data = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' );
			list($logo_url, $logo_width, $logo_height) = $custom_logo_data; ?>
            <img src="<?= $logo_url ?>" height="<?= $logo_height ?>" width="<?= $logo_width ?>" alt="<?= get_bloginfo('name')?> logo">
        <?php endif; ?>
        <div id="logo-text" <?php if (!display_header_text()) {echo "style='display:none'";} ?>>
            <p id="logo-site-name"><?= get_bloginfo('name') ?></p>
            <p id="logo-site-tagline"><?= get_bloginfo('description') ?></p>
        </div>
    </a>
    <button type="button" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <img src="<?php bloginfo('template_url'); ?>/assets/menu.svg" height="1" width="1" alt="Menu" />
    </button>
    <nav id="main-header-nav">
        <?php if (has_nav_menu('main')) {
			wp_nav_menu( array(
				'theme_location' => 'main',
				'menu_id'        => 'primary-menu',
				'container'      => false,
				'depth'          => 2,
			));
	    } ?>
        <form class="search" method="get" action="<?= get_site_url() ?>">
            <input type="text" placeholder="Search" aria-label="Search" name="s" value="<?= get_search_query() ?>">
            <button type="submit">
                <img src="<?php bloginfo('template_url'); ?>/assets/search.svg" height="1" width="1" alt="Search" />
            </button>
        </form>
    </nav>
</header>
<?php if (get_header_image()): ?>
    <?php 
        if (!get_theme_mod('media_ignore_pixel_density')) {
            $sizes = '100vw';
        } else {
            $sizes = '
                (min-resolution: 288dpi) 33vw,
                (min-resolution: 192dpi) 50vw,
                (min-resolution: 96dpi) 100vw';
        }
    
        echo get_header_image_tag(array(
            'alt' => 'Site banner',
            'id' => 'banner',
            'sizes' => $sizes
        )); 
    ?>
<?php endif; ?>
