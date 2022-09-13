


<?php
/* Template Name: Homepage */





get_header();



?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
<div class="breadcrump"><a href="#">Home</a> / <a href="#">Who we are</a> / <a class="active" href="#">Contact</a></div>

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
		<div class="contact-us">
		<h2>Contact Us</h2>
<?php echo apply_shortcodes( '[contact-form-7 id="35" title="Contact Form"]' ); ?>
</div>
<div class="reach-us">
<h2>Reach Us</h2>
<h3>Coalition Skill Test</h3>
<p>
<?php $options=get_option( 'my_option_name' );
echo $options['address'];

?></p>
<p class="phone">Phone: <?php echo $options['phone_number'];  ?><br>
Fax: <?php echo $options['fax_number'];  ?></p>

<div class="social">
	<a target="_blank" href="<?php echo $options['facebook_link'];  ?>">
		<img class="facebook" src="<?php echo get_template_directory_uri(); ?>/img/facebook.png">
	</a>
	<a target="_blank" href="<?php echo $options['twitter_link'];  ?>">
		<img class="twitter" src="<?php echo get_template_directory_uri(); ?>/img/twitter.png">
	</a>
	<a target="_blank" href="<?php echo $options['linkedin_link'];  ?>">
		<img class="linkedin" src="<?php echo get_template_directory_uri(); ?>/img/linkedin.png">
	</a>
	<a target="_blank" href="<?php echo $options['pinterest_link'];  ?>">
		<img class="pinterest" src="<?php echo get_template_directory_uri(); ?>/img/pinterest.png">
	</a>

</div>
</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();
//get_footer();
