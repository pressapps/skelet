<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 * Skelet Framework
 * @version 1.0.0 
 * @author pressapps <support@pressapps.co>
 * 
 */
    
    global $skelet_paths,$skelet_path,$skelet_shortcodes;
    
    // Skelet class 
    include_once wp_normalize_path(dirname( __FILE__ ) .'/classes/skelet.class.php');
  
    // Widget should be included on widgets init action.
    include_once wp_normalize_path(dirname( __FILE__ ) .'/classes/widget.class.php');
    
if(! class_exists( 'Skelet_LoadConfig' ) ){
    

    class Skelet_LoadConfig{
            public static function instance(){
                    global $skelet_paths,$skelet_path;
                   
                    // active modules
                    defined( 'SK_ACTIVE_FRAMEWORK' )  or  define( 'SK_ACTIVE_FRAMEWORK',  true );
                    defined( 'SK_ACTIVE_METABOX'   )  or  define( 'SK_ACTIVE_METABOX',    true );
                    defined( 'SK_ACTIVE_SHORTCODE' )  or  define( 'SK_ACTIVE_SHORTCODE',  true );
                    defined( 'SK_ACTIVE_CUSTOMIZE' )  or  define( 'SK_ACTIVE_CUSTOMIZE',  true );
                    defined( 'SK_ACTIVE_WIDGET'    )  or  define( 'SK_ACTIVE_WIDGET',     true );
                    defined( 'SK_ACTIVE_TAXONOMY'  )  or  define( 'SK_ACTIVE_TAXONOMY',   true );
                    defined( 'SK_ACTIVE_TEMPLATE'  )  or  define( 'SK_ACTIVE_TEMPLATE',   true );
                    
                   
                   foreach ($skelet_paths as $path) { 



                         // ------------------------------------------------------------------------------------------------
                            include_once wp_normalize_path(dirname( __FILE__ ) .'/path.php');
                         // ------------------------------------------------------------------------------------------------
                         $arr_last = $path; 
                         $path["basename"] = "skelet";
                         $path["option"]   = $path["prefix"]."_options";
                         $path["customize"]= $path["prefix"]."_customize";
                         
                         $skelet_path = $path;
                       
                        // helpers
                        sk_locate_template ( 'functions/deprecated.php'     ,$skelet_path);
                        sk_locate_template ( 'functions/helpers.php'        ,$skelet_path);
                        sk_locate_template ( 'functions/actions.php'        ,$skelet_path);
                        sk_locate_template ( 'functions/enqueue.php'        ,$skelet_path);
                        sk_locate_template ( 'functions/sanitize.php'       ,$skelet_path);
                        sk_locate_template ( 'functions/validate.php'       ,$skelet_path);
                        sk_locate_template ( 'functions/customize.php'       ,$skelet_path);

                        // classes
                        sk_locate_template ( 'classes/abstract.class.php'   ,$skelet_path);
                        sk_locate_template ( 'classes/options.class.php'    ,$skelet_path);
                        sk_locate_template ( 'classes/framework.class.php'  ,$skelet_path);
                        sk_locate_template ( 'classes/metabox.class.php'    ,$skelet_path);
                        sk_locate_template ( 'classes/shortcode.class.php'  ,$skelet_path);
                        sk_locate_template ( 'classes/customize.class.php'  ,$skelet_path);
                        sk_locate_template ( 'classes/taxonomy.class.php'   ,$skelet_path);
                        sk_locate_template ( 'classes/template.class.php'   ,$skelet_path);
                      
                        // configs
                        if(file_exists( wp_normalize_path($skelet_path["dir"].'/options/framework.config.php'))){
                            sk_locate_template ( '../../admin/options/framework.config.php'  ,$skelet_path);
                        }

                        if(file_exists( wp_normalize_path($skelet_path["dir"].'/options/metabox.config.php'))){
                            sk_locate_template ( '../../admin/options/metabox.config.php'    ,$skelet_path);
                        }

                        if(file_exists( wp_normalize_path($skelet_path["dir"].'/options/shortcode.config.php'))){
                            sk_locate_template ( '../../admin/options/shortcode.config.php'  ,$skelet_path);
                        }

                        if(file_exists( wp_normalize_path($skelet_path["dir"].'/options/customize.config.php'))){
                            sk_locate_template ( '../../admin/options/customize.config.php'  ,$skelet_path);
                        }
                        
                        if(file_exists( wp_normalize_path($skelet_path["dir"].'/options/taxonomy.config.php'))){
                            sk_locate_template ( '../../admin/options/taxonomy.config.php'  ,$skelet_path);
                        }
                        
                        if(file_exists( wp_normalize_path($skelet_path["dir"].'/options/template.config.php'))){
                            sk_locate_template ( '../../admin/options/template.config.php'  ,$skelet_path);
                        }

                        if ($arr_last === end($skelet_paths)){
                             do_action("skelet_loaded");
                        }


                   
                    }

            }




    }


     add_action("init",array('Skelet_LoadConfig','instance'),10);

}

/**
 * Load shortcodes after skelet loaded
 */
if (!function_exists("skelet_load_shortcodes")) {
  function skelet_load_shortcodes(){
      global $skelet_shortcodes;
     SkeletFramework_Shortcode_Manager::instance( $skelet_shortcodes );

  }
  add_action( 'skelet_loaded', 'skelet_load_shortcodes', 10 );
        
}
/**
 * Skelet Widget Init
 */

if(!class_exists("Skelet_PA_Widget")){
    class Skelet_PA_Widget{
      
        function __construct(){
            add_action( 'widgets_init', array($this,"widgetize"),2);
        }

        /**
         * Register the widget for the admin area.
         *
         * @since    1.0.0
         */
        public function widgetize(){
             global $skelet_paths,$skelet_path;
            
             foreach ($skelet_paths as $path) {

                $skelet_path = $path;
                 if(file_exists( wp_normalize_path($skelet_path["dir"].'/options/widget.config.php'))){
                        include_once  wp_normalize_path($skelet_path["dir"].'/options/widget.config.php');
                }
            }

        }
 
    }
    new Skelet_PA_Widget;
}


/**
 * Add PressApps Menu
 */
if(!class_exists("Skelet_PressApps_Menu")){

  class Skelet_PressApps_Menu{

    public static function pa_main_menu(){
        global $skelet_paths, $submenu;
      

        call_user_func("add_submenu_page", SK_PARENT_MENU, "Support", "Support", "manage_options", "pressapps-support", array("Skelet_PressApps_Menu","get_pa_general_pages"));
        call_user_func("add_submenu_page", SK_PARENT_MENU, "Products", "Products", "manage_options", "pressapps-product", array("Skelet_PressApps_Menu","get_pa_general_pages"));
        call_user_func("add_submenu_page", SK_PARENT_MENU, "Services", "Services", "manage_options", "pressapps-services", array("Skelet_PressApps_Menu","get_pa_general_pages"));
                          
   }
    public static function get_pa_general_pages(){
      if(!class_exists("PressApps"))
      {
            include_once wp_normalize_path(plugin_dir_path(__FILE__ ) .'/pressapps/pressapps.class.php');
            $pa = new PressApps;
            $pa::route(isset($_GET["page"])?$_GET["page"]:"");
      }
    }

  
  }
     add_action("admin_menu",array("Skelet_PressApps_Menu","pa_main_menu"),999);


}

