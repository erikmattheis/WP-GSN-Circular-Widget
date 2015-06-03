<?php
/**
Plugin Name: WP GSN Circular Widget
Plugin URI:  http://URI_Of_Page_Describing_Plugin_and_Updates
Description: This describes my plugin in a short sentence
Version:     1.5
Author:      @ErikMattheis for Grocery Shopping Network
Author URI:  http://groceryshopping.net
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) or die( 'Sorry, nothing to see here!' );

/* Header modifications */
function gsn_circular_widget_enqueue_scripts () {
  if(!is_admin()) {
    wp_register_script("gmodal", ("https://rawgit.com/niiknow/gmodal/master/gmodal.min.js"), FALSE, "0", TRUE);
    wp_enqueue_script("gmodal");
  }
}
add_action("wp_enqueue_scripts", "gsn_circular_widget_enqueue_scripts");




/* Admin modifications */
function gsn_circular_widget_menu() {
  add_menu_page('GSN Circular Widget Settings',
    'GSN Circular Widget Settings',
    'administrator',
    __FILE__,
    'gsn_circular_widget_settings_page',
    plugins_url('/images/search-hat.png', __FILE__));
  add_action( 'admin_init', 'gsn_circular_widget_register_mysettings' );
}
add_action("admin_menu", "gsn_circular_widget_menu");

function gsn_circular_widget_register_mysettings() {
  register_setting( 'gsn-circular-widget', 'title' );
  register_setting( 'gsn-circular-widget', 'chain_id' );
}

function gsn_circular_widget_settings_page() {

?>

    <div class="wrap">
    <h2>GSN Circular Widget Options</h2>

    <form method="post" action="options.php">

        <table class="form-table">
            <?php settings_fields('gsn-circular-widget' ); ?>
            <?php do_settings_sections('gsn-circular-widget'); ?>
            <tr valign="top">
            <th scope="row">Chain ID</th>
            <td><input type="text" name="chain_id" value="<?php echo get_option('chain_id'); ?>" /></td>
            </tr>
        </table>
        
        <?php submit_button(); ?>

    </form>
    </div>
<?php
}

/* Widget */

class GSN_Circular_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            "gsn_circular_widget", // widget Id
            "GSN Circular Widget", // widget name
            array( 'description' => "Displays circular in modal window.")
        );
    }

    public function widget( $args, $instance ) {

        echo $args["before_widget"];

        ?>

            <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <style type="text/css">
        html, body {
            margin: 0;
            padding: 10px;
        }
    
        .gmodal {
            /* cross-browser IE8 and up compatible data URI RGBA(0,0,0,0.7) */
            background: url("data:image/gif;base64, iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNg2AQAALUAs0e+XlcAAAAASUVORK5CYII=");
        }
    
        .myModalContent {
            position: relative;
            background: #fff;
            width: 500px;
            padding: 10px;
        }
    
        .myCloseButton {
            position: absolute;
            top: 5px;
            right: 5px;
        }
    
        /* make bootstrap modal scrollable */
        .modal-body {
            max-height: 200px;
            overflow-y: auto;
        }
        .gmodal-content {
            opacity: 0;
            -webkit-transition: opacity 1s linear;
            transition: opacity 1s linear;
        }
        .gmodal-content.in {
            opacity: 1;
        }
    </style>
    <!-- /For demo purpose -->

    <script type="text/javascript" src="../gmodal.js"></script>
    <script type="text/javascript">
            
        function showGSNCircularModal() {
            // you don't need no stinking jquery
            gmodal.show({content: document.getElementById('gsn-circular-widget-modal-content').innerHTML, hideOn: 'click,esc,tap'});
        }
    </script>

        <div>
            
        <?php

        if (!empty($instance[ "title" ])) {
            echo $args["before_title"]
              . $instance[ "title" ]
              . $args["after_title"];
        }

        ?>

        <button onclick="showGSNCircularModal()">View Circular</button>

        </div>

    <script type="text/html" id="gsn-circular-widget-modal-content">
         <div class="myModalContent">
            <h1>HTML Ipsum Presents</h1>
    
            <p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>
    
            <h2>Header Level 2</h2>
    
            <ol>
                <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
                <li>Aliquam tincidunt mauris eu risus.</li>
            </ol>
    
            
            <button class="myCloseButton gmodal-close" title="Close">&times;</button>
        </div>
    </script>

        <?php
        echo $args["after_widget"];
    }

    public function form( $instance ) {

        if ( isset( $instance[ "title" ] ) ) {
            $title = $instance[ "title" ];
        }
        else {
            $title = "";
        }

        echo '<p><label for="'
            . $this->get_field_id( 'title' )
            . '">Title</label>'
            . '<input class="widefat" id="'
            . $this->get_field_id( 'title' )
            . '" name="'
            . $this->get_field_name( 'title' )
            . '" type="text" value="'
            . esc_attr( $title )
            . '"></p>';
    }

    public function update( $new_instance, $old_instance ) {

        $instance = array();
        $instance["title"] = ( ! empty( $new_instance["title"] ) ) ? strip_tags( $new_instance["title"] ) : "";

        return $instance;
    }
}

function register_GSN_Circular_Widget() {
    register_widget( 'gsn_circular_widget' );
}

add_action( 'widgets_init', 'register_GSN_Circular_Widget' );
