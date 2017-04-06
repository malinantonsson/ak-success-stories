(function(){
	"use strict";

	var target;

	var $ = window.jQuery;

	var hash = window.location.hash;
	var startslide = 0;

	//get the hash, if it's a story update inital slide
	if(hash) {
		var story = $('.success-stories').find(hash);

		if(story.length > 0 ) {
			startslide = parseInt($(hash)[0].dataset['index']);
		}		
	}
	

	//disable links
	$('.success-archive__item').on('click', function(evt) {
	  evt.preventDefault();
	}); 


	$('.success-stories').slick({
	  	slidesToShow: 1,
	  	initialSlide: startslide,
	  	slidesToScroll: 1,
	  	arrows: true,
	  	asNavFor: '.success-archive__list',
  		adaptiveHeight: true
	});

	$('.success-archive__list').slick({
	  	slidesToShow: 10,
	  	slidesToScroll: 1,
	  	initialSlide: startslide,
	  	asNavFor: '.success-stories',
	  	focusOnSelect: true,
	  	vertical: true
	});

	//update url on change (both links & arrows)
	$('.success-stories').on('afterChange', function(event, slick, currentSlide){   
		var target = $('[data-slick-index=' + currentSlide + ']')[1].id;
		  if(history.replaceState) {
		    history.replaceState(null, null, '#' + target);
		}
		else {
		    location.hash = target;
		}
	});

})();