<template>
    <div id="message" class="alert" :class="'alert-'+type" role="alert" hidden>
       {{ message }}
    </div>
</template>

<script>
import modal from './modal.vue'
    export default {
        props:['type','message']
    }
</script>
