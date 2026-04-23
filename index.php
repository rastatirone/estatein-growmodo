<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 */

get_header();
?>

	<div class="container">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		else :
			echo '<p>No content found.</p>';
		endif;
		?>
	</div>

<?php
get_footer();
