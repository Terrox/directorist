<?php

if ( ! class_exists( 'ATBDP_Enqueue_Assets' ) ):
class ATBDP_Enqueue_Assets {

    public $js_scripts  = [];
    public $css_scripts = [];

    /**
     * Constuctor
     */
    function __construct() {
        add_action( 'init', [ $this, 'load_css_scripts' ] );
        add_action( 'init', [ $this, 'load_js_scripts' ] );

        // Enqueue Public Scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_public_scripts' ] );

        // Enqueue Admin Scripts
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );

        // Enqueue Global Scripts
        add_action( 'init', [ $this, 'enqueue_global_scripts' ] );
    }

    /**
     * Load CSS Scripts
     *
     * @return void
     */
    public function load_css_scripts() {
        $scripts = [];

        // Public Group
        $scripts['directorist-main-style'] = [
            'file_name' => 'main-style',
            'base_path' => DIRECTORIST_PUBLIC_CSS,
            'deps'      => [],
            'ver'       => false,
            'group'     => 'public', // public || admin  || global
            'section'   => '',
        ];

        // Admin Group
        $scripts['directorist-admin-style'] = [
            'file_name' => 'admin-style',
            'base_path' => DIRECTORIST_ADMIN_CSS,
            'deps'      => [],
            'ver'       => false,
            'group'     => 'admin',
            'section'   => '',
        ];

        // Global Group

        $this->css_scripts = apply_filters( 'directorist_css_scripts', $scripts );
    }


    /**
     * Load JS Scripts
     *
     * @return void
     */
    public function load_js_scripts() {
        $scripts = [];

        // Public Group
        $scripts['directorist-main-script'] = [
            'file_name' => 'main',
            'base_path' => DIRECTORIST_PUBLIC_JS,
            'deps'      => [],
            'ver'       => false,
            'group'     => 'public', // public || admin  || global
            'section'   => '',
        ];

        // Admin Group
        $scripts['directorist-admin-script'] = [
            'file_name' => 'admin',
            'base_path' => DIRECTORIST_ADMIN_JS,
            'deps'      => [],
            'ver'       => false,
            'group'     => 'admin',
            'section'   => '',
        ];

        // Global Group

        $this->js_scripts = apply_filters( 'directorist_js_scripts', $scripts );
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
            $src  = $script_args['base_path'] . $this->get_script_file_name( $script_args['file_name'] ) . '.css';

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
            $src  = $script_args['base_path'] . $this->get_script_file_name( $script_args['file_name'] ) . '.js';

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
     * @param string $file_name
     * @return $file_name
     */
    public function get_script_file_name( string $file_name = '' ) {
        
        $load_min = true;
        $is_rtl   = false;

        if ( $load_min ) {
            $file_name = "${$file_name}.min";
        }

        if ( $is_rtl ) {
            $file_name = "${$file_name}.rtl";
        }

        return $file_name;
    }
}
endif;
