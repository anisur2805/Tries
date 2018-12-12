<?php
function artshortcode_shortcode_wrapper($atts, $content = null) {
	// Attributes
	$atts = shortcode_atts(
		array(
			'view'	=> 'carousel',
		),
		$atts,
		'art-wrapper'
	);
	// Attributes in var
	$view = $atts['carousel'];
	?>
	<div class="artestimonials">
		<?php echo do_shortcode( $content ); ?>
		
		<?php
		
	}
	add_shortcode( 'art-wrapper', 'artshortcode_shortcode_wrapper' );
	function artshortcode_shortcode($atts, $content = null) {
	// Attributes
		$atts = shortcode_atts(
			array(
				'name' => 'afd',
				'thumb' => 'http://localhost/wordpress/wp-content/uploads/2018/12/Screenshot_2.png',
			),
			$atts,
			'arctestimonial'
		);
	// Attributes in var
		$name = $atts['name'];
		$thumb = $atts['thumb'];
	// Your Code
		?>
		<div class="owl-carousel owl-theme arc-testimonial-wrapper">
			<div class="art-thumb">
				<img src="<?php echo $thumb; ?>" alt="">
			</div>
			<div class="art-content">
				<div class="item">
					<p><?php echo do_shortcode($content) ?></p>
					<p><strong><?php echo $name; ?></strong></p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php

}
add_shortcode( 'arctestimonial', 'artshortcode_shortcode' );