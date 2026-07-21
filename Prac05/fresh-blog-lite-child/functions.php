<?php
/**
 * Child Theme Functions
 */

function book_store_child_enqueue_styles() {
    // Enqueue parent theme
    wp_enqueue_style( 
        'fresh-blog-parent-style', 
        get_parent_theme_file_uri( 'style.css' ) 
    );

    // Enqueue child theme
    wp_enqueue_style( 
        'book-store-child-style',
        get_stylesheet_uri(),
        array( 'fresh-blog-parent-style' ),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'book_store_child_enqueue_styles' );