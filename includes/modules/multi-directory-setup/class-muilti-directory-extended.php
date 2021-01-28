<?php
namespace Directorist;

class Multi_Directory_Extended {

    function __construct() {
        add_filter( 'atbdp_form_preset_widgets', [ $this, 'add_show_if_field_to_submission_form_preset_widgets' ], 20, 1 );
    }


    /**
     * Add conditional fields to submission form preset widgets
     *
     * @param array $widgets
     * @return array
     */
    public function add_show_if_field_to_submission_form_preset_widgets( array $widgets = [] ) {
        $args = [
            'widgets'         => $widgets,
            'options'         => $this->get_the_conditional_field(),
            'exclude_widgets' => [ 'title' ],
        ];

        $widgets = $this->add_options_to_widget_list( $args );
        
        return $widgets;
    }
    
    /**
     * Adds options to given widget list
     *
     * @param array $args
     * @return array $widgets
     */
    public function add_options_to_widget_list( array $args = [] ) {
        $default = [
            'widgets'         => [],
            'options'         => [],
            'exclude_widgets' => [],
        ];

        $args = array_merge( $default, $args );

        if ( empty( $args['widgets'] ) ) {
            return [];
        }

        if ( empty( $args['options'] ) ) {
            return $args['widgets'];
        }

        foreach ( $args['widgets'] as $widget_key => $widget_args ) {

            // Skip excluding widgets
            if ( ! empty( $args['exclude_widgets'] ) && in_array( $widget_key, $args['exclude_widgets'] ) ) {
                continue;
            }

            $new_options = array_merge( $widget_args['options'], $args['options'] );
            $args['widgets'][ $widget_key ]['options'] = $new_options;
        }
        
        return $args['widgets'];
    }

    /**
     * Get conditional field
     *
     * @return array
     */
    public function get_the_conditional_field() {
        $fields = [
            'show_if' => [
                'type'  => 'show-if',
                'label' => 'Show If',
                'value' => [],
                // 'value'  => [
                //     'compare' => 'or',
                //     'conditions' => [
                //         [ 'field_key' => '', 'value' => '', 'compare' => '=' ],
                //         [ 'field_key' => '', 'value' => '', 'compare' => '=' ],
                //         [ 'field_key' => '', 'value' => '', 'compare' => '=' ],
                //     ]
                    
                // ],
            ],
        ];

        return $fields;
    }

}