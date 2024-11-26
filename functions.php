<?php
/**
* Thiết lập các hằng dữ liệu quan trọng
* THEME_URL = get_stylesheet_directory() – đường dẫn tới thư mục theme
* CORE = thư mục /core của theme, chứa các file nguồn quan trọng.
*/
define( 'THEME_URL', get_stylesheet_directory() );
define( 'CORE', THEME_URL . '/core' );

/**
* Load file /core/init.php
* Đây là file cấu hình ban đầu của theme mà sẽ không nên được thay đổi sau này.
*/
require_once( CORE . '/init.php' );

/**
* Thiết lập $content_width để khai báo kích thước chiều rộng của nội dung
*/
if ( !isset( $content_width ) ) {
    $content_width = 620;
    // Nếu biến $content_width chưa có dữ liệu thì gán giá trị cho nó
}

/**
* Thiết lập các chức năng sẽ được theme hỗ trợ
*/
if ( !function_exists( 'theme_setup' ) ) {
    function theme_setup() {
        // Thiết lập theme có thể dịch được
        $language_folder = THEME_URL . '/languages';
        load_theme_textdomain( 'nguyenviet', $language_folder );

        // Tự chèn RSS Feed links trong <head>
        add_theme_support( 'automatic-feed-links' );

        // Thêm chức năng post thumbnail
        add_theme_support( 'post-thumbnails' );

        // Thêm chức năng title-tag để tự thêm <title>
        add_theme_support( 'title-tag' );

        // Thêm chức năng post format
        add_theme_support( 'post-formats', array(
            'video',
            'image',
            'audio',
            'gallery'
        ) );

        // Thêm chức năng custom background
        $default_background = array(
            'default-color' => '#e8e8e8',
        );
        add_theme_support( 'custom-background', $default_background );

        // Tạo menu cho theme
        register_nav_menu( 'primary-menu', __( 'Primary Menu', 'nguyenviet' ) );

        // Tạo sidebar cho theme
        $sidebar = array(
            'name'          => __( 'Main Sidebar', 'nguyenviet' ),
            'id'            => 'main-sidebar',
            'description'   => 'Main sidebar for Custom theme',
            'class'         => 'main-sidebar',
            'before_title'  => '<h3 class="widgettitle">',
            'after_title'   => '</h3>',
        );
        register_sidebar( $sidebar );
    }

    add_action( 'after_setup_theme', 'theme_setup' );
}

/**
@ Thiết lập hàm hiển thị logo
@ website_logo()
**/
if ( ! function_exists( 'website_logo' ) ) {
    function website_logo() {
        ?>
        <div class = 'logo'>
        <div class = 'site-name'>
        <?php if ( is_home() ) {
            printf(
                '<h1><a href = "%1$s" title = "%2$s">%3$s</a></h1>',
                get_bloginfo( 'url' ),
                get_bloginfo( 'description' ),
                get_bloginfo( 'sitename' )
            );
        } else {
            printf(
                '</p><a href = "%1$s" title = "%2$s">%3$s</a></p>',
                get_bloginfo( 'url' ),
                get_bloginfo( 'description' ),
                get_bloginfo( 'sitename' )
            );
        }
        // endif ?>
        </div>
        <div class = 'site-description'><?php bloginfo( 'description' );
        ?></div>

        </div>
        <?php
    }
}

/**
@ Thiết lập hàm hiển thị menu
@ website_menu( $slug )
**/
if ( ! function_exists( 'website_menu' ) ) {
    function website_menu( $slug ) {
        $menu = array(
            'theme_location' => $slug,
            'container' => 'nav',
            'container_class' => $slug,
        );
        wp_nav_menu( $menu );
    }
}

/**
@ Tạo hàm phân trang cho index, archive.
@ Hàm này sẽ hiển thị liên kết phân trang theo dạng chữ: Newer Posts & Older Posts
@ website_pagination()
**/
if ( ! function_exists( 'website_pagination' ) ) {
    function website_pagination() {
        /*
        * Không hiển thị phân trang nếu trang đó có ít hơn 2 trang
        */
        global $wp_query;
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }

        ?>
        <nav class = 'pagination' role = 'navigation'>
        <?php if ( get_next_post_link() ) : ?>
        <div class = 'prev'><?php next_posts_link( __( 'Older Posts', 'nguyenviet' ) );
        ?></div>
        <?php endif;
        ?>

        <?php if ( get_previous_post_link() ) : ?>
        <div class = 'next'><?php previous_posts_link( __( 'Newer Posts', 'nguyenviet' ) );
        ?></div>
        <?php endif;
        ?>

        </nav>
        <?php
    }
}

