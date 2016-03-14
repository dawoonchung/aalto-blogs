<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">
  <nav id="metanav" class="site-meta">
    <div class="container">
      <a href="#" class="aalto-menu"><?php generate_aalto_logo( true ); ?></a>
    </div>
  </nav>

  <header id="masthead" class="site-header" role="banner">
    <div class="container">
      <div class="site-branding">
        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

        <?php $description = get_bloginfo( 'description', 'display' );
        if ( $description || is_customize_preview() ) : ?>
          <p class="site-description"><?php echo $description; ?></p>
        <?php endif; ?>
      </div><!-- .site-branding -->

      <?php if ( has_nav_menu( 'primary' ) ) : ?>
      <div id="site-header-menu" class="site-header-menu">
        
      </div>
      <?php endif; ?>
    </div>
  </header>
