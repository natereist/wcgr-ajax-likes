<?php 
	
	if( !class_exists( 'WCGR_Likes' ) ){
	
		class WCGR_Likes{
			
			//set up hooks and filters
			public function __construct(){
			
			}
			
			// enqueue scripts, styles and data
			public function enqueue_like_scripts(){
				
			}
			
			// ajax callback
			public function process_like(){
				
			}
			
			// out puts the meta box content
			public function like_meta_box( $post ){
				?>
				This post has <?php echo intval( get_post_meta( $post->ID, 'like_count', 1 ) ); ?>
				<?php
			}
			
			//	appends our like box ot the content on a single post.
			public function like_post_template( $content ){
				if( in_the_loop() ){
					ob_start();
					
					include_once( WCGR_LIKES_PATH . 'templates/like_box.php' );
					
					$content .= ob_get_contents();
					
					ob_end_clean();
				}
				return $content;
			}
			
			// adds the meta box
			public function add_like_meta_box( $post ){
				add_meta_box('like-count-meta-box', 'Likes', array( $this, 'like_meta_box' ), 'post', 'side', 'high' );
			}
		}
	}
	
	if( class_exists( 'WCGR_Likes' ) ){
		new WCGR_Likes();
	}
	
?>