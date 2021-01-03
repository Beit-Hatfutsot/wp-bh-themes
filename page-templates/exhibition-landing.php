<?php
/**
 * Template Name: Exhibition Landing Page
 */?>
<?php get_header( 'exhibition-landing' ); ?>

<div class="landing-wrapper">

	<?php
		/**
		 * Display the header
		 */
		include( locate_template( 'views/exhibition-landing/header.php' ) );
	?>

	<?php
		/**
		 * Display the pinned buttons
		 */
		include( locate_template( 'views/exhibition-landing/pinned-buttons.php' ) );
	?>

	<?php
		/**
		 * Display the banner
		 */
		include( locate_template( 'views/exhibition-landing/banner.php' ) );
	?>

	<?php
		/**
		 * Display the introduction
		 */
		include( locate_template( 'views/exhibition-landing/introduction.php' ) );
	?>

	<?php
		/**
		 * Display the video
		 */
		include( locate_template( 'views/exhibition-landing/video.php' ) );
	?>

	<?php
		/**
		 * Display the visit info
		 */
		include( locate_template( 'views/exhibition-landing/visit-info.php' ) );
	?>

	<?php
		/**
		 * Display the social
		 */
		include( locate_template( 'views/exhibition-landing/social.php' ) );
	?>

</div><!-- .landing-wrapper -->

<?php get_footer( 'exhibition-landing' ); ?>