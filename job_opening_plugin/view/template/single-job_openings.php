<?php
/*
Template Name: カスタムページ
Template Post Type: job_openings
*/

get_header();
?>

<div class="wrap">
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php
          /* Start the Loop */
          while ( have_posts() ) :
            the_post();
            // get_template_part( JOB_OPENING__PLUGIN_DIR . 'view/template/sub' );
            // echo get_the_title();
            echo the_content();
            // If comments are open or we have at least one comment, load up the comment template.
            // if ( comments_open() || get_comments_number() ) :
            //     comments_template();
            // endif;

            // the_post_navigation( array(
            //     'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'twentyseventeen' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
            //     'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'twentyseventeen' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
            // ) );

          endwhile; // End of the loop.
      ?>

    </main><!-- #main -->
  </div><!-- #primary -->
  <?php
  // get_sidebar();
  ?>
</div><!-- .wrap -->

<?php
get_footer();
