<?php 
/**
 * JKL Grammar page template (for React app)
 *
 * @since    1.0.0
 */ 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
 <head>
 	<meta charset="<?php bloginfo( 'charset' ); ?>">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 	<meta name="mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
 	<link rel="profile" href="http://gmpg.org/xfn/11">
 	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
 	<?php wp_head(); ?>

 </head>

 <body <?php body_class(); ?>>
   <input id="home_url" type="hidden" value="<?php echo get_home_url(); ?>" />
   <div id="root">
    <h1>Grammar Index</h1>
   </div>
 </body>

<?php get_footer(); ?>