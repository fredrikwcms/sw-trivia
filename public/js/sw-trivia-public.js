(function( $ ) {
	'use strict';

	$(document).ready(function() {
		// document ready
		console.log("We haz JevaSkript");
		$('.widget_sw-trivia').each(function(i, widget) {
			$.ajax({
				// send AJAX POST request
				url: my_ajax_obj.ajax_url, // send to ajax-admin.php
				type: 'POST',
				data: {
					action: 'get_starwars_films',
				},
				success:function(response) {
					// console.log(response);
					console.log("We haz great successs!!!");
				},
				error:function(errorThrown) {
					console.log(errorThrown);
				}
			})
			.done(function(response) {
				// Find element to append HTML to
				var content = $(widget).find('.content');
				// Append HTML in THE element
				$(content).html('<strong>In total, we have ' + response.length + ' Star Wars films</strong> ');
				// Create empty array to fill with titles
				var titles = [];
				// Loop over all films and save titles in array
				response.forEach(function(film) { // PHP: foreach($response as $film)
					titles.push(film.title);
				});
				// Print them out, because yeah..
				console.log(titles);
				// And finally print out the titles in <ol> :D 
				$(content).html('<strong>Heres a list of all movies:</strong><br><ol><li>' + titles.join('</li><li>') + '</li></ol>'); // PHP: implode('</li><li>', $titles)
			})
			.fail(function(error) {
				// Print out the whole error thingy 
				console.log('Something went wrong' + error);
			})
		});
	});

})( jQuery );
