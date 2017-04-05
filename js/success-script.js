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
				//http://localhost:8888/tutorial/wp-json/wp/v2/success-stories/105
				var path = '';

				if(window.location.pathname.indexOf('tutorial') > -1) {
					path = '/tutorial';
				} else if (window.pathname.indexOf('ak-creative') > -1) {
					path = '/ak-creative';
				}

				var url = window.location.origin + path + '/wp-json/wp/v2/success-stories/' + target;
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