<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Ruta base del tema
$theme_dir = get_stylesheet_directory();

// Siempre cargalos archivos personalizados
$header_view = $theme_dir . '/web/header/header.php';
$footer_view = $theme_dir . '/web/footer/footer.php';

if ( file_exists( $header_view ) ) {
    include $header_view;
}
?>

<main id="primary">
  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
  <?php else : ?>
    <p>Sin contenido.</p>
  <?php endif; ?>
</main>

<?php
if ( file_exists( $footer_view ) ) {
    include $footer_view;
}
