<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-thumbnail">
<?php post_thumbnail( "thumbnail" ); ?>
</div>
<header class="entry-header">
<?php post_entry_header(); ?>
<?php post_entry_meta() ?>
</header>
<div class="entry-content">
<?php post_entry_content(); ?>
<?php ( is_single() ? post_entry_tag() : "" ); ?>
</div>
</article>