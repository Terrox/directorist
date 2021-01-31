import { mapState } from 'vuex';
import helpers from '../helpers';
import validator from '../validator';
import props from './input-field-props.js';

export default {
    mixins: [ props, helpers, validator ],
    model: {
        prop: 'value',
        event: 'update'
    },

    created() {
        this.setup();
    },

    watch: {
        finalValue() {
            this.$emit( 'update', this.finalValue );
        }
    },

    computed: {
        finalValue() {
            return {
                compare: this.compare,
                conditions: this.conditions,
            }
        },

        conditionalFields() {

            // console.log( this.fieldList );

            let conditional_fields = {
                field: {
                    type: 'select',
                    label: 'Field',
                    value: '',
                    skip: this.skip,
                    options: this.fieldList,
                },

                compare: {
                    type: 'select',
                    label: 'Compare',
                    value: '==',
                    options: [
                        { value: '==', label: 'Equal' },
                        { value: '!=', label: 'Not Equal' },
                        { value: '<', label: 'Less then' },
                        { value: '<=', label: 'Equal or Less then' },
                        { value: '>=', label: 'Equal or greater' },
                        { value: '>', label: 'greater' },
                    ],
                },

                value: {
                    type: 'text',
                    label: 'Value',
                    value: '',
                }
            };


            return conditional_fields;
        },
    },

    data() {
        return {
            compare: 'or',

            compareOptions: [
                { value: 'or', label: 'Or' }, 
                { value: 'and', label: 'And' }
            ],

            conditions: [],
        }
    },

    methods: {
        setup() {

        }
    },
}