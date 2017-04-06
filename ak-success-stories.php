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
			'labels' 	=> 	array(
				'name' 	=> 	__( 'Success Stories' ),
				'singular_name' => __( 'Success story' )
			),
			'public' 	=> 	true,
			'show_in_rest' 	=> 	true,
        	'publicly_queryable' => true,
			'has_archive' 	=> 	true,
			'rewrite' 	=> 	array('slug' => 'success-stories')
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
	    	<div class="success-archive__list">
		    <?php 
		    	$index = 1;
		    	foreach($custom_posts as $post) : setup_postdata($post); ?>
	    		<a class="success-archive__item" slide="slide_<?php $index ?>" href="<?php the_permalink(); ?>" 
	    		data-link="<?php echo $post->post_name; ?>"><?php the_title(); ?>

	    			<span class="success-archive__date"><?php echo get_the_date('jS F Y'); ?></span>
	    		</a>
		        
			<?php 
			 $index++;
			endforeach; wp_reset_postdata(); ?>
			
			</div>
		</nav>
	<?php
}


// Create the post shortcode
add_shortcode("success-story-latest", "successStories_sc");

function successStories_sc($atts) {
    global $post;

    $args = array(
    	'post_type' => 'success-stories', 
    	'posts_per_page' => 10, 
    	'order'=> 'DSC', 
    	'orderby' => 'date');

    $custom_posts = get_posts($args);
    ?>
    <div class="success-stories">
	    <?php
		$index = 0;
	    foreach($custom_posts as $post) : setup_postdata($post);
	    ?>
	    	<div class="success-story" id="<?php echo $post->post_name; ?>"
	    		data-index="<?php echo $index ?>" 
	    		data-behaviour="success-story">
		        <h3 class="success-story__headline"><?php the_title(); ?></h3>
		        
		        <div class="success-story__content">
		        	<?php the_content(); ?>
		        </div>
		    </div>
	    
	    <?php
		$index++;
	    endforeach; wp_reset_postdata(); ?>
    </div>
    <?php
	}

?>
