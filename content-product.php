<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}


$image_src = null;
$terms = get_the_terms( $post->ID, 'product_cat' );
if( count( $terms ) > 0 ) {
	$term_id = $terms[0]->term_id;
	$thumbnail_id =  get_term_meta( $term_id, 'thumbnail_id', true );
	$image_src = wp_get_attachment_url( $thumbnail_id );
}




?>


<style>
	<?php include_once 'css/content-product.css' ?>
</style>

<li <?php wc_product_class( '', $product ); ?>>
	
	<div class="row-list">
		<div class="sub-row">
			<div class="image-product">
				<div class="title-product">
					<?php do_action( 'woocommerce_shop_loop_item_title' ); ?><br/>
					<small class="mobile" style="margin-left: 5px; font-size: 80%;">(<?= get_the_terms( $post->ID, 'product_cat' )[0]->name; ?>)</small>
				</div>
				<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
			</div>
			<div class="details-product desktop">
				
				<p><?= get_the_terms( $post->ID, 'product_cat' )[0]->name; ?></p>
				<?php if($image_src): ?>
					<img class="desktop" src="<?= $image_src ?>" />
				<?php else: ?>
					<span class="dashicons dashicons-editor-help" style="font-size: 50px; width: 50px;"></span> 
				<?php endif;?>
				<span>
					<span class="dashicons dashicons-location"></span> Location
				</span>

			</div>
		</div>
		<div class="sub-row">
			<div class="price-product desktop">
				<?php 
					do_action( 'woocommerce_after_shop_loop_item_title' );
				?>
				<span
					class="uwa-main-auction-product uwa_auction_product_countdown"
					data-time="<?= esc_attr($product->get_woo_ua_remaining_seconds()) ?>" 
					data-auction-id="<?= esc_attr($product->get_id()); ?>" 
					data-format="<?= esc_attr(get_option('woo_ua_auctions_countdown_format')) ?>">
				</span>
			</div>
			<div class="action-product">
				<div style="text-align:center; width: 100%;">
				<?php if( $product->product_type === 'auction' )  : ?>
						<div class="desktop">
							<b>Pujas</b><br> <?=count( $product->woo_ua_auction_history() )?>
						</div>
						<div class="mobile" style="width: 100%; justify-content: space-evenly;">
							<b>Pujas: </b>
							<i style="left:10px;"><?=count( $product->woo_ua_auction_history() )?></i>
						</div>
						<span
							class="uwa-main-auction-product uwa_auction_product_countdown mobile"
							style="margin: 0; font-size: 50%;"
							data-time="<?= esc_attr($product->get_woo_ua_remaining_seconds()) ?>" 
							data-auction-id="<?= esc_attr($product->get_id()); ?>" 
							data-format="<?= esc_attr(get_option('woo_ua_auctions_countdown_format')) ?>">
						</span>
				<?php endif; ?>
				</div>
				<span>
					<?php	do_action( 'woocommerce_after_shop_loop_item' ); ?>
				</span>
			</div>
		</div>
	</div>
	
</li>
