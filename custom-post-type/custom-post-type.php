<?php
/**
 * Plugin Name: Custom Post Type
 * Plugin URI: #
 * Description: Custom Post Type
 * Version: 1.0
 * Author: Anisur Rahman
 * Author URI: https://github.com/anisur2805
 */
defined( 'ABSPATH' ) or die();

// register book post type
function custom_post_type() {
	$labels = array(
		'name'               => _x( 'Books', 'Post type general name', 'book' ),
		'singular_name'      => _x( 'Book', 'Post type singular name', 'book' ),
		'menu_name'          => _x( 'Books', 'Admin Menu text', 'book' ),
		'name_admin_bar'     => _x( 'Book', 'Add New on Toolbar', 'book' ),
		'add_new'            => __( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Book', 'book' ),
		'new_item'           => __( 'New Book', 'book' ),
		'edit_item'          => __( 'Edit Book', 'book' ),
		'view_item'          => __( 'View Book', 'book' ),
		'all_items'          => __( 'All Books', 'book' ),
		'search_items'       => __( 'Search Books', 'book' ),
		'parent_item_colon'  => __( 'Parent Books:', 'book' ),
		'not_found'          => __( 'No books found.', 'book' ),
		'not_found_in_trash' => __( 'No books found in Trash.', 'book' ),
		'featured_image'     => _x( 'Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'book' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'book' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
	);

	register_post_type( 'book', $args );
}

add_action( 'init', 'custom_post_type' );

// Register meta box(es).
function wpdocs_register_meta_boxes() {
	add_meta_box( 'book-meta-box-id', __( 'Book Information', 'book' ), 'book_metabox_callback', 'book' );
}

add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );

function book_metabox_callback( $post ) {
	wp_nonce_field( 'book_nonce_action', 'book_nonce' );
	?>
    <div class="book-info">
		<?php $book_author = get_post_meta( $post->ID, '_book_author', true ); ?>
        <div class="form_field half">
            <label for="book_author">
				<?php _e( 'Book Author', 'book' ); ?>
            </label>
            <input type="text" id="book_author" name="book_author" value="<?php echo esc_attr( $book_author ); ?>"
                   size="25"/>
        </div>

		<?php $book_author_gender = get_post_meta( $post->ID, '_book_author_gender', true ); ?>
        <div class="form_field half">
            <label for="book_author_gender">
				<?php _e( 'Book Author Gender', 'book' ); ?>
            </label>
            <input type="radio" name="book_author_gender"
                   value="male" <?php checked( $book_author_gender, 'male' ); ?> > Male
            <input type="radio" name="book_author_gender"
                   value="female" <?php checked( $book_author_gender, 'female' ); ?> > Female

        </div>

		<?php
		$author_checkbox_get_meta = get_post_meta( $post->ID );
		?>
        <div class="form_field">
            <label for="author_checkbox">Author Checkbox</label>
            <input type="checkbox" name="author_checkbox" id="author_checkbox"
                   value="yes" <?php if ( isset ( $author_checkbox_get_meta['author_checkbox'] ) ) {
				checked( $author_checkbox_get_meta['author_checkbox'][0], 'yes' );
			} ?> />
        </div>

		<?php $book_author_bio = get_post_meta( $post->ID, '_book_author_bio', true ); ?>
        <div class="form_field">
            <label for="book_author_bio">
				<?php _e( 'Book Author Bio', 'book' ); ?>
            </label>
            <textarea name="book_author_bio" id="book_author_bio"
                      style="width: 100%;"><?php echo esc_attr( $book_author_bio ); ?></textarea>
        </div>

		<?php $book_rating = get_post_meta( $post->ID, '_book_rating', true ); ?>
        <div class="form_field">
            <label for="book_rating">Description for this field</label>
            <select name="book_rating" id="book_rating" class="postbox">
                <option value="">Select something...</option>
                <option value="one" <?php selected( $book_rating, 'one' ); ?>>Something
                </option>
                <option value="two" <?php selected( $book_rating, 'two' ); ?>>Two
                </option>
                <option value="three" <?php selected( $book_rating, 'three' ); ?>>Three
                </option>
            </select>
        </div>

    </div>

	<?php
}

function book_save_meta_box( $post_id ) {
	// Check if our nonce is set.
	if ( ! isset( $_POST['book_nonce'] ) ) {
		return $post_id;
	}

	$nonce = $_POST['book_nonce'];

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'book_nonce_action' ) ) {
		return $post_id;
	}

	/*
	 * If this is an autosave, our form has not been submitted,
	 * so we don't want to do anything.
	 */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return $post_id;
	}

	// Check the user's permissions.
	if ( 'post' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	}

	// Sanitize the user input Update the meta field.
	$book_author_data = sanitize_text_field( $_POST['book_author'] );
	update_post_meta( $post_id, '_book_author', $book_author_data );
	$book_author_bio_data = sanitize_text_field( $_POST['book_author_bio'] );
	update_post_meta( $post_id, '_book_author_bio', $book_author_bio_data );

	// Sanitize user input.
	$book_author_gender_data = ( isset( $_POST['book_author_gender'] ) ? sanitize_html_class( $_POST['book_author_gender'] ) : '' );
	update_post_meta( $post_id, '_book_author_gender', $book_author_gender_data );


	if ( isset( $_POST['author_checkbox'] ) ) {
		update_post_meta( $post_id, 'author_checkbox', 'yes' );
	} else {
		update_post_meta( $post_id, 'author_checkbox', 'no' );
	}

	if ( isset( $_POST['book_rating'] ) ) {
		update_post_meta( $post_id, '_book_rating', $_POST['book_rating'] );
	}


}

add_action( 'save_post', 'book_save_meta_box' );

?>

    <style>
        label {
            display: block;
            margin-bottom: 10px;
        }

        .form_field {
            margin-bottom: 10px;
        }
    </style>
