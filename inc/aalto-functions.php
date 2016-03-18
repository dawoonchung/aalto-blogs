<?php

/**
 * Official Aalto Blogs Theme Aalto identity functionality
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */

/**
 * Generates random Aalto University official emblem in SVG format
 * TODO: png fallback images for non-svg supporting browsers
 *
 * @since Official Aalto Blogs Theme 1.0
 * @param boolean $color Option for coloured logo or non-coloured logo
 */
function generate_aalto_logo( $color = false ) {
  $logo_type = array(
    'q' => '<g class="symbol q"><path d="M477.2,88.7C477.2,33.1,432.9,2,369.5,2c-61.4,0-108.7,31.8-108.7,88v9h64.9c0-26.9,18.2-38.9,43-38.9c22.8,0,39,12.2,39,30.8c0,14.9-8.5,24.9-27.3,35.5c-27.3,15.4-44,33.4-44,76.4v6.4h65.2v-2.6c0-23,6.5-31.9,30.6-47.7C453.9,144.5,477.2,125.1,477.2,88.7"/><rect x="336.3" y="232.6" width="65.3" height="65.3"/></g>',
    'e' => '<g class="symbol e"><rect x="321.2" y="232.5" width="65.4" height="65.4"/><polygon points="388.7,109.4 388.7,9.4 319.3,9.4 319.3,109.4 333.4,209.3 371.8,209.3 "/></g>',
    'd' => '<g class="symbol d"><path d="M279.7,78.8h33.6c0,20.8-14.7,34.2-33.6,35.4v32.7c39.8-2.2,69.4-28.9,69.4-78.7V9.4h-69.4V78.8z"/><path d="M372.3,78.8h33.6c0,20.8-14.7,34.2-33.6,35.4v32.7c39.8-2.2,69.4-28.9,69.4-78.7V9.4h-69.4V78.8z"/></g>'
  );
  $symbol = array_rand( $logo_type );
  $class = 'aalto-logo aalto-logo-' . $symbol;

  if ( $color ) {
    $color = array( 'red', 'blue', 'yellow' );
    $class .= ' ' . $color[ array_rand( $color ) ];
  }

  $output = '<svg version="1.1" class="'. $class . '" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 480 300">';
  $output .= '<path class="a" d="M184,189.3h-71.2l35.6-102.8L184,189.3z M294.1,297.9L191.9,9.4h-87L2.7,297.9h72.5l17.7-51.1h111l17.7,51.1H294.1z"/>';
  $output .= $logo_type[ $symbol ];
  $output .= '</svg>';

  echo $output;
}

?>
