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
    <?php if ( get_header_image() ) : ?>
      <img src="<?php echo( get_header_image() ); ?>" alt="<?php echo( get_bloginfo( 'title' ) ); ?>" class="header-placeholder-image" />
    <?php endif; ?>
    <aside id="metanav" class="site-meta">
      <div class="container">
        <div class="aalto-menu dropdown">
          <button class="dropdown-toggle" type="button" id="aalto-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php
              if ( get_theme_mod( 'header_logo_color' ) == 'black' ) {
                $logo_color = '000';
              }
              else {
                $logo_color = 'FFF';
              }
              generate_aalto_logo( '#' . $logo_color );
            ?>
          </button>

          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li class="clearfix aalto-search"><?php get_aalto_search_form(); ?></li>
            <li><a href="http://blogs.aalto.fi/">Aalto Blogs Main</a></li>
            <li><a href="http://aalto.fi/en">Aalto University</a></li>
            <li><a href="https://into.aalto.fi/display/enit/Homepage">Aalto IT</a></li>
            <li><a href="http://blogs.aalto.fi/faq">Aalto Blogs Support (FAQ)</a></li>
          </ul>
        </div>

        <div class="aalto-blogs-link">
        <a href="<?php echo wp_registration_url(); ?>">Create your blog</a>
          <?php if ( is_user_logged_in() ) : ?>
          <a href="<?php echo wp_logout_url(); ?>" title="Logout">Logout</a>
          <?php else : ?>
          <a href="https://blogs.ittest.aalto.fi/shibboleth-login.php?action=shibboleth" title="Login">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </aside>

    <div class="header-text-area">
      <div class="container">
        <div class="site-branding">
          <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

          <?php $description = get_bloginfo( 'description', 'display' );
          if ( $description ) : ?>
            <h2 class="site-description"><?php echo $description; ?></h2>
          <?php endif; ?>

          <div class="header-search hidden-xs">
            <?php get_search_form(); ?>
          </div>
        </div><!-- .site-branding -->

      </div>

      <?php if ( has_nav_menu( 'primary' ) ) : ?>
        <div id="site-header-menu" class="site-header-menu">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#site-navigation" aria-expanded="false">
                <span class="screen-reader-text">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>

              <div class="navbar-search visible-xs">
                <?php get_search_form(); ?>
              </div>
            </div>

            <nav id="site-navigation" class="main-navigation collapse navbar-collapse" role="navigation" aria-label="Primary Menu">
              <?php
                wp_nav_menu( array(
                  'theme_location' => 'primary',
                  'menu_class'     => 'primary-menu list-unstyled nav navbar-nav',
                  'depth'          => 2
                ) );
              ?>
            </nav>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </header>

  <div id="content" class="site-content">
