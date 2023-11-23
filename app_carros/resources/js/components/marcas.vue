<template>
    <div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <content-component titulo="Marcas">
                <template v-slot:body>
                    <form action="#" method="get">
                        <input type="hidden" name="_token" :value="token">
                        <div class="row">
                        <div class="form-group col">
                            <input-component id-for="id" id-help="idHelp" text="id" text-help="digite o id da marca">
                                <input type="number" class="form-control" id="id" aria-describedby="idHelp" placeholder="ID">
                            </input-component>
                        </div>
                        <div class="form-group col">
                            <input-component id-for="nome" id-help="nomeHelp" text="nome" text-help="nome de marca">
                                <input type="text" class="form-control" id="text" aria-describedby="nomeHelp" placeholder="Nome">                                     
                            </input-component>
                        </div>
                    </div>
                    </form>
                    
                </template>
                <template v-slot:footer>
                    <button class="float-right btn btn-primary" type="submit">buscar</button>
                </template>
            </content-component>
            <content-component titulo="Correspondências de marcas">
                <template v-slot:body>
                    <table-component></table-component>
                </template>
                <template v-slot:footer>
                    <button class="float-right btn btn-primary" data-toggle="modal" data-target="#adicionar" type="submit">Adicionar</button>
                    <modal-component :csrf="token" id-modal="adicionar" title="Adicionar Marcas"></modal-component> 
                </template>
            </content-component>
        </div>
    </div>
</div>
</template>
<script>
import modal from './modal.vue'
    export default {
        components: { modal },        
        props:['token'],
    }
</script>
