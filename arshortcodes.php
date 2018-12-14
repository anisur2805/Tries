<?php
function artshortcode_shortcode_wrapper($atts, $content = null) {
	ob_start();
	?>
	<div class="parent">
		<div class="artestimonials owl-theme arc-testimonial-wrapper owl-carousel">
			<?php echo do_shortcode(wp_strip_all_tags($content)); ?>
		</div>
	</div>
	<?php
	$output = ob_get_clean();
	return $output; 
}
add_shortcode( 'artestimonial_wrapper', 'artshortcode_shortcode_wrapper' );
function artshortcode_shortcode($atts, $content = null) {
	$atts = shortcode_atts(
		array(
			'name' => '',
			'thumb' => '[home_url]/wp-content/uploads/2018/08/T1_-150x150.jpg',
		),
		$atts,
		'artestimonial'
	);
	$name = $atts['name'];
	$thumb = $atts['thumb']; ?>
	<div class="item">
		<div class="art-thumb">
			<?php if(!empty($thumb)) { 
				echo '<img src=" '. $thumb .' " alt="">';
			} ?>
		</div>
		<div class="art-content">
			<p class="arcontent"><?php echo wp_strip_all_tags($content); // escape all html tag ?></p>
			<p class="arname"><strong><?php echo wp_strip_all_tags($name); ?></strong></p>
		</div>
	</div>
	<?php
}
add_shortcode( 'artestimonial', 'artshortcode_shortcode' );
