<?php
/**
 * Output a list of EDD's terms (with links) from the 'download_category' taxonomy
*/
function mayosis_edd_grid_terms() { 
	$taxonomy = 'download_category'; // EDD's taxonomy for categories
	$terms = get_terms( $taxonomy ); // get the terms from EDD's download_category taxonomy
?>

<div class="grid--download--categories">
<?php foreach ( $terms as $term ) : ?>
<?php $category_grid_image = get_term_meta( $term->term_id, 'category_image_main', true); ?>
	
		<a href="<?php echo esc_attr( get_term_link( $term, $taxonomy ) ); ?>" title="<?php echo $term->name; ?>" style="background:url(<?php echo $category_grid_image; ?>)" class="cat--grid--main"><span><?php echo $term->name; ?></span></a>

<?php endforeach; ?>
</div>

<?php }