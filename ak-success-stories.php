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



// Enqueue styles and scripts
add_action( 'wp_enqueue_scripts', 'add_success_script' );
function add_success_script() { 
	wp_enqueue_script( 'ak-success-stories', plugins_url('ak-success-stories/js/success-script.js'), array ( 'jquery' ), 1.1, true); 
}


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
	    <nav class="success-archive" data-behaviour="success-stories">
	    	<ul class="success-archive__list">
		    <?php foreach($custom_posts as $post) : setup_postdata($post); ?>
		    	<li class="success-archive__item">
		    		<a class="success-archive__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		    		<span class="success-archive__date"><?php echo get_the_date('jS F Y'); ?></span>
		    	</li>
		        
			<?php endforeach; wp_reset_postdata(); ?>
			</ul>
		</nav>
	<?php
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
    	<div class="success-story">
	        <h3 class="success-story__headline"><?php the_title(); ?></h3>
	        
	        <div class="success-story__content">
	        	<?php the_content(); ?>
	        </div>
	    </div>

        <div class="success-story__nav">
		    <?php 
		    	$next_post = get_next_post();
		    	$prev_post = get_previous_post(); 
		    ?>
	        <a class="success-story__nav-link success-story__nav-link--next"<?php if ( is_a( $next_post , 'WP_Post' ) ) : ?> href="<?php echo get_permalink( $next_post->ID ); ?>" title="link to <?php echo get_the_title( $next_post->ID ); ?>"<?php endif; ?>>
				Next post
			</a>
			
			<a class="success-story__nav-link success-story__nav-link--prev" <?php if ( is_a( $prev_post , 'WP_Post' ) ) : ?> href="<?php echo get_permalink( $prev_post->ID ); ?>" title="link to <?php echo get_the_title( $prev_post->ID ); ?>" <?php endif; ?>>
					prev post
			</a>
		</div>
    
    <?php
    endforeach; wp_reset_postdata();
	}

?>
