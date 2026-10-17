<?php
/**
 * Plugin Name: Client Search Modal Filters
 * Description: Adds More Filters to the client's selected Directorist Search Modal in Bricks.
 * Version: 1.0.0
 * Author: Sovware Support
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * License: GPL-2.0-or-later
 */

namespace Sovware\ClientSearchModalFilters;

defined( 'ABSPATH' ) || exit;

// Client scope: change these only when moving this customization to another page/element.
const PAGE_SLUG = 'aaa-brick-test';
const ELEMENT_ID = 'jlwxvn';

add_filter( 'bricks/element/render', __NAMESPACE__ . '\\prepare_modal', 20, 2 );

function prepare_modal( $render, $element ) {
    if ( ! $render || ! is_page( PAGE_SLUG ) ||
        'directorist-search-modal' !== $element->name || ELEMENT_ID !== $element->id ) {
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
    if ( ! is_page( PAGE_SLUG ) ) {
        return;
    }
    wp_enqueue_style( 'client-modal-filters', plugins_url( 'assets/filters.css', __FILE__ ), array(), filemtime( __DIR__ . '/assets/filters.css' ) );
    wp_enqueue_script( 'client-modal-filters', plugins_url( 'assets/filters.js', __FILE__ ), array(), filemtime( __DIR__ . '/assets/filters.js' ), true );
}, 30 );
