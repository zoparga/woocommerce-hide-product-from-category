<?php
/*
Plugin Name: Hide Products From Specific Category
Description: Exclude products from a particular category on the shop page.
Version: 1.0
Author: Papp Zoltán
 */
function custom_pre_get_posts_query( $q ) {

    $tax_query = (array) $q->get( 'tax_query' );

    $tax_query[] = array(
           'taxonomy' => 'product_cat',
           'field' => 'slug',
           'terms' => array( 'CATEGORY-SLUG-HERE' ), // Don't display products in the clothing category on the shop page.
           'operator' => 'NOT IN'
    );


    $q->set( 'tax_query', $tax_query );

}
add_action( 'woocommerce_product_query', 'custom_pre_get_posts_query' ); 

add_filter( 'get_terms', 'exclude_category', 10, 3 );
function exclude_category( $terms, $taxonomies, $args ) {
    $new_terms = array();
    if ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() || is_page() ){

		foreach ( $terms as $key => $term ) {
            if( is_object ( $term ) ) {
                if ( 'CATEGORY-SLUG-HERE' == $term->slug && $term->taxonomy = 'product_cat' ) {
                    unset($terms[$key]);
                }
            }
        }
    }
    return $terms;
}