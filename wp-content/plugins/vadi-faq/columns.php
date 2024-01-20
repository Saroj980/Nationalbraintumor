<?php

function vadi_faq_change_columns( $cols ) {
  $cols = array(
    'cb' => '<input type="checkbox" />',
    "title" => "Post Title",
    "category" => "Categories",
    "faq_order" => "Faq Order",
    "date" => "Date",
  );
  return $cols;
}
add_filter( "manage_vadi_faq_posts_columns", "vadi_faq_change_columns" );
function vadi_faq_columns( $column, $post_id ) { 
  switch ( $column ) {
    case "faq_order":
    echo $orders =  get_post_meta($post_id, 'faq_order', true);
    break;
    case "category":
/* Get the genres for the post. */
        $terms = get_the_terms( $post_id, 'vadi_faq_cat' );

        /* If terms were found. */
        if ( !empty( $terms ) ) {

            $out = array();

            /* Loop through each term, linking to the 'edit posts' page for the specific term. */
            foreach ( $terms as $term ) {
                $out[] =$term->name;
            }

            /* Join the terms, separating them with a comma. */
            echo join( ', ', $out );
        }

        /* If no terms were found, output a default message. */
        else {
            _e( 'No Articles' );
        }    break;
  }
}
add_action( "manage_posts_custom_column", "vadi_faq_columns", 10, 2 );

add_action('quick_edit_custom_box',  'vadi_faq_quickedit', 10, 2);
 
function vadi_faq_quickedit($column_name, $post_type) { echo $post_id;
    if ($column_name != 'faq_order') return;
    ?>
    <fieldset class="inline-edit-col-left">
        <div class="inline-edit-col">
            <span class="title">Faq Order</span>
            <input id="order_nonce" type="hidden" name="order_nonce" value="" />
            <input id="faq_orderid" type="text" name="faq_order" value=""/>
        </div>
    </fieldset>
     <?php
}

add_action('save_post', 'vadi_faq_quickedit_data');   
 
function vadi_faq_quickedit_data($post_id) {     
  // verify if this is an auto save routine.         
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )          
      return $post_id;         
  // Check permissions     
  if ( 'vad_faq' == $_POST['post_type'] ) {         
    if ( !current_user_can( 'edit_page', $post_id ) )             
      return $post_id;     
  } else {         
    if ( !current_user_can( 'edit_post', $post_id ) )         
    return $post_id;     
  }        
  // Authentication passed now we save the data       
  if (isset($_POST['faq_order']) && ($post->post_type != 'vadi_faq')) {
        $my_fieldvalue = esc_attr($_POST['faq_order']);
        if ($my_fieldvalue)
            update_post_meta( $post_id, 'faq_order', $my_fieldvalue);
        else
            delete_post_meta( $post_id, 'faq_order');
    }
    return $my_fieldvalue;
}





add_action('admin_footer', 'vadi_faq_quickedit_javascript');
 
function vadi_faq_quickedit_javascript() {
    global $current_screen;
    if (($current_screen->post_type != 'vadi_faq')) return;
 
    ?>
<script type="text/javascript">
function vadi_faq_field_value(fieldValue, nonce) {
        // refresh the quick menu properly
        inlineEditPost.revert();
        console.log(fieldValue);
        jQuery('#faq_orderid').val(fieldValue);
}
</script>
 <?php 
}

add_filter('post_row_actions', 'vadi_faq_quickedit_link', 10, 2);   
function vadi_faq_quickedit_link($actions, $post) {     
    global $current_screen;     
    if (($current_screen->post_type != 'vadi_faq')) 
        return $actions;
    $nonce = wp_create_nonce( 'faq_order'.$post->ID);
    $vadi_faq_order = get_post_meta( $post->ID, 'faq_order', TRUE);
    $actions['inline hide-if-no-js'] = '<a href="#" class="editinline" title="';     
    $actions['inline hide-if-no-js'] .= esc_attr( __( 'Edit this item inline' ) ) . '"';
    $actions['inline hide-if-no-js'] .= " onclick=\"vadi_faq_field_value('{$vadi_faq_order}')\" >";
    $actions['inline hide-if-no-js'] .= __( 'Quick Edit' );
    $actions['inline hide-if-no-js'] .= '</a>';
    return $actions;
}



// Manage Category Shortcode Columns
add_filter("manage_vadi_faq_cat_custom_column", 'vadi_faq_cat_columns', 10, 3);
add_filter("manage_edit-vadi_faq_cat_columns", 'vadi_faq_cat_manage_columns'); 
 
function vadi_faq_cat_manage_columns($theme_columns) {
    $new_columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Name'),
            'faq_category_shortcode' => __( 'FAQ Category Shortcode', 'vadi-faq' ),
            'slug' => __('Slug'),
            'posts' => __('Posts')
        );
    return $new_columns;

}


function vadi_faq_cat_columns($out, $column_name, $theme_id) {
    $theme = get_term($theme_id, 'vadi_faq_cat');
    switch ($column_name) {
        
        case 'title':
            echo get_the_title();
        break;

        case 'faq_category_shortcode':             
             echo '[vadi_faq category="' . $theme_id. '"]';
        break;
 
        default:
            break;
    }
    return $out;    
}

?>
