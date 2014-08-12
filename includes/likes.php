<?php 
	
	if( !class_exists( 'WCGR_Likes' ) ){
		class WCGR_Likes{
			
			//set up hooks and filters
			public function __construct(){
				add_action( 'wp_ajax_like_button_process', array( $this, 'process_like'), 10, 1 );
				add_action( 'wp_ajax_nopriv_like_button_process', array( $this, 'process_like'), 10, 1 );
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_like_scripts'), 10, 1 );
				add_action( 'add_meta_boxes_post', array( $this, 'add_like_meta_box'), 10, 1 );
				
				add_filter( 'the_content', array( $this, 'like_post_template' ), 20, 1 );
			}
			
			// enqueue data
			public function enqueue_like_scripts(){
				wp_enqueue_script( 'jquery-cookie', plugins_url( '../js/jquery.cookie.js', __FILE__ ), array( 'jquery' ) );
				wp_enqueue_script( 'wcgr_like_post', plugins_url( '../js/likes.js', __FILE__ ), array( 'jquery', 'jquery-cookie' ) );
				wp_enqueue_style( 'wcgr_like_post', plugins_url( '../css/likes.css', __FILE__ ) );
				
				$object_for_js = array(
					'ajax_url' => admin_url( '/admin-ajax.php' ),
					'nonce' => wp_create_nonce('like_post')
				);
				wp_localize_script( 'wcgr_like_post', 'ajax_data', $object_for_js );
			}
			
			// ajax callback
			public function process_like(){
				if ( isset( $_POST['like_nonce'] ) ) {
					$nonce = $_POST['like_nonce'];
					
					if ( wp_verify_nonce($nonce, 'like_post') ) {
						
						// process the like here
						$post_to_like = $_POST['post_to_like'];
						$count = get_post_meta( $post_to_like, 'like_count', 1 );
						
						$count += 1;
						
						update_post_meta( $post_to_like, 'like_count', $count );
						
						wp_send_json( array( 'like_count' => $count, 'post_liked' => $post_to_like ) );
						
					}
				}
			}
			
			// out puts the meta box content
			public function like_meta_box( $post ){
				?>
				This post has <?php echo intval( get_post_meta( $post->ID, 'like_count', 1 ) ); ?>
				<?php
			}
			
			public function like_post_template( $content ){
				if( in_the_loop() && is_single() ){
					ob_start();
					
					include_once( WCGR_LIKES_PATH . 'templates/like_box.php' );
					
					$content .= ob_get_contents();
					
					ob_end_clean();
				}
				return $content;
			}
			
			// adds our meta box
			public function add_like_meta_box( $post ){
				add_meta_box('like-count-meta-box', 'Likes', array( $this, 'like_meta_box' ), 'post', 'side', 'high' );
			}
		}
	}
	
	if( class_exists( 'WCGR_Likes' ) ){
		new WCGR_Likes();
	}
	
?>