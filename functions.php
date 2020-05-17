<?php
/**
 * PipTheme functions and definitions
 *
 * @package PipTheme
 */

/**
 * For child theme authors: To disable the styles and layouts from PipTheme properly,
 * add the following code to your child theme functions.php file:
 *
 * <?php
 * add_action( 'wp_enqueue_scripts', 'dequeue_parent_theme_styles', 11 );
 * function dequeue_parent_theme_styles() {
 *     wp_dequeue_style( 'piptheme-parent-style' );
 *     wp_dequeue_style( 'piptheme-layout' );
 * }
 *
 */

if ( ! function_exists( 'piptheme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function piptheme_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on piptheme, use a find and replace
	 * to change 'piptheme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'piptheme', get_template_directory() . '/languages' );

        /**
        * Set the content width based on the theme's design and stylesheet.
        */
        if ( ! isset( $content_width ) ) {
               $content_width = 700; /* pixels */
        }

        // This theme styles the visual editor to resemble the theme style.
        add_editor_style( array( 'inc/editor-style-devel.css', 'fonts/Lato/css/Lato.css', 'fonts/ClearSans/css/ClearSans.css' ) );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
        // Featured image sizes for single posts and pages
        set_post_thumbnail_size(1060, 650, true);
        // Featured image size for small image in archives
        add_image_size('index-thumb', 780, 250, true);

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'piptheme' ),
        'social' => __( 'Social Menu', 'piptheme'),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'piptheme_custom_background_args', array(
		'default-color' => 'b2b2b2',
		'default-image' => get_template_directory_uri() . '/images/pattern.svg',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
        'caption',
	) );
}
endif; // piptheme_setup
add_action( 'after_setup_theme', 'piptheme_setup' );

add_filter('stylesheet_uri', 'piptheme_versioned_style');
function piptheme_versioned_style() {
  /* when updating also change reference in piptheme_get_parent_stylesheet_uri() */
  return trailingslashit( get_template_directory_uri() ) . 'style-devel.css';
}

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function piptheme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'piptheme' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

        register_sidebar( array(
		'name'          => __( 'Footer Widget', 'piptheme' ),
        'description'   => __( 'Footer widget area appears, not surprisingly, in the footer of the site.', 'piptheme' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'piptheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */

function update_core_jquery() {
  wp_deregister_script( 'jquery-core' );
  wp_register_script( 'jquery-core', get_template_directory_uri() . '/js/jquery-3.5.1.min-20200516.js', array(), null );
  wp_deregister_script( 'jquery-migrate' );
  wp_register_script( 'jquery-migrate', get_template_directory_uri() . '/js/jquery-migrate-3.3.0.min-20200516.js', array(), null );
}
add_action( 'wp_enqueue_scripts', 'update_core_jquery' );

function piptheme_scripts() {

        // Get the current layout setting (sidebar left or right)
        $piptheme_layout = get_option( 'layout_setting' );
        if ( is_page_template( 'page-templates/page-nosidebar.php' ) || ! is_active_sidebar( 'sidebar-1' ) ) {
            $layout_stylesheet = '/layouts/no-sidebar-20200516.css';
        } elseif ( 'left-sidebar' == $piptheme_layout ) {
            $layout_stylesheet =  '/layouts/sidebar-content-20200516.css';
        } else {
            $layout_stylesheet = '/layouts/content-sidebar-20200516.css';
        }

        // Load parent theme stylesheet even when child theme is active
        wp_enqueue_style( 'piptheme-style', piptheme_get_parent_stylesheet_uri(), array(), null );

        // Load layout stylesheet
        wp_enqueue_style( 'piptheme-layout' , get_template_directory_uri() . $layout_stylesheet, array(), null);

        // Load child theme stylesheet
        if ( is_child_theme() ) {
            wp_enqueue_style( 'piptheme-child-style', get_stylesheet_uri() );
        }

        // WebFonts
        wp_enqueue_style('piptheme_webfonts', get_template_directory_uri() . '/fonts/webfonts.min-20200513.css', array(), null);

        // Lato
        //wp_enqueue_style('piptheme_lato', get_template_directory_uri() . '/fonts/Lato/css/Lato.css');
        
        // Clear Sans
        //wp_enqueue_style('piptheme_clearsans', get_template_directory_uri() . '/fonts/ClearSans/css/ClearSans.css');
        
        // FontAwesome
        //wp_enqueue_style('piptheme_fontawesome', get_template_directory_uri() . '/fonts/font-awesome/css/font-awesome.css');

		wp_enqueue_script( 'piptheme-navigation', get_template_directory_uri() . '/js/navigation-20120206.js', array(), null, true );

        wp_enqueue_script( 'piptheme-search', get_template_directory_uri() . '/js/hide-search.js-20120206', array(), null, true );

        wp_enqueue_script( 'piptheme-superfish', get_template_directory_uri() . '/js/superfish-20180226.js', array('jquery-core'), null, true );

        wp_enqueue_script( 'piptheme-superfish-settings', get_template_directory_uri() . '/js/superfish-settings-20140328.js', array('jquery-core'), null, true );

        wp_enqueue_script( 'piptheme-masonry', get_template_directory_uri() . '/js/masonry-settings-20140401.js', array('masonry'), null, true );

        wp_enqueue_script( 'piptheme-enquire', get_template_directory_uri() . '/js/enquire-20170304.js', false, null, true );


        if (is_single() || is_author() ) {
        	wp_enqueue_script( 'piptheme-hide', get_template_directory_uri() . '/js/hide-20140310.js', array('jquery-core'), null, true );
        }

	wp_enqueue_script( 'piptheme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix-20130115.js', array(), null, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'piptheme_scripts' );

/**
 * Return parent stylesheet URI
 */
function piptheme_get_parent_stylesheet_uri() {
	if ( is_child_theme() ) {
		return trailingslashit( get_template_directory_uri() ) . 'style-devel.css';
	} else {
		return get_stylesheet_uri();
	}
}

/* from https://kinsta.com/knowledgebase/disable-emojis-wordpress/#disable-emojis-code */
/**
 * Disable the emoji's
 */
function disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );
/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}
/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
  if ( 'dns-prefetch' == $relation_type ) {
    /** This filter is documented in wp-includes/formatting.php */
    $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
    $urls = array_diff( $urls, array( $emoji_svg_url ) );
  }
return $urls;
}

/* from https://wordpress.org/support/topic/what-is-wp-json-and-api-w-org-seems-like-theyre-slowing-my-site-load/ */
// Disable REST API link tag
remove_action('wp_head', 'rest_output_link_wp_head', 10);
// Disable oEmbed Discovery Links
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
// Disable REST API link in HTTP headers
remove_action('template_redirect', 'rest_output_link_header', 11, 0);

/* don't add resource hints */
remove_action('wp_head', 'wp_resource_hints', 2);

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
