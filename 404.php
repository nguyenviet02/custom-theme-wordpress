<?php get_header();
?>
<div id = 'content'>

<section id = 'main-content'>
<?php
// Display 404 title and message
echo '<h2>' . __( '404 NOT FOUND', 'thachpham' ) . '</h2>';
echo '<p>' . __( 'The article you were looking for was not found, but maybe try looking again!', 'thachpham' ) . '</p>';

// Display search form
get_search_form();

// Display content categories
echo '<h3>' . __( 'Content Categories', 'thachpham' ) . '</h3>';
echo '<div class="404-catlist">';
wp_list_categories( array( 'title_li' => '' ) );
echo '</div>';

// Display tag cloud
echo '<h3>' . __( 'Tag Cloud', 'thachpham' ) . '</h3>';
wp_tag_cloud();
?>
</section>

<section id = 'sidebar'>
<?php get_sidebar();
?>
</section>

</div>

<?php get_footer();
?>
