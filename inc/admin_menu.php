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
    ?>
    </pre>
    <?

    //lets output table of maps
    if (!isset($_GET['action'])){
        gmaps_table_of_maps();
    }elseif ($_GET['action'] == 'edit' AND isset($_GET['map_id'])){
        wp_enqueue_script( 'jquery-ui-tabs' );
        gmaps_map_edit_page();
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
                <th><?=_x('ID','admin table page','gmapsl')?></th>
                <th><?=_x('map_title','admin table page','gmapsl')?></th>
                <th><?=_x('shortcode','admin table page','gmapsl')?></th>
                <th><?=_x('map_type','admin table page','gmapsl')?></th>
                <th><?=_x('active','admin table page','gmapsl')?></th>
            </tr>
        </thead>
        <tbody>
    <?
    if (!empty($maps)){
        $i=1;
        foreach ($maps as $map){
            ?>
            <tr>
                <td><?=$map->id?></td>
                <td><?=$map->map_title?><div><a href="?page=gmaps-settings-page&action=edit&map_id=<?=$map->id?>"><?=_x('Edit','admin table page','gmapsl')?></a></div></td>
                <td><span onclick="resmap_selectText('shortcode_id_<?=$map->id?>')" id="shortcode_id_<?=$map->id?>" class="gmapsl_shortcodes">[gmapsl-map-<?=$map->id?>]</span></td>
                <td><?=$map->map_type?></td>

                <td><div id="gmapsl-div-<?=$i?>" class="gmapsl-toggle <?
                    if (gmapsl_checkbox_from_db($map->active)=='on'){
                        echo 'active';
                    }
                ?>" data-toajax="<?
                    if (gmapsl_checkbox_from_db($map->active)=='on'){
                        echo '1';
                    }else{
                        echo '0';
                    }
                ?>">
                    <input type="checkbox" id="gmapsl-checkbox-<?=$i?>" onclick="gmapsl_change_active('<?=wp_create_nonce('gmapsl_ajax_security')?>', <?=$i?>,<?=$map->id?>)" <?checked(gmapsl_checkbox_from_db($map->active),'on')?> class="gmapsl-value" />
                    <span class="clicker-btn"></span>
                </div></td>
            </tr>

            <?
            $i++;
        }
    }
    ?>
        </tbody>
    </table>
    <div id="silentPopUp"><div id="silentPopUpText"></div><span></span></div><div id="silentPopUpOverlay"></div>
    <?

}

//lets output map edit page
function gmaps_map_edit_page(){
    ?>
    <div id="gmaps_tabs">
      <ul>
        <li><a href="#fragment-1">One</a></li>
        <li><a href="#fragment-2">Two</a></li>
        <li><a href="#fragment-3">Three</a></li>
      </ul>
      <div id="fragment-1">
        1111Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
      </div><div id="fragment-2">
        2222Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
      </div><div id="fragment-3">
        3333Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
      </div>
    </div>
    
    <?

}

















