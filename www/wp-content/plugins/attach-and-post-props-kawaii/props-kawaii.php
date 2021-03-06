<?php
/*
Plugin Name: Kawaii Attach and Post Properties
Plugin URI: https://kawaii-mobile.com/
Version: v1.00
Author: <a href="http://www.salkodev.com/">Andrew Salko</a>
Description: Additional attachment properties plugin for a <a href="https://kawaii-mobile.com">https://kawaii-mobile.com</a>
*/

// Based on: https://code.tutsplus.com/articles/how-to-add-custom-fields-to-attachments--wp-31100
//
class KawaiiAttachAndPostProperties
{
		private $media_fields = array();

		public function ApplyAttachFieldsToEdit( $form_fields, $post = null )
		{
			// If our fields array is not empty
		    if ( ! empty( $this->media_fields ) )
			{
		        // We browse our set of options
        		foreach ( $this->media_fields as $field => $values )
				{
            		// If the field matches the current attachment mime type
            		// and is not one of the exclusions
            		if ( preg_match( "/" . $values['application'] . "/", $post->post_mime_type) &&
						 ! in_array( $post->post_mime_type, $values['exclusions'] ) )
					{
                		// We get the already saved field meta value
                		$meta = get_post_meta( $post->ID, '_' . $field, true );


						// Checkbox type doesn't exist either
						$values['input'] = 'html';
						// Set the checkbox checked or not
						if ( $meta == 'on' )
						{
							$checked = ' checked="checked"';
						}
						else
						{
							$checked = '';
						}

						$html = '<input' . $checked . ' type="checkbox" name="attachments[' . $post->ID . '][' . $field . ']" id="attachments-' . $post->ID . '-' . $field . '" />';

						$values['html'] = $html;


		                // And set it to the field before building it
						$values['value'] = $meta;


		                // We add our field into the $form_fields array
                		$form_fields[$field] = $values;
            		}
        		}//foreach
    		}//if

	    	// We return the completed $form_fields array
    		return $form_fields;
	    }

    	function AttachSaveFields( $post, $attachment )
		{
     		// If our fields array is not empty
			 if ( ! empty( $this->media_fields ) )
			 {
        		// Browser those fields
				foreach ( $this->media_fields as $field => $values )
				{
            		// If this field has been submitted (is present in the $attachment variable)
					if ( isset( $attachment[$field] ) )
					{
                		// If submitted field is empty
                		// We add errors to the post object with the "error_text" parameter we set in the options
						if ( strlen( trim( $attachment[$field] ) ) == 0 )
						{
                    		$post['errors'][$field]['errors'][] = __( $values['error_text'] );
							// Otherwise we update the custom field
						}
						else
						{
							update_post_meta( $post['ID'], '_' . $field, $attachment[$field] );
						}
            		}
					else
					{	// Otherwise, we delete it if it already existed
                		delete_post_meta( $post['ID'], '_' . $field );
            		}
        		}//foreach
    		}//if

    		return $post;
		}

		function AddPostMetaBoxes()
		{
			// see https://developer.wordpress.org/reference/functions/add_meta_box for a full explanation of each property
			add_meta_box(
				"post_metadata_kawaii", // div id containing rendered fields
				"Kawaii Mobile additional properties", // section heading displayed as text
				array($this,"post_meta_box_callback"), // callback function to render fields
				"post" // name of post type on which to render fields (see: https://wp-kama.ru/function/add_meta_box)
			);
		}

		function SavePostMetaBoxes()
		{
			global $post;
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			{
				return;
			}

			if ( get_post_status( $post->ID ) === 'auto-draft' )
			{
				return;
			}


			if (isset($_POST['_DisableADSense'])) 	//isset returns true when checkbox checked
			{
		        update_post_meta($post->ID, '_DisableADSense', 'on');	//we save value 'on'
    		}
			else
			{
        		delete_post_meta($post->ID, '_DisableADSense');
		    }
		}

		function post_meta_box_callback($post, $meta)
		{
			$disableAds=$post->_DisableADSense;	//'on' - is true

			?>

	        <label><input type="checkbox" value="1" <?php checked($disableAds, 'on', true); ?> name="_DisableADSense" />Disable ADSense</label>

			<?php
		}

		function __construct( $fields )
		{
		    $this->media_fields = $fields;

		    add_filter( 'attachment_fields_to_edit', array( $this, 'ApplyAttachFieldsToEdit' ), 11, 2 );
			add_filter( 'attachment_fields_to_save', array( $this, 'AttachSaveFields' ), 11, 2 );

			//https://www.mugo.ca/Blog/Adding-complex-fields-to-WordPress-custom-post-types
			add_action( 'admin_init', array( $this, 'AddPostMetaBoxes'), 12, 3 );
			add_action( 'save_post', array( $this, 'SavePostMetaBoxes'), 12, 3 );
		}


}//class

$themename="kawaii-mobile-theme";
$attachments_options = array(

    'DisableADSense' => array(
        'label'       => __( 'Disable ADSense', $themename ),
        'input'       => 'checkbox',
        'application' => 'image',
        'exclusions'   => array( 'audio', 'video' ),
		'helps'       => __( 'If checked, disables ADSense', $themename ),
    	)
);


$pluginKawaiiInstance = new KawaiiAttachAndPostProperties( $attachments_options );
