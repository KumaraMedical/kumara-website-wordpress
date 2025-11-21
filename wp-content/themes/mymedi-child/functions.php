<?php 
function mymedi_child_register_scripts(){
    $parent_style = 'mymedi-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', array('font-awesome-5', 'mymedi-reset'), mymedi_get_theme_version() );
    wp_enqueue_style( 'mymedi-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'mymedi_child_register_scripts' );

add_filter( 'mymedi_get_theme_options', function( $options ) {
    $options['ts_ajax_search_number_result'] = 10; // show 10 instead of 4
    return $options;
});

add_filter('woocommerce_show_page_title', '__return_false'); // hide default H1

add_action('woocommerce_before_main_content', function() {
    if ( is_tax('product_brand') ) { // your brand taxonomy
        $term = get_queried_object(); 

        // Get brand image (Featured Image of the brand, if you set one)
        $image_id = get_term_meta($term->term_id, 'thumbnail_id', true);
        $image_url = wp_get_attachment_url($image_id);

        if ($image_url) {
            echo '<div class="brand-logo-heading" style="display:flex;align-items:center;min-height:120px;">
                    <img src="' . esc_url($image_url) . '" alt="' . esc_attr($term->name) . '" style="height:120px;width:auto;">
                  </div>';
        } else {
            // fallback: show text if no logo
            echo '<h1 class="brand-title">' . esc_html($term->name) . '</h1>';
        }
    }
});

