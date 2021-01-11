import validator from './../validation';
import props from './input-field-props.js';

export default {
    mixins: [ props, validator ],
    model: {
        prop: 'value',
        event: 'input'
    },
    
    created() {
        if ( typeof this.value !== 'undefined' ) {
            this.local_value = ( true === this.value || 'true' === this.value || 1 === this.value || '1' === this.value ) ? true : false;
        }

        this.$emit('update', this.local_value)
    },

    computed: {
        toggleClass() {
            return {
                'active': this.local_value,
            }
        }
    },

    data() {
        return {
            local_value: false
        }
    },

    methods: {
        toggleValue() {
            this.local_value = ! this.local_value;
            this.$emit('update', this.local_value);

            this.handleDataOnChange();
        },

        handleDataOnChange() {
            let task = this.dataOnChange;
            let cachedData = this.cachedData;

            if ( ! cachedData ) { return; }
            if ( cachedData.value == this.local_value ) { return; }

            if ( ! ( task && typeof task === 'object' ) ) { return; }
            if ( ! task.action ) { return; }
            if ( typeof task.action !== 'string' ) { return; }

            this.$emit( 'do-action', task );
        },
    }
}