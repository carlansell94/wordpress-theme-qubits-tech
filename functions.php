<?php
/**
 * @package QubitsTech
 */

require_once 'customizer.php';

/* 1. THEME WP SUPPORT */
function qb_theme_support() {
    if (is_user_logged_in()) {
        show_admin_bar(true);
    }

    add_theme_support( 'custom-logo' );
    add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
    add_theme_support( 'title-tag' );
    add_post_type_support( 'page', 'excerpt' );
}

function qb_register_image_sizes() {
    update_option( 'large_size_w', 1000 );
    update_option( 'large_size_h', 1000 );
    update_option( 'medium_large_size_w', 750 );
    update_option( 'medium_large_size_h', 750 );
    update_option( 'medium_size_w', 375 );
    update_option( 'medium_size_h', 375 );
    update_option( 'thumbnail_size_w', 75 );
    update_option( 'thumbnail_size_h', 75 );
    update_option( 'thumbnail_crop', 1 );
        
    remove_image_size('1536x1536');
    add_filter( 'big_image_size_threshold', '__return_false' );
}

function qb_custom_header_setup() {
    $args = array(
        'default-image'      => get_template_directory_uri() . '/assets/banner-default.webp',
        'default-text-color' => '000',
        'width'              => 1000,
        'height'             => 250,
        'flex-width'         => true,
        'flex-height'        => true
    );

    add_theme_support( 'custom-header', $args );
}

function qb_nav_setup() {
    register_nav_menus(array(
        'main' => esc_html__( 'Main Nav Menu' ),
        'sub-main' => esc_html__( 'Sub Nav Menu' ),
        'footer' => esc_html__( 'Footer Menu' )
    ));
}

function qb_widgets_setup() {
	register_sidebar(array(
        'name'          => esc_html__( 'Primary Sidebar', 'qb' ),
        'id'            => 'sidebar-main',
        'description'   => esc_html__( 'Main sidebar, designed to display on the right-hand side of the page.', 'qb' ),
        'before_widget' => '<div class="%2$s">',
        'after_widget'  => '</div>'
	));

	register_sidebar(array(
        'name'          => esc_html__( 'Footer Widgets', 'qb' ),
        'id'            => 'footer-main',
        'description'   => esc_html__( 'Widget area, designed for display in the footer.', 'qb' ),
        'before_widget' => '<div class="%2$s">',
        'after_widget'  => '</div>'
	));
}

function qb_deregister_styles()
{
    wp_deregister_style( 'wp-block-library' );
}

add_action( 'after_setup_theme', 'qb_theme_support' );
add_action( 'after_setup_theme', 'qb_register_image_sizes' );
add_action( 'after_setup_theme', 'qb_custom_header_setup' );
add_action( 'after_setup_theme', 'qb_nav_setup' );
add_action( 'after_setup_theme', 'qb_widgets_setup' );
add_action( 'wp_enqueue_scripts', 'qb_deregister_styles' );
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


/* 2. WP FUNCTION FILTERS */
function qb_category_count_filter($links) {
    return str_replace('</li>', '</a></li>', str_replace('</a>', '', $links));
}

function qb_remove_web_field_filter($fields) {
    unset($fields['url']);
    return $fields;
}

function qb_add_image_sizes_filter($wp_image, $context, $id) {
	wp_img_tag_add_width_and_height_attr($wp_image, $context, $id);
	return $wp_image;
}

function qb_add_image_links_filter($wp_image, $context, $id) {
    if (!$full_src = wp_get_attachment_image_src($id, 'full')) {
        return $wp_image;
    }

    $doc = new DOMDocument();
    $doc->loadHTML($wp_image);
    $image = $doc->getElementsByTagName('img')[0];
    $figure = $image->parentNode;

    $a = $doc->createElement('a');
    $a->setAttribute('href', $full_src[0]);

    $a->appendChild($image);
    $figure->appendChild($a);

    return $doc->saveHTML();
}

function qb_image_sizes_filter()
{
    return qb_get_srcset_sizes(vw: 40);
}

add_filter( 'wp_list_categories', 'qb_category_count_filter' );
add_filter( 'comment_form_default_fields', 'qb_remove_web_field_filter' );
add_filter( 'wp_content_img_tag', 'qb_add_image_links_filter', 10, 3 );
add_filter( 'wp_calculate_image_sizes', 'qb_image_sizes_filter' );


/* 3. THEME ADDITIONAL FUNCTIONS */
function qb_post_thumbnail(int|WP_Post $post_id): string
{
    if ($thumbs = qb_get_post_thumbnail($post_id)) {
        return qb_get_img_tag(
            thumbs: $thumbs,
            vw: 35,
            class: 'post-thumbnail',
            alt: get_the_title($post_id),
            height: 1,
            width: 2
        );
    }

    return qb_get_img_fallback_tag(
        class: 'post-thumbnail',
        height: 1,
        width: 2
    );
}

function qb_get_post_thumbnail(int|WP_Post $post_id): array|bool
{
    $img_id = get_post_thumbnail_id($post_id);
    $thumb = wp_get_attachment_image_src($img_id, 'medium');

    if (!$thumb || $thumb[0] == '') {
        $img_id = get_theme_mod('media_default_post_thumb');

        if (!$img_id) {
            return false;
        }
    }
    
    return array(
        'thumb' => wp_get_attachment_image_src($img_id, 'medium')[0],
        'thumb_med' => wp_get_attachment_image_src($img_id, 'medium_large')[0],
        'thumb_lrg' => wp_get_attachment_image_src($img_id, 'large')[0],
        'full' => wp_get_attachment_image_src($img_id, 'full')[0]
    );
}

