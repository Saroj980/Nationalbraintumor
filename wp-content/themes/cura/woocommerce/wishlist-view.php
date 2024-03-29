<?php
/**
 * Wishlist page template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 7.0.1
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>

<form id="yith-wcwl-form" action="<?php echo esc_url( $form_action ); ?>" method="post" class="woocommerce">

	<?php wp_nonce_field( 'yith-wcwl-form', 'yith_wcwl_form_nonce' ); ?>

	<?php do_action( 'yith_wcwl_before_wishlist', $wishlist_meta ); ?>

	<!-- WISHLIST TABLE -->
	<table class="shop_table cart wishlist_table" data-pagination="<?php echo esc_attr( $pagination ); ?>" data-per-page="<?php echo esc_attr( $per_page ); ?>" data-page="<?php echo esc_attr( $current_page ); ?>" data-id="<?php echo esc_attr( $wishlist_id ); ?>" data-token="<?php echo esc_attr( $wishlist_token ); ?>">

		<?php $column_count = 2; ?>

		<thead>
		<tr>
			<?php if ( $show_cb ) : ?>
				<th class="product-checkbox">
					<input type="checkbox" value="" name="" id="bulk_add_to_cart"/>
				</th>
				<?php
				$column_count ++;
			endif;
			?>
			<?php if ( $is_user_owner ) : ?>
				<th class="product-remove"></th>
				<?php
				$column_count ++;
			endif;
			?>
			<th class="product-thumbnail"></th>
			<th class="product-name">
				<span class="nobr"><?php echo apply_filters( 'yith_wcwl_wishlist_view_name_heading', __( 'Product Name', 'cura' ) ); ?></span>
			</th>
			<th class="product-price">
				<span class="nobr">
					<?php echo apply_filters( 'yith_wcwl_wishlist_view_price_heading', __( 'Unit Price', 'cura' ) ); ?>
				</span>
			</th>
			<?php $column_count ++; ?>
			<th class="product-stock-status">
				<span class="nobr">
					<?php echo apply_filters( 'yith_wcwl_wishlist_view_stock_heading', __( 'Stock Status', 'cura' ) ); ?>
				</span>
			</th>
			<?php $column_count ++; ?>
			<th class="product-add-to-cart"></th>
			<?php $column_count ++; ?>
		</tr>
		</thead>
		<tbody>
		<?php
		if ( count( $wishlist_items ) > 0 ) :
			$added_items = array();
			foreach ( $wishlist_items as $item ) :
				global $product;

				$item['prod_id'] = yit_wpml_object_id( $item['prod_id'], 'product', true );

				if ( in_array( $item['prod_id'], $added_items ) ) {
					continue;
				}

				$added_items[] = $item['prod_id'];
				$product       = wc_get_product( $item['prod_id'] );
				$availability  = $product->get_availability();
				$stock_status  = isset( $availability['class'] ) ? $availability['class'] : false;

				if ( $product && $product->exists() ) :
					?>
					<tr id="yith-wcwl-row-<?php echo esc_textarea( $item['prod_id'] ); ?>" data-row-id="<?php echo esc_textarea( $item['prod_id'] ); ?>">
						<?php if ( $show_cb ) : ?>
							<td class="product-checkbox">
								<input type="checkbox" value="<?php echo esc_attr( $item['prod_id'] ); ?>" name="add_to_cart[]" <?php echo ( ! $product->is_type( 'simple' ) ) ? 'disabled="disabled"' : ''; ?>/>
							</td>
						<?php endif ?>

						<?php if ( $is_user_owner ) : ?>
						<td class="product-remove">
							<div>
								<a href="<?php echo esc_url( add_query_arg( 'remove_from_wishlist', $item['prod_id'] ) ); ?>" class="remove remove_from_wishlist" title="<?php echo apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'cura' ) ); ?>"><span class="ti-close"></span></a>
							</div>
						</td>
						<?php endif; ?>

						<td class="product-thumbnail">
							<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item['prod_id'] ) ) ); ?>">
								<?php echo wp_kses( $product->get_image(), 'rt-content' ); ?>
							</a>
						</td>

						<td class="product-name">
							<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item['prod_id'] ) ) ); ?>"><?php echo apply_filters( 'woocommerce_in_cartproduct_obj_title', $product->get_title(), $product ); ?></a>
							<?php do_action( 'yith_wcwl_table_after_product_name', $item ); ?>
						</td>
						<td class="product-price">
							<?php
							$base_product = $product->is_type( 'variable' ) ? $product->get_variation_regular_price( 'max' ) : $product->get_price();
							echo wp_kses( $base_product ? $product->get_price_html() : apply_filters( 'yith_free_text', __( 'Free!', 'cura' ), $product ), 'rt-content' );
							?>
						</td>
						<td class="product-stock-status">
							<?php echo wp_kses( $stock_status == 'out-of-stock' ? '<span class="wishlist-out-of-stock">' . __( 'Out of Stock', 'cura' ) . '</span>' : '<span class="wishlist-in-stock">' . __( 'In Stock', 'cura' ) . '</span>', 'rt-content' ); ?>
						</td>
						<td class="product-add-to-cart">
							<!-- Add to cart button -->
							<?php woocommerce_template_loop_add_to_cart(); ?>
							<!-- Change wishlist -->
							<?php if ( $available_multi_wishlist && is_user_logged_in() && count( $users_wishlists ) > 1 && $move_to_another_wishlist && $is_user_owner ) : ?>
							<select class="change-wishlist selectBox">
								<option value=""><?php esc_html_e( 'Move', 'cura' ); ?></option>
								<?php
								foreach ( $users_wishlists as $wl ) :
									if ( $wl['wishlist_token'] == $wishlist_meta['wishlist_token'] ) {
										continue;
									}
									?>
									<option value="<?php echo esc_attr( $wl['wishlist_token'] ); ?>">
										<?php
										$wl_title = ! empty( $wl['wishlist_name'] ) ? esc_html( $wl['wishlist_name'] ) : esc_html( $default_wishlsit_title );
										if ( $wl['wishlist_privacy'] == 1 ) {
											$wl_privacy = __( 'Shared', 'cura' );
										} elseif ( $wl['wishlist_privacy'] == 2 ) {
											$wl_privacy = __( 'Private', 'cura' );
										} else {
											$wl_privacy = __( 'Public', 'cura' );
										}
										echo sprintf( '%s - %s', $wl_title, $wl_privacy );
										?>
									</option>
									<?php
								endforeach;
								?>
							</select>
							<!-- Remove from wishlist -->
								<?php if ( $is_user_owner && $repeat_remove_button ) : ?>
									<a href="<?php echo esc_url( add_query_arg( 'remove_from_wishlist', $item['prod_id'] ) ); ?>" class="remove_from_wishlist button" title="<?php echo apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'cura' ) ); ?>"><?php esc_html_e( 'Remove', 'cura' ); ?></a>
								<?php endif; ?>
						</td>
					<?php endif; ?>
					</tr>
					<?php
				endif;
			endforeach;
		else :
			?>
			<tr>
				<td colspan="<?php echo esc_attr( $column_count ); ?>" class="wishlist-empty"><?php echo apply_filters( 'yith_wcwl_no_product_to_remove_message', __( 'No products were added to the wishlist', 'cura' ) ); ?></td>
			</tr>
			<?php
		endif;

		if ( ! empty( $page_links ) ) :
			?>
			<tr class="pagination-row">
				<td colspan="<?php echo esc_attr( $column_count ); ?>"><?php echo wp_kses( $page_links, 'rt-content' ); ?></td>
			</tr>
		<?php endif ?>
		</tbody>

	</table>

	<?php wp_nonce_field( 'yith_wcwl_edit_wishlist_action', 'yith_wcwl_edit_wishlist' ); ?>

	<?php if ( ! $is_default ) : ?>
		<input type="hidden" value="<?php echo esc_attr( $wishlist_token ); ?>" name="wishlist_id" id="wishlist_id">
	<?php endif; ?>

	<?php do_action( 'yith_wcwl_after_wishlist', $wishlist_meta ); ?>

</form>

<?php do_action( 'yith_wcwl_after_wishlist_form', $wishlist_meta ); ?>

<?php if ( $show_ask_estimate_button && ( ! is_user_logged_in() || $additional_info ) ) : ?>
	<div id="ask_an_estimate_popup">
		<form action="<?php echo esc_url( $ask_estimate_url ); ?>" method="post" class="wishlist-ask-an-estimate-popup">
			<?php if ( ! is_user_logged_in() ) : ?>
				<label for="reply_email"><?php echo apply_filters( 'yith_wcwl_ask_estimate_reply_mail_label', __( 'Your email', 'cura' ) ); ?></label>
				<input type="email" value="" name="reply_email" id="reply_email">
			<?php endif; ?>
			<?php if ( ! empty( $additional_info_label ) ) : ?>
				<label for="additional_notes"><?php echo esc_html( $additional_info_label ); ?></label>
			<?php endif; ?>
			<textarea id="additional_notes" name="additional_notes"></textarea>

			<button class="btn button ask-an-estimate-button ask-an-estimate-button-popup" >
				<?php echo apply_filters( 'yith_wcwl_ask_an_estimate_icon', '<i class="fa fa-shopping-cart"></i>' ); ?>
				<?php echo apply_filters( 'yith_wcwl_ask_an_estimate_text', __( 'Ask for an estimate', 'cura' ) ); ?>
			</button>
		</form>
	</div>
<?php endif; ?>
