<?php
/**
 * Archive view
 *
 * @author		Beit Hatfutsot
 * @package		bh/views/blog
 * @version		2.7.6
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<section class="page-content">

	<div class="container">
		<div class="row">

			<?php
				/**
				 * Display the blog sidebar
				 */
				get_template_part( 'views/sidebar/sidebar', 'blog' );
			?>

			<div class="col-lg-10 content-wrapper-wide">

				<?php
					/**
					 * Display the author details
					 */
					if ( is_author() || is_month() && isset( $_GET[ 'auth' ]) && $_GET[ 'auth' ] ) { ?>

						<div class="author-meta-wrapper"> 
							<?php get_template_part( 'views/components/meta', 'author' ); ?>
						</div><!-- .author-meta-wrapper -->

					<?php }
				?>

				<?php
					if (have_posts()) :
					
						while (have_posts()) : the_post();
						
							get_template_part('views/blog/loop', 'item');
							
						endwhile;
						
					else :
					
						get_template_part('views/components/not-found');
					
					endif;
				?>

			</div><!-- .content-wrapper-wide -->
			
		</div>	
	</div>
	
</section><!-- .page-content -->