function qb_page_thumbnail(int|WP_Post $post_id): string
{
    if (get_theme_mod('media_page_default_to_parent_thumb', true)) {
        $post_id = wp_get_post_parent_id($post_id);
    }

    return qb_post_thumbnail($post_id);
}

function qb_related_thumbnail(int|WP_Post $post_id): string
{
    if ($thumbs = qb_get_post_thumbnail($post_id)) {
        return qb_get_img_tag(
            thumbs: $thumbs,
            vw: 15,
            class: 'related-thumbnail',
            alt: get_the_title($post_id),
            height: 2,
            width: 3
        );
    }
    
    return qb_get_img_fallback_tag(
        class: 'related-thumbnail',
        height: 2,
        width: 3
    );
}

function qb_get_img_tag(array|string $thumbs, int $vw, ...$attrs): string
{
    if (is_array($thumbs)) {
        $attrs += qb_get_srcset(thumbs: $thumbs);
        $attrs['sizes'] = qb_get_srcset_sizes(vw: $vw);
    } else {
        $attrs['src'] = $thumbs;
    }

    $tag = '';

    foreach ($attrs as $attr => $value) {
        $tag .= " $attr=\"$value\"";
    }

    return '<img' . $tag . '>';
}

function qb_get_img_fallback_tag(...$attrs): string
{
    $tag = '';

    foreach ($attrs as $attr => $value) {
        $tag .= " $attr=\"$value\"";
    }

    return '<div' . $tag . '></div>';
}

function qb_get_srcset(array $thumbs): array
{
    return array(
        'src' => $thumbs['thumb'],
        'srcset' =>
            $thumbs['thumb_lrg'] . ' 1000w, '
          . $thumbs['thumb_med'] . ' 750w, '
          . $thumbs['thumb'] . ' 375w'
    );
}

function qb_get_srcset_sizes(int $vw): string
{
    if (get_theme_mod('media_ignore_pixel_density')) {
        return '
            (-webkit-min-device-pixel-ratio: 3) and (min-width: 993px) '
                . $vw / 3 . 'vw,
            (-webkit-min-device-pixel-ratio: 2) and (min-width: 993px) '
                . $vw / 2 . 'vw,
            (-webkit-max-device-pixel-ratio: 1) and (min-width: 993px) '
                . $vw . 'vw,
            (-webkit-min-device-pixel-ratio: 3) 33.3vw,
            (-webkit-min-device-pixel-ratio: 2) 50vw,
            100vw';
    }

    return '(min-width: 993px) ' . $vw . 'vw, 100vw';
}

function qb_related_posts(int $limit = -1)
{
    $args = array(
	    'post_type' => 'post',
	    'posts_per_page' => -1,
        'post_status' => 'publish',
	    'post__not_in' => array( get_the_ID() ),
	    'orderby' => 'rand',
	    'category__in' => wp_get_post_categories( get_the_ID() ),
	);
    
    return qb_get_related($args, $limit);
}

function qb_related_pages(int $limit = -1)
{
    $args = array(
        'post_type' => 'page',
        'post_parent' => wp_get_post_parent_id(),
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'rand'
    );
    
    return qb_get_related($args, $limit);
}

function qb_get_related(array $args, int $limit)
{
    $related = new WP_Query($args);
    
    if (!$related->have_posts()) {
        return false;
    }

    $qb_post_list = array();

    while ($related->have_posts() && ($limit !== 0)) { 
        $related->the_post();
        $qb_post_list[] = get_the_ID();
        $limit--;
    }

    wp_reset_query();

    return $qb_post_list;
}

function qb_latest_pages(array $parent_ids = null) {
    $args = array(
	    'post_type' => 'page',
        'post_status' => 'publish',
        'paged' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
        'post_parent__in' => $parent_ids
	);

    $child_pages = new WP_Query($args);
    
    if (!$child_pages->have_posts()) {
        return false;
    }
    
    return $child_pages;
}

function qb_list_child_pages() { 
    $id = ( is_page()) ? get_the_ID() : '';
    
    return get_pages( 'sort_column=menu_order&title_li=&parent=' . $id . '&echo=0' );
}


/* 4. THEME SHORTCODES */
function qb_get_archive() {
    $archive = array();
    $result = new WP_Query(array('posts_per_page' => -1));

    while ( $result->have_posts()): $result->the_post();
        $year = get_the_date('Y');
        $month = get_the_date('M');
        $url = get_permalink();
        $title = get_the_title(); 
            
        $archive[$year][$month][$url] = $title;
    endwhile;

    wp_reset_postdata();

    foreach ($archive as $year => $months): ?>
        <details class="qb-archive"><summary><?= $year ?></summary>

        <?php foreach ($months as $month => $posts): ?>
            <details><summary><?= $month ?> (<?= count($posts) ?>)</summary><ul>
            
            <?php foreach ($posts as $url => $title): ?>
                <li>
                    <a class="qb-archive-link" href="<?= $url ?>"><?= $title ?></a>
                </li>
            <?php endforeach; ?>

            </ul></details>
        <?php endforeach; ?>
        
        </details>
    <?php endforeach;
}

add_shortcode('qb_archive', 'qb_get_archive');
