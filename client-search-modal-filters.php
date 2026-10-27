<?php
/**
 * Plugin Name: Client Search Modal Filters
 * Description: Adds a per-element More Filters control to Directorist Search Modal in Bricks, including site-wide headers.
 * Version: 1.1.0
 * Author: Sovware Support
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * License: GPL-2.0-or-later
 */

namespace Sovware\ClientSearchModalFilters;

defined( 'ABSPATH' ) || exit;

add_filter( 'bricks/elements/directorist-search-modal/controls', function ( $controls ) {
    $controls['client_more_filters'] = array(
        'tab'         => 'content',
        'group'       => 'button',
        'label'       => __( 'Show More Filters', 'client-search-modal-filters' ),
        'type'        => 'select',
        'options'     => array(
            'yes' => __( 'Show', 'client-search-modal-filters' ),
            'no'  => __( 'Hide', 'client-search-modal-filters' ),
        ),
        'default'     => 'yes',
        'placeholder' => __( 'Show (default)', 'client-search-modal-filters' ),
        'description' => __( 'Applies wherever this element appears, including headers. Requires advanced search fields in Directory Builder.', 'client-search-modal-filters' ),
    );
    return $controls;
} );

add_filter( 'bricks/element/render', __NAMESPACE__ . '\\prepare_modal', 20, 2 );

function prepare_modal( $render, $element ) {
    // Never let a previous element's pending interception affect the next element.
    remove_filter( 'pre_do_shortcode_tag', __NAMESPACE__ . '\\render_search', 20 );
    if ( ! $render || 'directorist-search-modal' !== $element->name ) {
        return $render;
    }
    // Default to Show for existing elements when upgrading from the page-scoped version.
    if ( 'no' === ( $element->settings['client_more_filters'] ?? 'yes' ) ) {
        return $render;
    }

    // Bricks renders this element immediately after this hook. Intercept only its search shortcode.
    add_filter( 'pre_do_shortcode_tag', __NAMESPACE__ . '\\render_search', 20, 4 );
    return $render;
}

function render_search( $output, $tag, $attributes, $match ) {
    if ( 'directorist_search_listing' !== $tag ) {
        return $output;
    }

    remove_filter( 'pre_do_shortcode_tag', __NAMESPACE__ . '\\render_search', 20 );
    if ( false !== $output ) {
        return $output;
    }

    global $shortcode_tags;
    if ( ! isset( $shortcode_tags[ $tag ] ) || ! is_callable( $shortcode_tags[ $tag ] ) ) {
        return $output;
    }

    $attributes = is_array( $attributes ) ? $attributes : array();
    $attributes['more_filters_button'] = 'yes';
    $attributes['more_filters_text'] = 'More Filters';
    $attributes['apply_filters_button'] = 'yes';
    $attributes['reset_filters_button'] = 'yes';
    $html = call_user_func( $shortcode_tags[ $tag ], $attributes, $match[5] ?? null, $tag );
    return '<div class="client-modal-filters">' . $html . '</div>';
}

add_action( 'wp_enqueue_scripts', function () {
    // Template placement, not the current queried page, determines whether an element renders.
    if ( ! class_exists( '\\WpWax\\AKFB\\Elements\\TopSearch' ) ) {
        return;
    }
    wp_enqueue_style( 'client-modal-filters', plugins_url( 'assets/filters.css', __FILE__ ), array(), filemtime( __DIR__ . '/assets/filters.css' ) );
    wp_enqueue_script( 'client-modal-filters', plugins_url( 'assets/filters.js', __FILE__ ), array(), filemtime( __DIR__ . '/assets/filters.js' ), true );
}, 30 );
