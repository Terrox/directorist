<?php
namespace Directorist;
class Enqueue_Assets {

    public $js_scripts  = [];
    public $css_scripts = [];

    /**
     * Constuctor
     */
    function __construct() {
        // Load Assets
        add_action( 'init', [ $this, 'load_assets'] );

        // Enqueue Public Scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_public_scripts' ] );

        // Enqueue Admin Scripts
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );

        // Enqueue Global Scripts
        add_action( 'init', [ $this, 'enqueue_global_scripts' ] );
    }

    /**
     * Load Assets
     *
     * @return void
     */
    public function load_assets() {
        // Load Vendor Assets
        $this->add_vendor_css_scripts();
        $this->add_vendor_js_scripts();

        // Load Public Assets
        $this->add_public_css_scripts();
        $this->add_public_js_scripts();

        // Load Admin Assets
        $this->add_admin_css_scripts();
        $this->add_admin_js_scripts();

        // Load Global Assets
        $this->add_global_css_scripts();
        $this->add_global_js_scripts();

        // Inject Scripts Meta
        $this->inject_scripts_meta();

        atbdp_console_log( $this->js_scripts );

        // Apply Hook to Scripts
        $this->apply_hook_to_scripts();
    }


    /**
     * Apply Hook to Scripts
     *
     * @return void
     */
    public function apply_hook_to_scripts() {
        $this->css_scripts = apply_filters( 'directorist_css_scripts', $this->css_scripts );
        $this->js_scripts = apply_filters( 'directorist_js_scripts', $this->js_scripts );
    }

    /**
     * Load Vendor CSS Scripts
     *
     * @return void
     */
    public function add_vendor_css_scripts() {
        // $scripts = [];

        // $scripts['directorist-main-style'] = [
        //     'file_name' => 'main-style',
        //     'base_path' => DIRECTORIST_PUBLIC_CSS,
        //     'deps'      => [],
        //     'ver'       => false,
        //     'group'     => 'public', // public || admin  || global
        //     'section'   => '',
        // ];

        // $scripts = array_merge( $this->css_scripts, $scripts);
        // $this->css_scripts = $scripts;
    }

    /**
     * Load Vendor JS Scripts
     *
     * @return void
     */
    public function add_vendor_js_scripts() {
        // $scripts = [];

        // // Public Group
        // $scripts['directorist-main-script'] = [
        //     'file_name' => 'main',
        //     'base_path' => DIRECTORIST_PUBLIC_JS,
        //     'deps'      => [],
        //     'ver'       => false,
        //     'group'     => 'public', // public || admin  || global
        //     'section'   => '',
        //     'enable'    => true,
        // ];

        // $scripts = array_merge( $this->js_scripts, $scripts);
        // $this->js_scripts = $scripts;
    }


    /**
     * Load Public CSS Scripts
     *
     * @return void
     */
    public function add_public_css_scripts() {
        $scripts = [];

        $scripts['directorist-main-style'] = [
            'file_name' => 'main-style',
            'base_path' => DIRECTORIST_PUBLIC_CSS,
            'deps'      => [],
            'ver'       => false,
            'group'     => 'public', // public || admin  || global
            'section'   => '',
        ];

        $scripts = array_merge( $this->css_scripts, $scripts);
        $this->css_scripts = $scripts;
    }

    /**
     * Load Public JS Scripts
     *
     * @return void
     */
    public function add_public_js_scripts() {
        $scripts = [];

        // Public Group
        $scripts['directorist-main-script'] = [
            'file_name' => 'main',
            'base_path' => DIRECTORIST_PUBLIC_JS,
            'deps'      => [],
            'ver'       => false,
            'group'     => 'public', // public || admin  || global
            'section'   => '',
            'enable'    => true,
        ];

        $scripts = array_merge( $this->js_scripts, $scripts);
        $this->js_scripts = $scripts;
    }

    /**
     * Load Admin CSS Scripts
     *
     * @return void
     */
    public function add_admin_css_scripts() {
        $scripts = [];

        $scripts['directorist-admin-style'] = [
            'file_name' => 'admin-style',
            'base_path' => DIRECTORIST_ADMIN_CSS,
            'deps'      => [],
            'ver'       => false,
            'group'     => 'admin',
            'section'   => '',
        ];

        $scripts = array_merge( $this->css_scripts, $scripts);
        $this->css_scripts = $scripts;
    }

    /**
     * Load Admin JS Scripts
     *
     * @return void
     */
    public function add_admin_js_scripts() {
        $scripts = [];

        // Admin Group
        $scripts['directorist-admin-script'] = [
            'file_name' => 'admin',
            'base_path' => DIRECTORIST_ADMIN_JS,
            'deps'      => [],
            'ver'       => false,
            'group'     => 'admin',
            'section'   => '',
        ];

        $scripts = array_merge( $this->js_scripts, $scripts);
        $this->js_scripts = $scripts;
    }

    /**
     * Load Global CSS Scripts
     *
     * @return void
     */
    public function add_global_css_scripts() {
        // $scripts = [];

        // $scripts['directorist-admin-style'] = [
        //     'file_name' => 'admin-style',
        //     'base_path' => DIRECTORIST_ADMIN_CSS,
        //     'deps'      => [],
        //     'ver'       => false,
        //     'group'     => 'admin',
        //     'section'   => '',
        // ];

        // $scripts = array_merge( $this->css_scripts, $scripts);
        // $this->css_scripts = $scripts;
    }
    
    /**
     * Load Global JS Scripts
     *
     * @return void
     */
    public function add_global_js_scripts() {
        // $scripts = [];

        // // Admin Group
        // $scripts['directorist-admin-script'] = [
        //     'file_name' => 'admin',
        //     'base_path' => DIRECTORIST_ADMIN_JS,
        //     'deps'      => [],
        //     'ver'       => false,
        //     'group'     => 'admin',
        //     'section'   => '',
        // ];

        // $scripts = array_merge( $this->js_scripts, $scripts);
        // $this->js_scripts = $scripts;
    }


    /**
     * Enqueue Public Scripts
     *
     * @return void
     */
    public function enqueue_public_scripts() {
        // CSS
        $this->register_css_scripts_by_group( [ 'group' => 'public' ] );
        $this->enqueue_css_scripts_by_group( [ 'group' => 'public' ] );

        // JS
        $this->register_js_scripts_by_group( [ 'group' => 'public' ] );
        $this->enqueue_js_scripts_by_group( [ 'group' => 'public' ] );
    }


    /**
     * Enqueue Admin Scripts
     *
     * @return void
     */
    public function enqueue_admin_scripts() {
        // CSS
        $this->register_css_scripts_by_group( [ 'group' => 'admin' ] );
        $this->enqueue_css_scripts_by_group( [ 'group' => 'admin' ] );

        // JS
        $this->register_js_scripts_by_group( [ 'group' => 'admin' ] );
        $this->enqueue_js_scripts_by_group( [ 'group' => 'admin' ] );
    }

    /**
     * Enqueue Global Scripts
     *
     * @return void
     */
    public function enqueue_global_scripts() {
        // CSS
        $this->register_css_scripts_by_group( [ 'group' => 'global' ] );
        $this->enqueue_css_scripts_by_group( [ 'group' => 'global' ] );

        // JS
        $this->register_js_scripts_by_group( [ 'group' => 'global' ] );
        $this->enqueue_js_scripts_by_group( [ 'group' => 'global' ] );
    }


    /**
     * Register CSS Scripts
     *
     * @return void
     */
    public function register_css_scripts_by_group( array $args = [] ) {
        $default = [ 'scripts' => $this->css_scripts, 'group' => 'public' ];
        $args    = array_merge( $default, $args );

        foreach( $args['scripts'] as $handle => $script_args ) {

            if ( ! empty( $script_args['enable'] ) && false === $script_args['enable'] ) {
                continue;
            }

            if (  ! ( ! empty( $script_args['group'] ) && $args['group'] === $script_args['group'] ) ) {
                continue;
            }

            $default = [ 
                'file_name' => $handle,
                'base_path' => DIRECTORIST_PUBLIC_CSS,
                'deps'      => [],
                'ver'       => false,
                'media'     => 'all'
            ];

            $script_args = array_merge( $default, $script_args );
            $src = $script_args['base_path'] . $this->get_script_file_name( $script_args ) . '.css';

            wp_register_style( $handle, $src, $script_args['deps'], $script_args['ver'], $script_args['media']);
        }
    }

    /**
     * Enqueue CSS Scripts
     *
     * @return void
     */
    public function enqueue_css_scripts_by_group( array $args = [] ) {
        $default = [ 'scripts' => $this->css_scripts, 'group' => 'public' ];
        $args    = array_merge( $default, $args );

        foreach( $args['scripts'] as $handle => $script_args ) {
            if (  ! ( ! empty( $script_args['group'] ) && $args['group'] === $script_args['group'] ) ) {
                continue;
            }

            if ( ! empty( $script_args['section'] ) ) { continue; }

            wp_enqueue_style( $handle );
        }
    }



    /**
     * Register JS Scripts by Group
     *
     * @param array $args
     * @return void
     */
    public function register_js_scripts_by_group( array $args = [] ) {
        $default = [ 'scripts' => $this->js_scripts, 'group' => 'public' ];
        $args    = array_merge( $default, $args );

        foreach( $args['scripts'] as $handle => $script_args ) {

            if ( ! empty( $script_args['enable'] ) && false === $script_args['enable'] ) {
                continue;
            }

            if (  ! ( ! empty( $script_args['group'] ) && $args['group'] === $script_args['group'] ) ) {
                continue;
            }

            $default = [ 
                'file_name' => $handle,
                'base_path' => DIRECTORIST_PUBLIC_JS,
                'deps'      => [],
                'ver'       => false,
                'in_footer' => true
            ];

            $script_args = array_merge( $default, $script_args );
            $script_args['has_rtl'] = false;

            $src  = $script_args['base_path'] . $this->get_script_file_name( $script_args ) . '.js';

            wp_register_script( $handle, $src, $script_args['deps'], $script_args['ver'], $script_args['in_footer']);
        }
    }

    /**
     * Enqueue JS Scripts
     *
     * @return void
     */
    public function enqueue_js_scripts_by_group( array $args = [] ) {
        $default = [ 'scripts' => $this->js_scripts, 'group' => 'public' ];
        $args    = array_merge( $default, $args );

        foreach( $args['scripts'] as $handle => $script_args ) {
            if (  ! ( ! empty( $script_args['group'] ) && $args['group'] === $script_args['group'] ) ) {
                continue;
            }

            if ( ! empty( $script_args['section'] ) ) { continue; }

            wp_enqueue_script( $handle );
        }
    }

    
    /**
     * Get Script File Name
     *
     * @param array $args
     * @return $file_name
     */
    public function get_script_file_name( array $args = [] ) {
        $default = [ 'has_min' => true, 'has_rtl' => true ];
        $args    = array_merge( $default, $args );

        $file_name  = ( ! empty( $args['file_name'] ) ) ? $args['file_name'] : '';
        $has_min    = ( ! empty( $args['has_min'] ) ) ? true : false;
        $has_rtl    = ( ! empty( $args['has_rtl'] ) ) ? true : false;
        
        $load_min = apply_filters( 'directorist_load_min_files', true );
        $is_rtl   = false;

        if ( $has_min && $load_min ) {
            $file_name = "{$file_name}.min";
        }

        if ( $has_rtl && $is_rtl ) {
            $file_name = "{$file_name}.rtl";
        }

        return $file_name;
    }

    /**
     * Inject Scripts Meta
     *
     * @return void
     */
    public function inject_scripts_meta() {
        // Add js script meta

        foreach( $this->js_scripts as $handle => $script_args ) {
            // Inject WP dependency meta
            if (  empty( $script_args['file_name'] ) ||  empty( $script_args['group'] ) ) {
                continue;
            }

            $file_name = $this->get_script_file_name( $script_args );
            $asset_path = ATBDP_DIR . "assets/dest/{$script_args['group']}/js/{$file_name}.asset.php";

            if ( ! file_exists( $asset_path ) ) { continue; }
            $asset_source = require( $asset_path );

            $deps = ( isset( $script_args['deps'] ) && is_array( $script_args['deps'] ) ) ? $script_args['deps'] : [];
            $ver  = ( isset( $script_args['ver'] ) && is_string( $script_args['ver'] ) ) ? $script_args['ver'] : '';

            if ( isset( $asset_source['dependencies'] ) ) {
                $deps = array_merge( $deps, $asset_source['dependencies'] );
            }

            if ( isset( $asset_source['version'] ) ) {
                $ver =  $asset_source['version'];
            }

            $this->js_scripts[ $handle ][ 'deps' ] = $deps;
            $this->js_scripts[ $handle ][ 'ver' ]  = $ver;
        }
    }
}
