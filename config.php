<?php
// Plugin version.
if ( ! defined( 'ATBDP_VERSION' ) ) {define( 'ATBDP_VERSION', '6.6.0' );}
// Plugin Folder Path.
if ( ! defined( 'ATBDP_DIR' ) ) { define( 'ATBDP_DIR', plugin_dir_path( __FILE__ ) ); }
// Plugin Folder URL.
if ( ! defined( 'ATBDP_URL' ) ) { define( 'ATBDP_URL', plugin_dir_url( __FILE__ ) ); }
// Plugin Root File.
if ( ! defined( 'ATBDP_FILE' ) ) { define( 'ATBDP_FILE', __FILE__ ); }
if ( ! defined( 'ATBDP_BASE' ) ) { define( 'ATBDP_BASE', plugin_basename( __FILE__ ) ); }
// Plugin Text domain File.
if ( ! defined( 'ATBDP_TEXTDOMAIN' ) ) { define( 'ATBDP_TEXTDOMAIN' , 'directorist' ); }
// Plugin Includes Path
if ( !defined('ATBDP_INC_DIR') ) { define('ATBDP_INC_DIR', ATBDP_DIR.'includes/'); }
// Plugin Class Path
if ( !defined('ATBDP_CLASS_DIR') ) { define('ATBDP_CLASS_DIR', ATBDP_DIR.'includes/classes/'); }
// Plugin Model Path
if ( !defined('ATBDP_MODEL_DIR') ) { define('ATBDP_MODEL_DIR', ATBDP_DIR.'includes/model/'); }

// Plugin Template Path
if ( !defined('ATBDP_VIEWS_DIR') ) { define('ATBDP_VIEWS_DIR', ATBDP_DIR.'views/'); }

// Public Assets Path
if ( ! defined( 'DIRECTORIST_ASSETS' ) ) { define('DIRECTORIST_ASSETS', ATBDP_URL . 'assets/dest/'); }
if ( ! defined( 'DIRECTORIST_PUBLIC_ASSETS' ) ) { define('DIRECTORIST_PUBLIC_ASSETS', DIRECTORIST_ASSETS . 'public/'); }
if ( ! defined( 'DIRECTORIST_PUBLIC_CSS' ) ) { define('DIRECTORIST_PUBLIC_CSS', DIRECTORIST_PUBLIC_ASSETS . 'css/'); }
if ( ! defined( 'DIRECTORIST_PUBLIC_JS' ) ) { define('DIRECTORIST_PUBLIC_JS', DIRECTORIST_PUBLIC_ASSETS . 'js/'); }

// Admin Assets Path
if ( ! defined( 'DIRECTORIST_ADMIN_ASSETS' ) ) { define('DIRECTORIST_ADMIN_ASSETS', DIRECTORIST_ASSETS . 'admin/'); }
if ( ! defined( 'DIRECTORIST_ADMIN_CSS' ) ) { define('DIRECTORIST_ADMIN_CSS', DIRECTORIST_ADMIN_ASSETS . 'css/'); }
if ( ! defined( 'DIRECTORIST_ADMIN_JS' ) ) { define('DIRECTORIST_ADMIN_JS', DIRECTORIST_ADMIN_ASSETS . 'js/'); }

// Vendor Assets Path
if ( ! defined( 'DIRECTORIST_VENDOR_ASSETS' ) ) { define('DIRECTORIST_VENDOR_ASSETS', DIRECTORIST_ASSETS . 'vendor/'); }
if ( ! defined( 'DIRECTORIST_VENDOR_CSS' ) ) { define('DIRECTORIST_VENDOR_CSS', DIRECTORIST_VENDOR_ASSETS . 'css/'); }
if ( ! defined( 'DIRECTORIST_VENDOR_JS' ) ) { define('DIRECTORIST_VENDOR_JS', DIRECTORIST_VENDOR_ASSETS . 'js/'); }

// Plugin Admin Assets Path
if ( !defined('ATBDP_ADMIN_ASSETS') ) { define('ATBDP_ADMIN_ASSETS', ATBDP_URL.'admin/assets/'); }
// Plugin Public Assets Path
if ( !defined('ATBDP_PUBLIC_ASSETS') ) { define('ATBDP_PUBLIC_ASSETS', ATBDP_URL.'public/assets/'); }
// Plugin Language File Path
if ( !defined('ATBDP_LANG_DIR') ) { define('ATBDP_LANG_DIR', dirname(plugin_basename( __FILE__ ) ) . '/languages'); }
// Plugin Name
if ( !defined('ATBDP_NAME') ) { define('ATBDP_NAME', 'Directorist'); }
// Plugin Post Type
if ( !defined('ATBDP_POST_TYPE') ) { define('ATBDP_POST_TYPE', 'at_biz_dir'); }
if ( !defined('ATBDP_ORDER_POST_TYPE') ) { define('ATBDP_ORDER_POST_TYPE', 'atbdp_orders'); }
if ( !defined('ATBDP_CUSTOM_FIELD_POST_TYPE') ) { define('ATBDP_CUSTOM_FIELD_POST_TYPE', 'atbdp_fields'); }
// Plugin Category Taxonomy
if ( !defined('ATBDP_CATEGORY') ) { define('ATBDP_CATEGORY', ATBDP_POST_TYPE.'-category'); }
// Plugin Location Taxonomy
if ( !defined('ATBDP_LOCATION') ) { define('ATBDP_LOCATION', ATBDP_POST_TYPE.'-location'); }
// Plugin Tag Taxonomy
if ( !defined('ATBDP_TAGS') ) { define('ATBDP_TAGS', ATBDP_POST_TYPE.'-tags'); }
// Plugin Type Taxonomy
if ( !defined('ATBDP_TYPE') ) { define('ATBDP_TYPE', 'atbdp_listing_types'); }

// Plugin Alert Message
if ( !defined('ATBDP_ALERT_MSG') ) { define('ATBDP_ALERT_MSG', __('You do not have the right to access this file directly', 'directorist')); }


// Plugin Veiw Path
if ( !defined('ATBDP_VIEW_DIR') ) { define('ATBDP_VIEW_DIR', ATBDP_DIR.'includes/view/'); }