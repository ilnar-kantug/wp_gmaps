<?php
if(! function_exists('add_action')){
    die('Silence is golden');
}





function gmapsl_activate()
{
    global $wpdb;
    global $gmapsl_maps_table;
    global $gmapsl_markers_table;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    $sql = "
          CREATE TABLE IF NOT EXISTS `" . $gmapsl_maps_table . "` (
          id INT(11) NOT NULL AUTO_INCREMENT,
          active INT(11) NOT NULL,
          map_title VARCHAR(255) NOT NULL,
          map_width VARCHAR(10) NOT NULL,
          map_height VARCHAR(10) NOT NULL,
          map_start_lat VARCHAR(255) NOT NULL,
          map_start_lng VARCHAR(255) NOT NULL,
          map_start_zoom INT(11) NOT NULL,
          map_type INT(11) NOT NULL,
          styling_enabled INT(11) NOT NULL,
          styling_json LONGTEXT NOT NULL,
          map_width_type VARCHAR(10) NOT NULL,
          map_height_type VARCHAR(10) NOT NULL,
          draggable INT(11) NOT NULL,
          fullscreen_control INT(11) NOT NULL,
          maptype_control INT(11) NOT NULL,
          scroll_wheel INT(11) NOT NULL,
          street_view_control INT(11) NOT NULL,
          zoom_control INT(11) NOT NULL,
          traffic_layer INT(11) NOT NULL,
          transit_layer INT(11) NOT NULL,
          bicycling_layer INT(11) NOT NULL,
          style_of_markers_listing INT(11) NOT NULL,
          has_street_view_box INT(11) NOT NULL,
          street_view_box_width INT(11) NOT NULL,
          order_markers_by VARCHAR(255) NOT NULL,
          PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
    ";

    dbDelta($sql);
    $sql = "
        CREATE TABLE IF NOT EXISTS `" . $gmapsl_markers_table . "` (
          id INT(11) NOT NULL AUTO_INCREMENT,
          map_id INT(11) NOT NULL,
          address TEXT NOT NULL,
          lat VARCHAR(255) NOT NULL,
          lng VARCHAR(255) NOT NULL,
          title VARCHAR(255) NOT NULL,
          desrc LONGTEXT NOT NULL,
          icon TEXT NOT NULL,
          pic TEXT NOT NULL,
          has_street_view INT(11) NOT NULL,
          street_view_heading INT(11) NOT NULL,
          street_view_pitch VARCHAR(255) NOT NULL,
          PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ";

    dbDelta($sql);


    //if there are no maps let's create a demo one
    gmapsl_check_if_no_data();

}


function gmapsl_deactivate()
{
    global $wpdb;
    global $gmapsl_maps_table;
    global $gmapsl_markers_table;


    $wpdb->query("DROP TABLE IF EXISTS $gmapsl_maps_table");
    $wpdb->query("DROP TABLE IF EXISTS $gmapsl_markers_table");
}

function gmapsl_check_if_no_data(){

    global $wpdb;
    global $gmapsl_maps_table;
    global $gmapsl_markers_table;

    $results = $wpdb->get_results(
        "
	SELECT `id`,`map_title`, `map_type`, `active`
	FROM $gmapsl_maps_table
        WHERE `active` = 1
        ORDER BY `id` DESC
	"
    );


    if (!$results) {
        $wpdb->insert($gmapsl_maps_table, array(
                "active" => "1",
                "map_title" => "Demo Map",
                "map_width" => "100",
                "map_height" => "400",
                "map_start_lat" => "55.83",
                "map_start_lng" => "49.06",
                "map_start_zoom" => "8",
                "map_type" => "1",
                "styling_enabled" => "1",
                "styling_json" => "[{\"featureType\": \"administrative\",\"elementType\": \"labels.text.fill\",\"stylers\": [{\"color\": \"#444444\"}]},{\"featureType\": \"landscape\",\"elementType\": \"all\",\"stylers\": [{\"color\": \"#f2f2f2\"}]},{\"featureType\": \"poi\",\"elementType\": \"all\",\"stylers\": [{\"visibility\": \"off\"}]},{\"featureType\": \"road\",\"elementType\": \"all\",\"stylers\": [{\"saturation\": -100},{\"lightness\": 45}]},{\"featureType\": \"road.highway\",\"elementType\": \"all\",\"stylers\": [{\"visibility\": \"simplified\"}]},{\"featureType\": \"road.arterial\",\"elementType\": \"labels.icon\",\"stylers\": [{\"visibility\": \"off\"}]},{\"featureType\": \"transit\",\"elementType\": \"all\",\"stylers\": [{\"visibility\": \"off\"}]},{\"featureType\": \"water\",\"elementType\": \"all\",\"stylers\": [{\"color\": \"#46bcec\"},{\"visibility\": \"on\"}]}]",
                "map_width_type" => "%",
                "map_height_type" => "px",
                "draggable" => "1",
                "fullscreen_control" => "1",
                "maptype_control" => "1",
                "scroll_wheel" => "1",
                "street_view_control" => "0",
                "zoom_control" => "1",
                "traffic_layer" => "1",
                "transit_layer" => "0",
                "bicycling_layer" => "0",
                "style_of_markers_listing" => "1",
                "has_street_view_box" => "1",
                "street_view_box_width" => "1",
                "order_markers_by" => "1",
            )
        );

        $wpdb->insert($gmapsl_maps_table, array(
                "active" => "1",
                "map_title" => "Demo Map 2",
                "map_width" => "100",
                "map_height" => "300",
                "map_start_lat" => "55.23",
                "map_start_lng" => "49.56",
                "map_start_zoom" => "7",
                "map_type" => "1",
                "styling_enabled" => "1",
                "styling_json" => "[{\"featureType\":\"administrative\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"poi\",\"stylers\":[{\"visibility\":\"simplified\"}]},{\"featureType\":\"road\",\"elementType\":\"labels\",\"stylers\":[{\"visibility\":\"simplified\"}]},{\"featureType\":\"water\",\"stylers\":[{\"visibility\":\"simplified\"}]},{\"featureType\":\"transit\",\"stylers\":[{\"visibility\":\"simplified\"}]},{\"featureType\":\"landscape\",\"stylers\":[{\"visibility\":\"simplified\"}]},{\"featureType\":\"road.highway\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"road.local\",\"stylers\":[{\"visibility\":\"on\"}]},{\"featureType\":\"road.highway\",\"elementType\":\"geometry\",\"stylers\":[{\"visibility\":\"on\"}]},{\"featureType\":\"water\",\"stylers\":[{\"color\":\"#84afa3\"},{\"lightness\":52}]},{\"stylers\":[{\"saturation\":-17},{\"gamma\":0.36}]},{\"featureType\":\"transit.line\",\"elementType\":\"geometry\",\"stylers\":[{\"color\":\"#3f518c\"}]}]",
                "map_width_type" => "%",
                "map_height_type" => "px",
                "draggable" => "1",
                "fullscreen_control" => "1",
                "maptype_control" => "1",
                "scroll_wheel" => "1",
                "street_view_control" => "0",
                "zoom_control" => "1",
                "traffic_layer" => "1",
                "transit_layer" => "0",
                "bicycling_layer" => "0",
                "style_of_markers_listing" => "1",
                "has_street_view_box" => "1",
                "street_view_box_width" => "1",
                "order_markers_by" => "1",
            )
        );
        //let's create some demo markers
        gmapsl_create_demo_marker_for_demo_map(1,'55.23','49.06');
        gmapsl_create_demo_marker_for_demo_map(1,'54.83','49.06');
        gmapsl_create_demo_marker_for_demo_map(2,'55.63','49.06');
        gmapsl_create_demo_marker_for_demo_map(2,'56.23','49.06');
        gmapsl_create_demo_marker_for_demo_map(2,'54.83','49.06');



    }

}

function gmapsl_create_demo_marker_for_demo_map($map_id,$lat,$lng){
    global $wpdb;
    global $gmapsl_maps_table;
    global $gmapsl_markers_table;

    $wpdb->insert($gmapsl_markers_table, array(
            "map_id" => $map_id,
            "address" => "1",
            "lat" => $lat,
            "lng" => $lng,
            "title" => "Marker{$lat}",
            "desrc" => "Marker{$lat} Desr",
            "icon" => "1",
            "pic" => "1",
            "has_street_view" => "1",
            "street_view_heading" => "1",
            "street_view_pitch" => "1",
        )
    );

}

