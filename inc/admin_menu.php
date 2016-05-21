<?php
if(! function_exists('add_action')){
    die('Silence is golden');
}

//main menu page registering
function gmapl_admin_menu(){
    add_menu_page('gMaps', __('gMaps','gmapsl'), 'manage_options', 'gmaps-settings-page', 'gmaps_admin_page', 'dashicons-dashboard');
}
//main menu page registering callback fn
function gmaps_admin_page(){
    global $wpdb;
    wp_enqueue_script( 'gmapsl_admin_script' );

    ?>
    <h1>Sup, brothers!</h1>
    <pre>
    <?
    echo GMAPSL_PLUGIN_DIR . '\inc\activate.php';
    //print_r($wpdb);


    //lets output table of maps
    if (!isset($_GET['action'])){
        gmaps_table_of_maps();
    }


}

//lets output table of maps
function gmaps_table_of_maps(){
    global $wpdb;
    global $gmapsl_maps_table;
    global $gmapsl_markers_table;


    $maps = $wpdb->get_results(
        "
	SELECT `id`,`map_title`, `map_type`, `active`
	FROM $gmapsl_maps_table
        ORDER BY `id` DESC
	"
    );

    ?>
    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <tr>
                <th>ID</th>
                <th>map_title</th>
                <th>map_type</th>
                <th>active</th>
            </tr>
        </thead>
        <tbody>
    <?
    if (!empty($maps)){
        foreach ($maps as $map){
            ?>
            <tr>
                <td><?=$map->id?></td>
                <td><?=$map->map_title?><div><a href="?page=gmaps-settings-page&action=edit&map_id=<?=$map->id?>">Edit</a></div></td>
                <td><?=$map->map_type?></td>

                <td><div class="toggle-btn <?
                    if (gmapsl_checkbox_from_db($map->active)=='on'){
                        echo "active";
                    }
                ?>">
                    <input type="checkbox" <?checked(gmapsl_checkbox_from_db($map->active),'on')?> class="cb-value" />
                    <span class="round-btn"></span>
                </div></td>
            </tr>

            <?
        }
    }
    ?>
        </tbody>
    </table>
    <?










    //print_r($results);


}


