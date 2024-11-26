<?php get_header();
?>
<div id = 'content'>
<div class = 'author-box'>
<?php
// Display the author's avatar
		echo '<div class = 'author-avatar'>' . get_avatar( get_the_author_meta( 'ID' ) ) . '</div>';

		// Display the author's name
printf(
    '<h3>' . __( 'Posts by %1$s', 'thachpham' ) . '</h3>',
    get_the_author()
);

// Display the author's description
		echo '<p>' . get_the_author_meta( 'description' ) . '</p>';

		// Display the author's website field
if ( get_the_author_meta( 'user_url' ) ) {
    printf(
        '<p><a href="%1$s" title="Visit %2$s\'s website">' . __( 'Visit my website', 'thachpham' ) . '</a></p>',
				esc_url( get_the_author_meta( 'user_url' ) ),
				get_the_author()
			);
		}
		?>
	</div>
	
	<section id="main-content">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
			<?php thachpham_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	</section>
	
	<section id="sidebar">
        <?php get_sidebar();
        ?>
        </section>
        </div>

        <?php get_footer();
        ?>
