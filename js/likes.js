jQuery( document ).ready(function( $ ){
	
	$('body').on('click', 'a.like-this-post', function(){
		var post = $(this).data( 'post_id' );
		
		var liked_cookie = $.cookie( 'liked_post_' + post );
		
		if( typeof liked_cookie == 'undefined' ){
			var data = {
				post_to_like : post,
				action : 'like_button_process',
				like_nonce : ajax_data.nonce
			}
			
			$.cookie( 'liked_post_' + post, true, { expires: 365, path: '/' });
			
			$.post( ajax_data.ajax_url, data, function( response ){
				$('span#count-' + response.post_liked ).text( response.like_count );
				$('a#like-' + response.post_liked ).text( 'Liked' ).addClass( 'liked' );
			}, 'JSON' );
		}
		else{
			console.log( 'You already like this post.' );
		}
	});
});