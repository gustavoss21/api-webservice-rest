<template>
    <div :id="id_message" class="alert" :class="'alert-'+type" role="alert">
       {{ message }}
       testse
    </div>
</template>

<script>
import modal from './modal.vue'
    export default {
        props:['type','message','id_message']
    }
</script>
