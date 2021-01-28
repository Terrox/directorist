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
        
    },

    watch: {
        
    },

    computed: {
        
    },

    data() {
        return {
            
        }
    },

    methods: {
        
    },
}