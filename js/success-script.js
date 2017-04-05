(function(){
	"use strict";

	var $ = window.jQuery;


	var contentwrapper = document.querySelector('[data-behaviour=success-story]');
	if(contentwrapper) {
		var archive = document.querySelector('[data-behaviour=success-stories]');
		var links = archive.querySelectorAll('.success-archive__link');

		for(var i = 0; i < links.length; i++) {
			var link = links[i];

			link.addEventListener('click', function(evt) {
				evt.preventDefault();
				var target = evt.target.id;
				console.log(window.location);
				var url = window.location.origin + '/ak-creative/api/get_posts/?post_id=' + target;
				console.log(url);

				$.get( url, function( data ) {
				  console.log(data);
				})
				.fail(function() {
			    	alert( "error" );
			  	});
			});
		}
	}
})();