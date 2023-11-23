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
                    {{ nome }}
        {{ imagem }}
                    <div class="modal-body">
                        <form action="#" method="post" @submit.prevent="$event=>{console.log($event)}">
                            <input type="hidden" name="_token" :value="csrf">

                            <input-component text="Nome da marca" id-help="nameMarcaHelp" id-for="name" text-help="digite o nome da marca">
                            <input type="text" id="name" name="nome" v-model="nome">
                            </input-component>
                            <input-component text="Imagem da marca" id-help="imagemMarcaHelp" id-for="imagem-marca" text-help="Selecione uma imagem para a marca">
                                <input type="file" id="imagem-marca" name="imagem" @change="changeFile($event)">
                            </input-component>
                            </form>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="addMarca()">Adicionar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import modal from './modal.vue'

    export default {
       props:['idModal','title','csrf'],
       data(){
        return{
            nome :'',
            imagem: []
        }},
        methods:{
            changeFile($e){
                this.imagem = $e.target.files
            },

            addMarca(){
                let url = 'http://127.0.0.1:8000/api/v1/marca';
                let data = new FormData()
                data.append('nome', this.nome)
                data.append('imagem',this.imagem[0])

                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data',
                        'accept': 'application/json',
                    }
                }
                axios.post(url, data, config)
                    .then(
                        response => {
                            console.log(response)
                        }
                    )
                    .catch(
                        error => console.log(error)
                    )
            }
        }
    }
</script>
