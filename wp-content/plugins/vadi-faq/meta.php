<?php

function vadi_faq_order_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function vadi_faq_order_add_meta_box() {
	add_meta_box(
		'faq_order',
		__( 'Faq Order', 'vadi_faq' ),
		'vadi_faq_order_html',
		'vadi_faq',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'vadi_faq_order_add_meta_box' );

function vadi_faq_order_html( $post) {
	wp_nonce_field( '_order_nonce', 'order_nonce' ); ?>
	<p>
		<label for="order_order"><?php _e( 'Order', 'faq_order' ); ?></label><br>
		<input type="text" name="faq_order" id="faq_order" value="<?php echo vadi_faq_order_get_meta( 'faq_order' ); ?>">
	</p><?php
}

function vadi_faq_order_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['order_nonce'] ) || ! wp_verify_nonce( $_POST['order_nonce'], '_order_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['faq_order'] ) )
		update_post_meta( $post_id, 'faq_order', esc_attr( $_POST['faq_order'] ) );
}
add_action( 'save_post', 'vadi_faq_order_save' );








?>