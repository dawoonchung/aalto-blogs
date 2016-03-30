<?php 
/**
 * Official Aalto Blogs Theme helper functions
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */

/**
 * Convert hex colour to rgb
 *
 * @link https://css-tricks.com/snippets/php/convert-hex-to-rgb/
 * @since Official Aalto Blogs Theme 1.0
 */
function hex2rgb( $colour ) {
	if ( $colour[0] == '#' ) {
		$colour = substr( $colour, 1 );
	}
	if ( strlen( $colour ) == 6 ) {
		list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
	} elseif ( strlen( $colour ) == 3 ) {
		list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
	} else {
		return false;
	}
	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );
	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Adds opacity to given colour array and returns into rgba format
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_add_opacity( $colour, $opacity ) {
  return 'rgba(' . $colour['red'] . ',' . $colour['green'] . ',' . $colour['blue'] . ',' . $opacity . ')';
}

/**
 * Converts hex and opacity into rgba format.
 * Simple combination of above two functions.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_rgba( $colour, $opacity ) {
  return aalto_blogs_add_opacity( hex2rgb( $colour ), $opacity );
}

/**
 * Generate breadcrumb.
 * Based on Ben Sibley's work, with sanitised title added.
 * Sanitised Title: return '(No Title)' if empty.
 *
 * @url https://github.com/BenSibley/ignite/blob/master/inc/breadcrumbs.php
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_breadcrumbs( $args = array() ) {
	if ( is_front_page() ) {
		return;
	}

	if ( ! get_theme_mod( 'breadcrumbs' ) ) {
		return;
	}
	global $post;
	$defaults  = array(
		'separator_icon'      => '&gt;',
		'breadcrumbs_id'      => 'breadcrumbs',
		'breadcrumbs_classes' => 'breadcrumb-trail breadcrumbs hidden-xs',
		'home_title'          => 'Home'
	);
	$args      = apply_filters( 'aalto_blogs_breadcrumbs_args', wp_parse_args( $args, $defaults ) );
	$separator = '<span class="separator"> ' . esc_attr( $args['separator_icon'] ) . ' </span>';
  $title_sanitised = get_the_title() ?: '(No Title)';
	/***** Begin Markup *****/
	// Open the breadcrumbs
	$html = '<div id="' . esc_attr( $args['breadcrumbs_id'] ) . '" class="' . esc_attr( $args['breadcrumbs_classes'] ) . '">';
	// Add Homepage link & separator (always present)
	$html .= '<span class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . esc_attr( $args['home_title'] ) . '">' . esc_attr( $args['home_title'] ) . '</a></span>';
	$html .= $separator;
	// Post
	if ( is_singular( 'post' ) ) {
		$category = get_the_category();
		$category_values = array_values( $category );
		$last_category = end( $category_values );
		$cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ';' ), ';' );
		$cat_parents = explode( ';', $cat_parents );
		foreach ( $cat_parents as $parent ) {
			$html .= '<span class="item-cat">' . wp_kses( $parent, wp_kses_allowed_html( 'a' ) ) . '</span>';
			$html .= $separator;
		}
		$html .= '<span class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . $title_sanitised . '">' . $title_sanitised . '</span></span>';
	} elseif ( is_singular( 'page' ) ) {
		if ( $post->post_parent ) {
			$parents = get_post_ancestors( $post->ID );
			$parents = array_reverse( $parents );
			foreach ( $parents as $parent ) {
				$html .= '<span class="item-parent item-parent-' . esc_attr( $parent ) . '"><a class="bread-parent bread-parent-' . esc_attr( $parent ) . '" href="' . esc_url( get_permalink( $parent ) ) . '" title="' . ( get_the_title( $parent ) ?: '(No Title)' ) . '">' . ( get_the_title( $parent ) ?: '(No Title)' ) . '</a></span>';
				$html .= $separator;
			}
		}
		$html .= '<span class="item-current item-' . $post->ID . '"><span title="' . $title_sanitised . '"> ' . $title_sanitised . '</span></span>';
	} elseif ( is_singular( 'attachment' ) ) {
		$parent_id        = $post->post_parent;
		$parent_title     = get_the_title( $parent_id ) ?: '(No Title)';
		$parent_permalink = esc_url( get_permalink( $parent_id ) );
		$html .= '<span class="item-parent"><a class="bread-parent" href="' . esc_url( $parent_permalink ) . '" title="' . esc_attr( $parent_title ) . '">' . esc_attr( $parent_title ) . '</a></span>';
		$html .= $separator;
		$html .= '<span class="item-current item-' . $post->ID . '"><span title="' . $title_sanitised . '"> ' . $title_sanitised . '</span></span>';
	} elseif ( is_singular() ) {
		$post_type         = get_post_type();
		$post_type_object  = get_post_type_object( $post_type );
		$post_type_archive = get_post_type_archive_link( $post_type );
		$html .= '<span class="item-cat item-custom-post-type-' . esc_attr( $post_type ) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr( $post_type ) . '" href="' . esc_url( $post_type_archive ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . esc_attr( $post_type_object->labels->name ) . '</a></span>';
		$html .= $separator;
		$html .= '<span class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . $post->post_title . '">' . $post->post_title . '</span></span>';
	} elseif ( is_category() ) {
		$parent = get_queried_object()->category_parent;
		if ( $parent !== 0 ) {
			$parent_category = get_category( $parent );
			$category_link   = get_category_link( $parent );
			$html .= '<span class="item-parent item-parent-' . esc_attr( $parent_category->slug ) . '"><a class="bread-parent bread-parent-' . esc_attr( $parent_category->slug ) . '" href="' . esc_url( $category_link ) . '" title="' . esc_attr( $parent_category->name ) . '">' . esc_attr( $parent_category->name ) . '</a></span>';
			$html .= $separator;
		}
		$html .= '<span class="item-current item-cat"><span class="bread-current bread-cat" title="' . $post->ID . '">' . single_cat_title( '', false ) . '</span></span>';
	} elseif ( is_tag() ) {
		$html .= '<span class="item-current item-tag"><span class="bread-current bread-tag">' . single_tag_title( '', false ) . '</span></span>';
	} elseif ( is_author() ) {
		$html .= '<span class="item-current item-author"><span class="bread-current bread-author">' . get_queried_object()->display_name . '</span></span>';
	} elseif ( is_day() ) {
		$html .= '<span class="item-current item-day"><span class="bread-current bread-day">' . get_the_date() . '</span></span>';
	} elseif ( is_month() ) {
		$html .= '<span class="item-current item-month"><span class="bread-current bread-month">' . get_the_date( 'F Y' ) . '</span></span>';
	} elseif ( is_year() ) {
		$html .= '<span class="item-current item-year"><span class="bread-current bread-year">' . get_the_date( 'Y' ) . '</span></span>';
	} elseif ( is_archive() ) {
		$custom_tax_name = get_queried_object()->name;
		$html .= '<span class="item-current item-archive"><span class="bread-current bread-archive">' . esc_attr( $custom_tax_name ) . '</span></span>';
	} elseif ( is_search() ) {
		$html .= '<span class="item-current item-search"><span class="bread-current bread-search">Search results for: ' . get_search_query() . '</span></span>';
	} elseif ( is_404() ) {
		$html .= '<span>Error 404</span>';
	} elseif ( is_home() ) {
		$html .= '<span>' . ( get_the_title( get_option( 'page_for_posts' ) ) ?: '(No Title)' ) . '</span>';
	}
	$html .= '</div>';
	$html = apply_filters( 'aalto_blogs_breadcrumbs_filter', $html );
	echo wp_kses_post( $html );
}

?>
