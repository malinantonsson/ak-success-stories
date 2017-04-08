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
add_shortcode("onePage-archive", "onePageArchive_sc");

// get all entries & order by date in dsc order
function onePageArchive_sc($atts) {
	extract(shortcode_atts(array( "headline" => ''), $atts));
	extract(shortcode_atts(array( "post_type" => ''), $atts));

    global $post;

    $args = array(
    	'post_type' => 'success-stories', 
    	'order'=> 'DSC', 
    	'orderby' => 'date');

    $custom_posts = get_posts($args);
    $output = '';

    $output .= 	'
    	<h4 class="onePage-archive__headline">'.$headline.'</h4> 
    	<nav class="onePage-archive">
	    	<div class="onePage-archive__list">';

	    	$index = 1;
	    	foreach($custom_posts as $post) : setup_postdata($post);
		    	$slug = basename(get_permalink());
		    	$link = get_the_permalink();
		    	$title = get_the_title();
		    	$date = get_the_date('jS F Y');

		    	$output .= 	
		    		'<a class="onePage-archive__item" slide="slide_'.$index.'" href="'.$link.'" 
		    		data-link="'.$slug.'">
		    			<span class="onePage-archive__title">'.$title.'</span>

		    			<span class="onePage-archive__date">'.$date.'</span>
		    		</a>'; 
				 $index++;
			endforeach; wp_reset_postdata();
			
			$output .= '</div>';
		$output .= '</nav>'; 
	return $output;
}


// Create the post shortcode
add_shortcode("onePage-posts", "onePage_sc");

function onePage_sc($atts) {
    global $post;

    $args = array(
    	'post_type' => 'success-stories', 
    	'posts_per_page' => 10, 
    	'order'=> 'DSC', 
    	'orderby' => 'date');

    $custom_posts = get_posts($args);
    ?>
    <div class="onePage-wrapper">
	    <div class="onePage">
		    <?php
			$index = 0;
		    foreach($custom_posts as $post) : setup_postdata($post);
		    ?>
		    	<div class="onePage-post" id="<?php echo $post->post_name; ?>"
		    		data-index="<?php echo $index ?>" 
		    		data-behaviour="onePage-post">
			        <h3 class="onePage-post__headline"><?php the_title(); ?></h3>
			        
			        <div class="onePage-post__content">
			        	<?php the_content(); ?>
			        </div>
			    </div>
		    
		    <?php
			$index++;
		    endforeach; wp_reset_postdata(); ?>
	    </div>
	    <div class="onePage__bottom">
	    	<button class="onePage__button onePage__button--prev">
	    	 	<svg class="ak-icon onePage__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:scroll-left"></use></svg>
	    	</button>

	    	<div class="onePage__social"> 
	    		<button class="onePage__button onePage__button--linkedin">
	    			<svg class="ak-icon onePage__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:linkedin"></use></svg>
	    		</button>

	    		<button class="onePage__button onePage__button--twitter">
	    			<svg class="ak-icon onePage__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:twitter"></use></svg>
	    		</button>

	    		<button class="onePage__button onePage__button--facebook">
	    			<svg class="ak-icon onePage__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:facebook"></use></svg>
	    		</button>
	    	</div>

	    	<button class="onePage__button onePage__button--next">
	    	 	<svg class="ak-icon onePage__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:scroll-right"></use></svg>
	    	</button>
	    </div>
	    
	</div>
    <?php
	}

?>
