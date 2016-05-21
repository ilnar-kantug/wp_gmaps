<?php


//ajax query for 'active' parameter of a map table

if (defined('DOING_AJAX') && DOING_AJAX) {
    add_action('wp_ajax_gmapsl_change_active', 'gmapsl_ajax_change_active');
}

function gmapsl_ajax_change_active()
{
    global $wpdb;
    global $gmapsl_maps_table;
    $nonce = $_POST['security_nonce'];
    $active = $_POST['active'];
    $map_id = $_POST['map_id'];

    if (!wp_verify_nonce($nonce, 'gmapsl_ajax_security')) {
        wp_die(__('Something went wrong.', 'gmapsl'));
    }
    if (!current_user_can('manage_options')) {
        wp_die(__('Something went wrong.', 'gmapsl'));
    }

    if ($active == 1 || $active == 0) {
        $sql = $wpdb->update(
            $gmapsl_maps_table,
            array('active' => $active),
            array('id' => $map_id),
            array('%d'),
            array('%d')
        );
        if($sql){
            
            if($active == 1){
                echo __('Your map is active now', 'gmapsl');
            }else{
                echo __('Your map is not active now', 'gmapsl');
            }

        }else{
            echo __('Something went wrong.', 'gmapsl');
        }

    } else {
        wp_die(__('Something went wrong.', 'gmapsl'));
    }


    die();
}





