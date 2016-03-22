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
function addOpacity( $colour, $opacity ) {
  return 'rgba(' . $colour['red'] . ',' . $colour['green'] . ',' . $colour['blue'] . ',' . $opacity . ');';
}

/**
 * Converts hex and opacity into rgba format.
 * Simple combination of above two functions.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_rgba( $colour, $opacity ) {
  return addOpacity( hex2rgb( $colour ), $opacity );
}

?>
