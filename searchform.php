<?php
/**
 * Template for displaying search forms
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Official Aalto Blogs Theme 1.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <button type="submit" class="search-submit"><span class="screen-reader-text">Search</span></button>
  <label>
    <span class="screen-reader-text">Search for:</span>
    <input type="search" class="search-field" value="<?php echo get_search_query(); ?>" name="s" title="Search for:" />
  </label>
</form>
