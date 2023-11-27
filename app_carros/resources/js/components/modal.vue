<template>
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" :id="idModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{title}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <slot name="modal-message"></slot>
                    <slot name="modal-body"></slot>
                    <slot name="modal-footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { strict } from 'assert'
import modal from './modal.vue'

    export default {
       props:['idModal','title']
    }
</script>
