<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );


require_once('theme-init/plugin-update-checker.php');
$themeInit = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/mostak-shahid/update/master/mosfeesiko-child.json',
	__FILE__,
	'mosfeesiko-child'
);
/**
 * Enqueue styles
 */
function child_enqueue_styles() {
    wp_enqueue_script('jquery');
    wp_enqueue_style( 'fancybox', get_stylesheet_directory_uri() . '/plugins/fancybox/jquery.fancybox.min.css' );
    wp_enqueue_script('fancybox', get_stylesheet_directory_uri() . '/plugins/fancybox/jquery.fancybox.min.js', 'jquery');    
    
    wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/plugins/slick/slick.css' );
    wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri() . '/plugins/slick/slick-theme.css' );
    wp_enqueue_script('slick', get_stylesheet_directory_uri() . '/plugins/slick/slick.js', 'jquery');
    
    wp_enqueue_style( 'BeerSlider', get_stylesheet_directory_uri() . '/plugins/BeerSlider/BeerSlider.css' );
    wp_enqueue_script('BeerSlider', get_stylesheet_directory_uri() . '/plugins/BeerSlider/BeerSlider.js', 'jquery');
    
    wp_enqueue_script('jquery.waypoints.min', get_stylesheet_directory_uri() . '/plugins/jquery.counterup/jquery.waypoints.min.js', 'jquery');
    wp_enqueue_script('jquery.counterup', get_stylesheet_directory_uri() . '/plugins/jquery.counterup/jquery.counterup.js', 'jquery');
    
    wp_enqueue_style( 'font-awesome.min', get_stylesheet_directory_uri() . '/fonts/font-awesome-4.7.0/css/font-awesome.min.css' );
    
	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/script.js', 'jquery');

}
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );
function mos_get_posts($post_type = 'post', $post_status = 'publish'){
    global $wpdb;
    $output = array();
    $all_posts = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}posts WHERE post_status = '{$post_status}' AND post_type = '{$post_type}'" );          
    foreach ($all_posts as $key => $value) {
        $output[$value->ID] = $value->post_title;
    }
    return $output;
}
//var_dump(mos_get_posts ('case-study'));

function mos_get_terms ($taxonomy = 'category', $return='all') {
    global $wpdb;
    $output = array();
    $all_taxonomies = $wpdb->get_results( "SELECT {$wpdb->prefix}term_taxonomy.term_id, {$wpdb->prefix}term_taxonomy.taxonomy, {$wpdb->prefix}terms.name, {$wpdb->prefix}terms.slug, {$wpdb->prefix}term_taxonomy.description, {$wpdb->prefix}term_taxonomy.parent, {$wpdb->prefix}term_taxonomy.count, {$wpdb->prefix}terms.term_group FROM {$wpdb->prefix}term_taxonomy INNER JOIN {$wpdb->prefix}terms ON {$wpdb->prefix}term_taxonomy.term_id={$wpdb->prefix}terms.term_id", ARRAY_A);
    if ($return=='all'){
        foreach ($all_taxonomies as $key => $value) {
            if ($value["taxonomy"] == $taxonomy) {
                $output[] = $value;
            }
        }
    } else {        
        foreach ($all_taxonomies as $key => $value) {
            if ($value["taxonomy"] == $taxonomy) {
                $output[$value['term_id']] = $value['name'];
            }
        }
    }
    return $output;
}
//var_dump(mos_get_terms ('case_study_category', 'small'));
function mos_calculate_reading_time( $post_id ) {

    $post_content       = get_post_field( 'post_content', $post_id );
    $stripped_content   = strip_shortcodes( $post_content );
    $strip_tags_content = wp_strip_all_tags( $stripped_content );
    $word_count         = count( preg_split( '/\s+/', $strip_tags_content ) );
    $reading_time       = ceil( $word_count / 220 );

    return $reading_time .' minutes of reading';
}
require_once 'aq_resizer.php';
//require_once 'astra-custom.php';
//require_once 'hooks.php';
require_once 'shortcodes.php';
//require_once 'carbon-fields.php';
//require_once 'woo-functions.php';