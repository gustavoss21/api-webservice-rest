<template>
    <div>
        <label :for="idFor">{{text}}</label><br>
        <slot></slot>
        <small :id="idHelp" class="form-text text-muted">{{textHelp}}</small>
        <br>
    </div>
</template>

<script>
    export default {
        props:['text','idHelp','idFor','textHelp']
    }
</script>
