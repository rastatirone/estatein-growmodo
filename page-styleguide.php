<?php
/**
 * Template Name: Style Guide
 * Description: Visual testing page for global theme styles.
 */

get_header();
?>

	<div class="container">
		<section style="margin-bottom: 40px;">
			<h2>Typography</h2>
			<h1>Heading 1 - Estatein Global Style</h1>
			<h2>Heading 2 - Estatein Global Style</h2>
			<h3>Heading 3 - Estatein Global Style</h3>
			<h4>Heading 4 - Estatein Global Style</h4>
			<h5>Heading 5 - Estatein Global Style</h5>
			<h6>Heading 6 - Estatein Global Style</h6>
			<p>
				This is a standard paragraph used to validate the responsive body typography across breakpoints.
			</p>
			<p>
				This paragraph includes an inline
				<a href="#">anchor link</a>
				for hover and transition testing.
			</p>
		</section>

		<section style="margin-bottom: 40px;">
			<h2>Buttons</h2>
			<a class="btn-primary" href="#">Primary Button</a>
		</section>

		<section style="margin-bottom: 40px;">
			<h2>Forms</h2>
			<div class="estatein-form-container">
				<form action="#" method="post">
					<p style="margin-bottom: 16px;">
						<label for="sg-name">Name</label><br>
						<input id="sg-name" type="text" name="sg_name" placeholder="Enter your name">
					</p>

					<p style="margin-bottom: 16px;">
						<label for="sg-email">Email</label><br>
						<input id="sg-email" type="email" name="sg_email" placeholder="Enter your email">
					</p>

					<p style="margin-bottom: 16px;">
						<label for="sg-message">Message</label><br>
						<textarea id="sg-message" name="sg_message" rows="5" placeholder="Write a message"></textarea>
					</p>

					<button class="btn-primary" type="submit">Submit</button>
				</form>
			</div>
		</section>
	</div>

<?php
get_footer();
