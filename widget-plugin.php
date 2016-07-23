<?php
/*
Plugin Name: eBird widget Plugin
Plugin URI: http://www.sanisoft.com/ebird
Description: A simple plugin that adds a widget to show eBird data for a selected location
Version: 1.0
Author: Dr. Tarique Sani <tarique@sanisoft.com>
Author URI: http://www.sanisoft.com/blog/author/tariquesani/
License: GPL3
*/

require "includes/ebirdapi.php";

class ebird_widget_plugin extends WP_Widget {

    // constructor
    function ebird_widget_plugin() {
        parent::WP_Widget(false, $name = __('eBird Widget', 'ebird_widget_plugin') );
    }

    // widget form creation
    function form($instance) {
        // Check values
        if( $instance) {
             $location_id   = esc_attr($instance['region_code']);
             $location_name = esc_attr($instance['location_name']);
             $days_back     = esc_textarea($instance['days_back']);
        } else {
             $location_id   = 'L11';
             $location_name = 'Toronto--High Park';
             $days_back     = '7';
        }
        ?>

        <p>
        <label for="<?php echo $this->get_field_id('region_code'); ?>"><?php _e('Region Code:', 'ebird_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('region_code'); ?>" name="<?php echo $this->get_field_name('region_code'); ?>" type="text" value="<?php echo $location_id; ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('location_name'); ?>"><?php _e('Title:', 'ebird_widget_plugin'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('location_name'); ?>" name="<?php echo $this->get_field_name('location_name'); ?>" type="text" value="<?php echo $location_name; ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('days_back'); ?>"><?php _e('For last how many days:', 'ebird_widget_plugin'); ?></label>
        <input id="<?php echo $this->get_field_id('days_back'); ?>" name="<?php echo $this->get_field_name('days_back'); ?>" type="text" value="<?php echo $days_back; ?>" size="3"/>
        </p>
        <?php
    }


    // widget update
    function update($new_instance, $old_instance) {
          $instance = $old_instance;
          // Fields
          $instance['region_code'] = strip_tags($new_instance['region_code']);
          $instance['location_name'] = strip_tags($new_instance['location_name']);
          $instance['days_back']   = strip_tags($new_instance['days_back']);
          delete_transient( 'ebird_data' );
         return $instance;
    }

    // widget display
    function widget($args, $instance) {
       extract( $args );
       // these are the widget options
       $title = $instance['location_name'];
       $title = apply_filters('widget_title', $title);
       $checklists = array();
       echo $before_widget;
       // Display the widget
       echo '<div class="widget-text ebird_widget_plugin_box">';

       // Check if title is set
       if ( $title ) {
          echo $before_title . $title . $after_title;
       }

       $data = get_transient('ebird_data');
       ?>
        <div id="tab-container" class="tab-container">
          <ul class='etabs'>
            <li class='tab active'><a href="#observations">Observations</a></li>
            <li class='tab'><a href="#checklists">Checklist</a></li>
          </ul>

          <div id="observations">
       <?php
       if( $data ) {

            $countObservations = count($data->recentObservations);

            //print_r($data->recentObservations);

            if (!$countObservations) {
                delete_transient( 'ebird_data' );
            }

            echo '<p class="ebird_widget_p">'.sprintf(__("%d observations in last %d days!",'ebird_widget_plugin'), $countObservations, $instance['days_back']).'</p>';

            if(count($data->fullObservations)){
                    echo '<div id="scrollbar1">
                    <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                    <div class="viewport">
                         <div class="overview">';

                    echo"<ul>";
                        $i =0;
                        foreach ($data->fullObservations as $observation) {
                            $observation = array_shift($observation);
                            @$checklists[$observation->subID]['count']++;
                            @$checklists[$observation->subID]['location'] = ucwords(strtolower($observation->locName));
                            @$checklists[$observation->subID]['observer'] = ucwords(strtolower($observation->firstName." ".$observation->lastName));
                            //print_r($observation);
                            echo '<li><a class="inline" href="#inline_content_'.$i.'" ><div class="bird-name">'. $observation->comName .'</div><div class="badge">'. @$observation->howMany.'</div></a></li>';
                            echo "<div style='display:none'>";
                            echo    "<div id='inline_content_$i' style='padding:10px; background:#fff;'>";
                            echo        "<h3> $observation->comName (<i>$observation->sciName</i>) - ".@$observation->howMany."</h3><br>";
                            echo        "<div class='cboxLabel'>Observer:</div><div class='cboxValue'>".ucwords(strtolower($observation->firstName." ".$observation->lastName))."</div>";
                            echo        "<div class='cboxLabel'>Location:</div><div class='cboxValue'>$observation->locName </div>";
                            echo        "<div class='cboxLabel'>Date:</div><div class='cboxValue'>$observation->obsDt</div>";
                            echo        "<div class='cboxLabel'>Status:</div><div class='cboxValue'>".($observation->obsValid? 'Approved':'Not Approved')."</div>";
                            echo "<br>";
                            echo "<a href=http://ebird.org/ebird/view/checklist?subID=$observation->subID target=_blank ><img src='" . plugins_url( 'images/checklist.png' , __FILE__ ) . "' title='See checklist' ></a>";
                            echo "<a href=http://maps.google.com?t=p&z=13&q=$observation->lat,$observation->lng&ll=$observation->lat,$observation->lng  target=_blank ><img src='" . plugins_url( 'images/map-marker.png' , __FILE__ ) . "' title='See location map' ></a>";
                            echo "<a href='http://en.wikipedia.org/wiki/$observation->comName'  target=_blank ><img src='" . plugins_url( 'images/wikipedia.png' , __FILE__ ) . "' title='See wikipedia page' ></a>";
                            echo    "</div>";
                            echo "</div>";
                            $i++;
                        }
                    echo"</ul>";

                    echo '</div>
                    </div>

                </div>';
                //print_r($data);
            ?>
                </div>
                <div id="checklists">
                    <ul>
                        <?php
                        foreach ($checklists as $subID => $checklist) {
                            # code...
                            echo '<li class="chklst_li" ><a href=http://ebird.org/ebird/view/checklist?subID='.$subID.' target=_blank ><div class="chklst_count" >'.$checklist['count'].'</div><div class="chklst_location" >'.$checklist['location'].'</div><div class="chklst_observer" >'.$checklist['observer'].'</div></a></li>';
                        }
                        ?>
                    </ul>
                <pre>
                    <?php //print_r($checklists); ?>
                </pre>
                </div>
                    <!-- Be nice and do not remove the credits -->
                    <div class="sanisoft_credits"><a href="//ebird.org">eBird</a> widget created by <a href="//sanisoft.com">SANIsoft</a></div>
            </div>
            <?php
            } else {
            echo'<p class="ebird_widget_p">';
            _e(' Details are being fetched from eBird site please check back later', 'ebird_widget_plugin');
            echo '</p>';
            }
       } else {
          _e('The data is being fetched from eBird site please check back later', 'ebird_widget_plugin');
       }

       echo '</div>';
       echo $after_widget;
    }

}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("ebird_widget_plugin");'));

add_action('get_data', 'get_data');

$data = get_transient('ebird_data');

if(!$data && false === wp_get_schedule( 'get_data' )) {
    wp_schedule_single_event(time(), 'get_data');
}

function get_data(){

    $ebw = new ebird_widget_plugin;

    $settings = $ebw->get_settings();

    $settings = array_shift($settings);

    $eb   = new NagpurBirds\EbirdAPI();
    $options['back']    = $settings['days_back'];

    $data = new stdClass();

    $data->recentObservations = $recentObservations = array();

    $data->fullObservations = $fullObservations = array();

    $recentObservations = json_decode($eb->recentObservationsAtLocations($settings['region_code'], $options));

    $data->recentObservations = $recentObservations;

    if (!$eb->error) {
        set_transient('ebird_data', $data, 12*60*60);
        //return true;
    }else{
        echo $eb->errorMsg;
        return false;
    }

    // rest of the code deals with getting checkLists - not executed for now

    $options['detail'] = 'full';

    foreach ($data->recentObservations as $observation) {
        $fullObservations[] = json_decode(
            $eb->recentObservationsOfASpeciesAtLocations(
                $observation->locID,
                $observation->sciName,
                $options
            )
        );
    }

    $data->fullObservations = $fullObservations;

    if (!$eb->error) {
        set_transient('ebird_data', $data, 12*60*60);
        return true;
    }else{
        echo $eb->errorMsg;
        return false;
    }

}


function ebird_scripts()
{

    wp_register_script( 'tinyscrollbar', plugins_url( '/js/tinyscrollbar.min.js', __FILE__ ) );
    wp_register_script( 'colorbox', plugins_url( '/js/jquery.colorbox-min.js', __FILE__ ),array( 'jquery' ));
    wp_register_script( 'addcolorbox', plugins_url( '/js/addcolorbox.js', __FILE__ ),array( 'colorbox','easytabs','tinyscrollbar' ),1,true);
    wp_register_script( 'easytabs', plugins_url( '/js/jquery.easytabs.min.js', __FILE__ ),array( 'jquery' ));

    wp_register_style( 'tinyscrollbar', plugins_url( '/css/tinyscrollbar.css', __FILE__ ));
    wp_register_style( 'colorbox', plugins_url( '/css/colorbox.css', __FILE__ ));

    wp_enqueue_script( 'tinyscrollbar' );
    wp_enqueue_script( 'colorbox' );
    wp_enqueue_script( 'addcolorbox' );
    wp_enqueue_script( 'easytabs' );

    wp_enqueue_style( 'tinyscrollbar' );
    wp_enqueue_style( 'colorbox' );



}
add_action( 'wp_enqueue_scripts', 'ebird_scripts' );
