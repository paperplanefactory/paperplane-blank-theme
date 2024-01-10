<?php
function paperplane_add_ab_test_metadata() {
	global $post;
	if ( get_field( 'ab_testing_page_a', $post->ID ) || get_field( 'ab_testing_page_b', $post->ID ) ) {
		$ab_testing_manage = get_field( 'ab_testing_manage', $post->ID );
		$ab_ga4_event_name = get_field( 'ab_ga4_event_name', $ab_testing_manage );
		$ab_testing_page_a = get_field( 'ab_testing_page_a', $post->ID );
		$ab_testing_page_b = get_field( 'ab_testing_page_b', $post->ID );
		$ab_testing_page_a_url = get_the_permalink( $ab_testing_page_a );
		$ab_testing_page_b_url = get_the_permalink( $ab_testing_page_b );
		$ab_testing_page_this_url = get_the_permalink( $post->ID );
		echo '<meta name="ab-testing" content="' . $ab_ga4_event_name . '" data-this-page-id="' . $post->ID . '" data-b-page-id="' . $ab_testing_page_b . '" data-this-page-url="' . $ab_testing_page_this_url . '" data-a-page-url="' . $ab_testing_page_a_url . '" data-b-page-url="' . $ab_testing_page_b_url . '">' . "\n";
		if ( ! is_user_logged_in() ) { ?>
			<script type="text/javascript">
				var ab_test_name = jQuery("meta[name='ab-testing']").attr("content");
				var this_page_id = jQuery('meta[name="ab-testing"]').data('this-page-id');
				var b_page_id = jQuery('meta[name="ab-testing"]').data('b-page-id');
				if (this_page_id != b_page_id) {
					var this_page_url = jQuery('meta[name="ab-testing"]').data('this-page-url');
					var testing_urls = [];
					var a_page_url = jQuery('meta[name="ab-testing"]').data('a-page-url');
					testing_urls.push(a_page_url);
					var b_page_url = jQuery('meta[name="ab-testing"]').data('b-page-url');
					testing_urls.push(b_page_url);
					var random_url = testing_urls[Math.floor(Math.random() * testing_urls.length)];
					if (random_url != this_page_url) {
						if (typeof gtag === 'function') {
							gtag('event', ab_test_name, {
								'visited_page_url': random_url,
								'a_page_url': a_page_url,
								'b_page_url': b_page_url
							});
						}
						window.location.replace(random_url);
					}
				}

			</script>
		<?php }
	}
}

add_action( 'wp_head', 'paperplane_add_ab_test_metadata' );

