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
			'rewrite' => array('slug' => 'success-stories'),
		)
	);
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

// Create the Team shortcode
add_shortcode("success-story-latest", "successStories_sc");

function successStories_sc($atts) {
    global $post;

    $args = array(
    	'post_type' => 'success-stories', 
    	'posts_per_page' => 1, 
    	'order'=> 'ASC', 
    	'orderby' => 'title');

    $custom_posts = get_posts($args);

    foreach($custom_posts as $post) : setup_postdata($post);
        $output = 'im the output';
        ?>
        <a href="<?php the_permalink(); ?>"><?php the_content(); ?></a>
        
	<?php
    endforeach; wp_reset_postdata();
	return $output;
}

?>
