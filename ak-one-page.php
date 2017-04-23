<?php
/*
Plugin Name: One Page post plugin for AK Creative
Description: Used to dislay custom post with a one page navigation (e.g success stories). Shortcode for posts: [onePage-posts post_type="posttype_name"]. Shortcode for archive : [onePage-archive headline="The Success Archive" post_type="custom_post"]. 
*/

// Enqueue styles and scripts
add_action( 'wp_enqueue_scripts', 'add_onePage_script' );
function add_onePage_script() { 
	wp_enqueue_script( 'ak-onePage-script', plugins_url('ak-one-page/js/onePage-script.js'), array ( 'jquery' ), 1.1, true); 
}


// Create the archive shortcodes
add_shortcode("onePage-archive", "onePageArchive_sc");

// get all entries & order by date in dsc order
function onePageArchive_sc($atts) {
	extract(shortcode_atts(array( "headline" => ''), $atts));
	extract(shortcode_atts(array( "post_type" => ''), $atts));

    global $post;

    $args = array(
    	'post_type' => $post_type, 
    	'order'=> 'DSC', 
    	'orderby' => 'date');

    $custom_posts = get_posts($args);
    $output = '';

    $output .= 	'
    	<h4 class="ak-archive__headline onePage-archive__headline">'.$headline.'</h4> 
    	<nav class="ak-archive onePage-archive">
	    	<div class="ak-archive__list onePage-archive__list">';

	    	$index = 1;
	    	foreach($custom_posts as $post) : setup_postdata($post);
		    	$slug = basename(get_permalink());
		    	$link = get_the_permalink();
		    	$title = get_the_title();
		    	$date = get_the_date('jS F Y');

		    	$output .= 	
		    		'<a class="ak-archive__item onePage-archive__item" slide="slide_'.$index.'" href="'.$link.'" 
		    		data-link="'.$slug.'">
		    			<span class="ak-archive__title onePage-archive__title">'.$title.'</span>

		    			<span class="ak-archive__date onePage-archive__date">'.$date.'</span>
		    		</a>'; 
				 $index++;
			endforeach; wp_reset_postdata();
			
			$output .= '</div>';
		$output .= '</nav>'; 
	return $output;
}


// Create the post shortcode
add_shortcode("onePage-posts", "onePage_sc");

function ak_the_content( $more_link_text = null, $strip_teaser = false) {
    $content = get_the_content( $more_link_text, $strip_teaser );
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]&gt;', $content );
    return $content;
}

function onePage_sc($atts) {
	extract(shortcode_atts(array( "post_type" => ''), $atts));
    global $post;

    $args = array(
    	'post_type' => $post_type, 
    	'posts_per_page' => 10, 
    	'order'=> 'DSC', 
    	'orderby' => 'date');

    $custom_posts = get_posts($args);
    $output = '';

	$index = 0;
    $output .= 	'
    	<div class="ak-post-wrapper onePage-wrapper">
	    	<div class="ak-posts onePage">'; 
		    
		    foreach($custom_posts as $post) : setup_postdata($post);
		    	$slug = basename(get_permalink());
		    	$title = get_the_title();
		    	$content = ak_the_content();
		    	$output .= 	'
		    	<div class="ak-post onePage-post" id="'.$slug.'"
		    		data-index="'.$index.'" 
		    		data-behaviour="onePage-post">
			        <h3 class="ak-post__headline onePage-post__headline">
			        	'.$title.'</h3>
			        
			        <div class="ak-post__content onePage-post__content">'
			        	.$content.
			        '</div>
			    </div>';

			$index++;
		    endforeach; wp_reset_postdata();
	    	$output .= 	'</div>
		    <div class="ak-post-nav">
			    	
			    <span class="ak-post-nav__label">Share</span>
		    	<div class="ak-post-nav__inner">
			    	<button class="ak-post-nav__button onePage__button--prev">
			    	 	<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:scroll-left"></use></svg>
			    	</button>

			    	<div class="onePage__social"> 
			    		<button class="ak-post-nav__button onePage__button--linkedin">
			    			<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:linkedin"></use></svg>
			    		</button>

			    		<button class="ak-post-nav__button onePage__button--twitter">
			    			<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:twitter"></use></svg>
			    		</button>

			    		<button class="ak-post-nav__button onePage__button--facebook">
			    			<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:facebook"></use></svg>
			    		</button>
			    	</div>

			    	<button class="ak-post-nav__button onePage__button--next">
			    	 	<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:scroll-right"></use></svg>
			    	</button>
			    </div>
		    </div>';
	    
		$output .= 	'</div>';
	return $output;
	}
?>