function paperplane_manage_ab_test_data( $post_id ) {
	global $post;
	if ( 'cpt_abtest' == $post->post_type ) {
		$current_post_status = get_post_status( $post_id );

		if ( isset( $_POST['acf']['field_6552438a23ad4'] ) ) {
			$ab_testing_enabled = $_POST['acf']['field_6552438a23ad4'];
		} else {
			$ab_testing_enabled = get_field( 'ab_testing_enabled', $post_id );
		}
		if ( isset( $_POST['acf']['field_655243c223ad5'] ) ) {
			$ab_testing_page_a = $_POST['acf']['field_655243c223ad5'];
		} else {
			$ab_testing_page_a = get_field( 'ab_testing_page_a', $post_id );
		}
		if ( isset( $_POST['acf']['field_655390095ccad'] ) ) {
			$ab_testing_page_b = $_POST['acf']['field_655390095ccad'];
		} else {
			$ab_testing_page_b = get_field( 'ab_testing_page_b', $post_id );
		}
		if ( isset( $_POST['acf']['field_65526a950c76d'] ) ) {
			$ab_ga4_event_name = $_POST['acf']['field_65526a950c76d'];
		} else {
			$ab_ga4_event_name = get_field( 'ab_ga4_event_name', $post_id );
		}
		if ( $current_post_status == 'publish' ) {
			if ( $ab_testing_enabled == 1 ) {
				update_post_meta( $ab_testing_page_a[0], 'ab_ga4_event_name', $ab_ga4_event_name, false );
				update_post_meta( $ab_testing_page_a[0], 'ab_testing_page_a', $ab_testing_page_a[0], false );
				update_post_meta( $ab_testing_page_a[0], 'ab_testing_page_b', $ab_testing_page_b[0], false );
				update_post_meta( $ab_testing_page_a[0], 'ab_testing_manage', $post_id, false );
				update_post_meta( $ab_testing_page_b[0], 'ab_ga4_event_name', $ab_ga4_event_name, false );
				update_post_meta( $ab_testing_page_b[0], 'ab_testing_page_a', $ab_testing_page_a[0], false );
				update_post_meta( $ab_testing_page_b[0], 'ab_testing_page_b', $ab_testing_page_b[0], false );
				update_post_meta( $ab_testing_page_b[0], 'ab_testing_manage', $post_id, false );
			} else {
				delete_post_meta( $ab_testing_page_a[0], 'ab_ga4_event_name' );
				delete_post_meta( $ab_testing_page_a[0], 'ab_testing_page_a' );
				delete_post_meta( $ab_testing_page_a[0], 'ab_testing_page_b' );
				delete_post_meta( $ab_testing_page_a[0], 'ab_testing_manage' );
				delete_post_meta( $ab_testing_page_b[0], 'ab_ga4_event_name' );
				delete_post_meta( $ab_testing_page_b[0], 'ab_testing_page_a' );
				delete_post_meta( $ab_testing_page_b[0], 'ab_testing_page_b' );
				delete_post_meta( $ab_testing_page_b[0], 'ab_testing_manage' );
			}
		} else {
			delete_post_meta( $ab_testing_page_a[0], 'ab_ga4_event_name' );
			delete_post_meta( $ab_testing_page_a[0], 'ab_testing_page_a' );
			delete_post_meta( $ab_testing_page_a[0], 'ab_testing_page_b' );
			delete_post_meta( $ab_testing_page_a[0], 'ab_testing_manage' );
			delete_post_meta( $ab_testing_page_b[0], 'ab_ga4_event_name' );
			delete_post_meta( $ab_testing_page_b[0], 'ab_testing_page_a' );
			delete_post_meta( $ab_testing_page_b[0], 'ab_testing_page_b' );
			delete_post_meta( $ab_testing_page_b[0], 'ab_testing_manage' );
		}
	}
}

function paperplane_remove_ab_test_data( $post_id ) {
	global $post;
	if ( 'cpt_abtest' == $post->post_type ) {
		if ( isset( $_POST['acf']['field_655243c223ad5'] ) ) {
			$ab_testing_page_a = $_POST['acf']['field_655243c223ad5'];
		} else {
			$ab_testing_page_a = get_field( 'ab_testing_page_a', $post_id );
		}
		if ( isset( $_POST['acf']['field_655390095ccad'] ) ) {
			$ab_testing_page_b = $_POST['acf']['field_655390095ccad'];
		} else {
			$ab_testing_page_b = get_field( 'ab_testing_page_b', $post_id );
		}
		delete_post_meta( $ab_testing_page_a[0], 'ab_ga4_event_name' );
		delete_post_meta( $ab_testing_page_a[0], 'ab_testing_page_a' );
		delete_post_meta( $ab_testing_page_a[0], 'ab_testing_page_b' );
		delete_post_meta( $ab_testing_page_a[0], 'ab_testing_manage' );
		delete_post_meta( $ab_testing_page_b[0], 'ab_ga4_event_name' );
		delete_post_meta( $ab_testing_page_b[0], 'ab_testing_page_a' );
		delete_post_meta( $ab_testing_page_b[0], 'ab_testing_page_b' );
		delete_post_meta( $ab_testing_page_b[0], 'ab_testing_manage' );
	}
}






add_action( 'acf/save_post', 'paperplane_manage_ab_test_data', 1 );
add_action( 'wp_trash_post', 'paperplane_remove_ab_test_data', 1 );
add_action( 'delete_post', 'paperplane_remove_ab_test_data', 1 );