/**
@ Hàm hiển thị ảnh thumbnail của post.
@ Ảnh thumbnail sẽ không được hiển thị trong trang single
@ Nhưng sẽ hiển thị trong single nếu post đó có format là Image
@ post_thumbnail( $size )
**/
if ( ! function_exists( 'post_thumbnail' ) ) {
    function post_thumbnail( $size ) {
        // Chỉ hiển thumbnail với post không có mật khẩu
        if ( ! is_single() &&  has_post_thumbnail()  && ! post_password_required() || has_post_format( 'image' ) ) : ?>
        <figure class = 'post-thumbnail'><?php the_post_thumbnail( $size );
        ?></figure><?php
        endif;
    }
}

/**
@ Hàm hiển thị tiêu đề của post trong .entry-header
@ Tiêu đề của post sẽ là nằm trong thẻ <h1> ở trang single
@ Còn ở trang chủ và trang lưu trữ, nó sẽ là thẻ <h2>
@ post_entry_header()
**/
if ( ! function_exists( 'post_entry_header' ) ) {
    function post_entry_header() {
        if ( is_single() ) : ?>
        <h1 class = 'entry-title'>
        <a href = '<?php the_permalink(); ?>' rel = 'bookmark' title = '<?php the_title_attribute(); ?>'>
        <?php the_title();
        ?>
        </a>
        </h1>
        <?php else : ?>
        <h2 class = 'entry-title'>
        <a href = '<?php the_permalink(); ?>' rel = 'bookmark' title = '<?php the_title_attribute(); ?>'>
        <?php the_title();
        ?>
        </a>
        </h2><?php

        endif;
    }
}

/**
@ Hàm hiển thị thông tin của post ( Post Meta )
@ post_entry_meta()
**/
if ( ! function_exists( 'post_entry_meta' ) ) {
    function post_entry_meta() {
        if ( ! is_page() ) {
            echo "<div class='entry-meta'>";

            // Display the author name
            printf(
                __( "<span class='author'>Posted by %1\$s</span>", 'nguyenviet' ),
                get_the_author()
            );

            // Display the post date
            printf(
                __( "<span class='date-published'> at %1\$s</span>", 'nguyenviet' ),
                get_the_date()
            );

            // Display the category list
            printf(
                __( "<span class='category'> in %1\$s</span>", 'nguyenviet' ),
                get_the_category_list( ', ' )
            );

            // Display the comment count if comments are open
            if ( comments_open() ) {
                echo "<span class='meta-reply'>";
                comments_popup_link(
                    __( 'Leave a comment', 'nguyenviet' ),
                    __( 'One comment', 'nguyenviet' ),
                    __( '% comments', 'nguyenviet' )
                );
                echo '</span>';
            }

            echo '</div>';
        }
    }
}

/*
* Add 'Read More' link to excerpt
*/

function post_readmore() {
    return '…<a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read More', 'nguyenviet' ) . '</a>';
}
add_filter( 'excerpt_more', 'post_readmore' );

/**
* Display the content of post type
*
* This function shows the excerpt on the homepage ( using `the_excerpt` )
* but displays the full content on single post pages ( using `the_content` ).
* It also supports pagination within posts.
*/
if ( ! function_exists( 'post_entry_content' ) ) {
    function post_entry_content() {
        if ( ! is_single() ) {
            the_excerpt();
        } else {
            the_content();

            /*
            * Display pagination within the post
            */
            $link_pages = array(
                'before'           => '<p>' . __( 'Page:', 'nguyenviet' ) . ' ',
                'after'            => '</p>',
                'nextpagelink'     => __( 'Next page', 'nguyenviet' ),
                'previouspagelink' => __( 'Previous page', 'nguyenviet' ),
            );
            wp_link_pages( $link_pages );
        }
    }
}

/**
* Display the tags of a post
* post_entry_tag()
*/
if ( ! function_exists( 'post_entry_tag' ) ) {
    function post_entry_tag() {
        if ( has_tag() ) {
            echo '<div class="entry-tag">';
            printf(
                __( 'Tagged in %1$s', 'nguyenviet' ),
                get_the_tag_list( '', ', ' )
            );
            echo '</div>';
        }
    }
}

/**
@ Chèn CSS và Javascript vào theme
@ sử dụng hook wp_enqueue_scripts() để hiển thị nó ra ngoài front-end
**/

function website_styles() {
    /*
    * Hàm get_stylesheet_uri() sẽ trả về giá trị dẫn đến file style.css của theme
    * Nếu sử dụng child theme, thì file style.css này vẫn load ra từ theme mẹ
    */
    wp_register_style( 'main-style', get_template_directory_uri() . '/style.css', 'all' );
    wp_enqueue_style( 'main-style' );
}
add_action( 'wp_enqueue_scripts', 'website_styles' );
