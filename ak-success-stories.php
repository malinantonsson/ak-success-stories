<?php
/*
Plugin Name: Success stories for AK Creative
Description: Used to dislay success stories
*/

// Register the new posttype
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
			'rewrite' => array('slug' => 'success-stories')
		)
	);
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );


// Create the archive shortcodes
add_shortcode("success-story-archive", "successStoriesArchive_sc");

// get all entries & order by date in dsc order
function successStoriesArchive_sc($atts) {
    global $post;

    $args = array(
    	'post_type' => 'success-stories', 
    	'order'=> 'DSC', 
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


// Create the post shortcode
add_shortcode("success-story-latest", "successStories_sc");

function successStories_sc($atts) {
    global $post;

    $args = array(
    	'post_type' => 'success-stories', 
    	'posts_per_page' => 1, 
    	'order'=> 'DSC', 
    	'orderby' => 'date');

    $custom_posts = get_posts($args);

    foreach($custom_posts as $post) : setup_postdata($post);
    ?>
        <h3 class="success-stories__headline"><?php the_title(); ?></h3>
        
        <div class="success-stories__content">
        	<?php the_content(); ?>
        </div>

        <div class="success-stories__nav">
		    <?php 
		    	$next_post = get_next_post();
		    	$prev_post = get_previous_post(); 
		    ?>
	        <a class="success-stories__nav-link success-stories__nav-link--next"<?php if ( is_a( $next_post , 'WP_Post' ) ) : ?> href="<?php echo get_permalink( $next_post->ID ); ?>" title="link to <?php echo get_the_title( $next_post->ID ); ?>"<?php endif; ?>>
				Next post
			</a>
			
			<a class="success-stories__nav-link success-stories__nav-link--prev" <?php if ( is_a( $prev_post , 'WP_Post' ) ) : ?> href="<?php echo get_permalink( $prev_post->ID ); ?>" title="link to <?php echo get_the_title( $prev_post->ID ); ?>" <?php endif; ?>>
					prev post
			</a>
		</div>
    
    <?php
    endforeach; wp_reset_postdata();
	}

?>
