<?php     
/**     
 * The template for displaying the header
 *      
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */ 

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
  <header id="masthead" class="site-header" role="banner">
    <aside id="metanav" class="site-meta">
      <div class="container">
        <a href="#" class="aalto-menu"><?php generate_aalto_logo( true ); ?></a>

        <div class="aalto-blogs-link">
          <a href="#">Create your blog</a>
          <a href="#">Login</a>
        </div>
      </div>
    </aside>

    <div class="container">
      <div class="site-branding">
        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

        <?php $description = get_bloginfo( 'description', 'display' );
        if ( !$description || is_customize_preview() ) : ?>
          <h2 class="site-description"><?php echo $description; ?></h2>
        <?php endif; ?>
      </div><!-- .site-branding -->
    </div>

    <?php if ( has_nav_menu( 'primary' ) ) : ?>
      <div id="site-header-menu" class="site-header-menu">
        <div class="container">
          <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Primary Menu">
            <?php
              wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu list-unstyled'
              ) );
            ?>
          </nav>
        </div>
      </div>
    <?php endif; ?>
  </header>

  <div id="content" class="site-content">
