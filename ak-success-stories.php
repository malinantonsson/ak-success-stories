<?php
/*
Plugin Name: Success stories for AK Creative
Description: Used to dislay success stories
*/

// Our custom post type function
function create_posttype() {

	register_post_type( 'success-stories',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Success Stories' ),
				'singular_name' => __( 'Success story' )
			),
			'public' => true,
			'has_archive' => true,
			'supports' => array('custom-fields'),
			'rewrite' => array('slug' => 'success-stories'),
		)
	);
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

// Create the Team shortcode
add_shortcode("success-story-archive", "successStoriesArchive_sc");

function successStoriesArchive_sc($atts) {
    global $post;

    $args = array(
    	'post_type' => 'success-stories', 
    	'order'=> 'ASC', 
    	'orderby' => 'date');

    $custom_posts = get_posts($args);
    ?>
    <h2>Success story Archive</h2>
    <?php

    foreach($custom_posts as $post) : setup_postdata($post);
        $output = 'im the output archive';
        ?>
        
        <h3>date: <?php echo get_the_date('jS F Y'); ?> </h3>

        <a href="<?php the_permalink(); ?>">title: <?php the_title(); ?></a>
        
	<?php
    endforeach; wp_reset_postdata();
	return $output;
}


// Create the Team shortcode
add_shortcode("success-story-latest", "successStories_sc");

function successStories_sc($atts) {
    global $post;

    $args = array(
    	'post_type' => 'success-stories', 
    	'posts_per_page' => 1, 
    	'order'=> 'ASC', 
    	'orderby' => 'date');

    $custom_posts = get_posts($args);

    foreach($custom_posts as $post) : setup_postdata($post);
        $output = 'im the output';
        ?>
        <h2>Success story post</h2>
        <a href="<?php the_permalink(); ?>">Link</a><br>
        title: <?php the_title(); ?> <br>
        content: <?php the_content(); ?>

        <?php 
	       $next_post = get_next_post();
if ( is_a( $next_post , 'WP_Post' ) ) : ?>
    <a href="<?php echo get_permalink( $next_post->ID ); ?>">Next post: <?php echo get_the_title( $next_post->ID ); ?></a>
<?php endif; ?>
 
 	<?php 
    	endforeach; wp_reset_postdata();
		return $output;
	}

?>
