<template>
    <div>
        <label :for="idFor">{{text}}</label>
        <slot></slot>
        <small :id="idHelp" class="form-text text-muted">{{textHelp}}</small>
    </div>
   
</template>

<script>
    export default {
        props:['text','idHelp','idFor','textHelp']
    }
</script>
