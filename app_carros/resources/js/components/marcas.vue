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
                        <table-component :dataList=marcas :titles=atributos_marca></table-component>
                    </template>
                    <template v-slot:footer>
                        <button class="float-right btn btn-primary" data-toggle="modal" data-target="#adicionar" type="submit">Adicionar</button>
                    </template>
                </content-component>
            </div>
            <modal-component id-modal="adicionar" title="Adicionar Marcas">
                <template v-slot:modal-message>
                    <message-component :type="type" :message="message"></message-component>
                </template>
                <template v-slot:modal-body>
                    <div class="modal-body">
                        <form action="#" method="post" @submit.prevent="$event=>{console.log($event)}">
                            <input type="hidden" name="_token" :value="token">

                            <input-component text="Nome da marca" id-help="nameMarcaHelp" id-for="name" text-help="digite o nome da marca">
                            <input type="text" id="name" name="nome" v-model="nome">
                            </input-component>
                            <input-component text="Imagem da marca" id-help="imagemMarcaHelp" id-for="imagem-marca" text-help="Selecione uma imagem para a marca">
                                <input type="file" id="imagem-marca" name="imagem" @change="changeFile($event)">
                            </input-component>
                        </form>
                    </div>
                </template>
                <template v-slot:modal-footer>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="addMarca()">Adicionar</button>
                    </div>
                </template>
            </modal-component> 
        </div>
    </div>
</template>
<script>
import modal from './modal.vue'
    export default {
        components: { modal },        
        props:['token'],
        data(){
        return{
            nome :'',
            imagem: [],
            message: '',
            type: '',
            marcas:'',
            urlBasy: 'http://127.0.0.1:8000/api/v1/marca',
            atributos_marca: ['id','nome','imagem']
        }},
        computed:{
            getToken(){
                let cookie = document.cookie.split(';')
                
                let token = cookie.find(
                        index => index.indexOf('token=') ==! '-1'
                    ).split('=')[1]

                return 'Bearer ' + token
            }
        },

        methods:{
            changeFile($e){
                this.imagem = $e.target.files
            },

            addMarca(){
                let data = new FormData()
                data.append('nome', this.nome)
                data.append('imagem',this.imagem[0])

                let config = {
                    headers : {
                        'Content-Type' : 'multipart/form-data',
                        'accept': 'application/json',
                        'Authorization' : this.getToken
                    }
                }
                console.log(config)
                axios.post(this.urlBasy, data, config)
                    .then(
                        response => {
                            console.log(response)
                            this.message_alert('success','enviado com sucesso')
                        }
                    )
                    .catch(error => {
                            this.message_alert('danger','hover um erro inesperado')
                            console.log(error)
                        }
                    )
            },

            getMarcas(){
                let url = this.urlBasy + '?atributos='+String(this.atributos_marca)

                axios.get(url)
                    .then(response=>{
                        this.marcas = response.data
                        console.log(this.marcas)
                        // console.log()
                    })
                    .catch(error => {console.log(error)})
                

            },

            message_alert(type,message){
                let div_message = document.querySelector('#message');
                this.type = type;
                this.message = message;

                div_message.removeAttribute('hidden')
                window.setTimeout(
                    function(){
                        div_message.setAttribute('hidden',true)

                },5000)
            }
        
        },
        mounted(){
            this.getMarcas()
        }
    }
</script>
