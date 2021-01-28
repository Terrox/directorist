<template>
    <div class="cptm-form-group" :class="formGroupClass">
        <label v-if="( label.length )" :for="name" class="cptm-form-group-label">{{ label }}</label>
        <p class="cptm-form-group-info" v-if="description.length" v-html="description"></p>

        <div class="">
            <select-field 
                label="Condition"
                :options="[ { value: 'or', label: 'Or' } ]"
            />
        </div>
    </div>
</template>

<script>
import show_if_feild from './../../../../mixins/form-fields/show-if-field';

export default {
    name: 'show-if-field-theme-default',
    mixins: [ show_if_feild ],
}
</script>