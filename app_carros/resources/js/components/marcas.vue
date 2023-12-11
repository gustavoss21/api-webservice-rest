<template>
    <div class="container">
        <div class="row justify-content-center">
            {{ $store.state }}
            <div class="col-md-8">
                {{ marca }}
                {{ marca_id }}
                <!-- form shearch -->
                <content-component titulo="Marcas">
                    <template v-slot:body>
                        <form action="#" method="get">
                            <input type="hidden" name="_token" :value="token">
                            <div class="row">
                            <div class="form-group col">
                                <input-component id-for="id" id-help="idHelp" text="id" text-help="digite o id da marca">
                                    <input type="number" class="form-control" id="id" aria-describedby="idHelp" placeholder="ID" v-model="marca_id">
                                </input-component>
                            </div>
                            <div class="form-group col">
                                <input-component id-for="nome" id-help="nomeHelp" text="nome" text-help="nome de marca">
                                    <input type="text" class="form-control" id="nome" aria-describedby="nomeHelp" placeholder="Nome" v-model="marca">                                     
                                </input-component>
                            </div>
                        </div>
                        </form>
                        
                    </template>
                    <template v-slot:footer>
                        <button class="float-right btn btn-primary" type="button" @click="getMarcasByFilter()">buscar</button>
                    </template>
                </content-component>

                <!-- tabela de marcas -->
                <content-component titulo="Correspondências de marcas">
                    <template v-slot:body>
                        <table-component :dataList=marcas.data :titles=atributos_marca>
                            <modal-component id-modal="atualizar" title="Atualizar Marca">
                                <template v-slot:modal-message>
                                    <message-component :type="type" :message="message"></message-component>
                                </template>
                                <template v-slot:modal-body>
                                    <div class="modal-body">
                                        <form action="#" method="post" @submit.prevent="$event=>{console.log($event)}">
                                            <input type="hidden" name="_token" :value="token">

                                            <input-component text="Nome da marca" id-help="nameMarcaHelp" id-for="name" text-help="digite o nome da marca">
                                            <input type="text" id="name" name="nome" v-model="marca">
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
                        </table-component>
                    </template>
                    <template v-slot:footer>
                        <pagination-component>
                            <template>
                                <li v-for="p,key in marcas.links" :key="key" :class="p.active?'page-item active':'page-item' "><a class="page-link" @click="pagination(p.url)" v-html="p.label"></a></li>
                            </template>
                        </pagination-component>
                        <button class="float-right btn btn-primary" data-toggle="modal" data-target="#adicionar" type="submit">Adicionar</button>
                    </template>
                </content-component>
            </div>
            <!-- modal adicionar -->
            <modal-component id-modal="adicionar" title="Adicionar Marcas">
                <template v-slot:modal-message>
                    <message-component :type="type" :message="message" :id_message="id_message.add"></message-component>
                </template>
                <template v-slot:modal-body>
                    <div class="modal-body">
                        <form action="#" method="post" @submit.prevent="$event=>{console.log($event)}">
                            <input type="hidden" name="_token" :value="token">

                            <input-component text="Nome da marca" id-help="nameMarcaHelp" id-for="name" text-help="digite o nome da marca">
                            <input type="text" id="name" name="nome" v-model="marca">
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
            <!-- modal Mostrar -->
            <modal-component id-modal="show_marca" title="Ver Marca">
                <template v-slot:modal-message>
                    <message-component :type="type" :message="message"></message-component>
                </template>
                <template v-slot:modal-body>
                    <div class="modal-body row">
                        <div class="col">
                            <img :src="'/storage/' + $store.state.imagem" v-if="$store.state.imagem">
                        </div>
                        <div class="col">
                            <span class="h2">nome: {{ $store.state.nome }}</span><br>
                            <span class="h2">id: {{ $store.state.id }}</span>
                        </div>
                       
                    </div>
                </template>
            </modal-component> 
            <!-- modal Atualizar -->
            <modal-component id-modal="atualizar_marca" title="Atualisar Marca">
                <template v-slot:modal-message>
                    <message-component :type="type" :message="message" :id_message="id_message.update"></message-component>
                </template>
                <template v-slot:modal-body>
                    <div class="modal-body">
                        <form action="#" method="post" @submit.prevent="$event=>{console.log($event)}">
                            <input type="hidden" name="_token" :value="token">
                            <input type="hidden" name="id" :value="$store.state.id">
                            <input-component text="Nome da marca" id-help="nameMarcaHelp" id-for="name" text-help="digite o nome da marca">
                            <input type="text" id="name" name="nome" v-model="$store.state.nome" @change="changeNome()">
                            </input-component>
                            <input-component text="Imagem da marca" id-help="imagemMarcaHelp" id-for="imagem-marca" text-help="Selecione uma imagem para a marca">
                                <img :src="'/storage/'+$store.state.imagem" width="60" v-if="$store.state.imagem">
                                <input type="file" id="imagem-marca" name="imagem" @change="changeFile($event)">
                            </input-component>
                        </form>
                    </div>
                </template>
                <template v-slot:modal-footer>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="updateMarca()">Atualizar</button>
                    </div>
                </template>
            </modal-component>
            <!-- modal remover -->
            <modal-component id-modal="remover_marca" title="Remover Marca">
                <template v-slot:modal-message>
                    <message-component :type="type" :message="message" :id_message="id_message.remove"></message-component>
                </template>
                <template v-slot:modal-body>
                    <div class="modal-body">
                        <form action="#" method="post" @submit.prevent="$event=>{console.log($event)}">
                            <input type="hidden" name="_token" :value="token">
                            <input-component text="ID da marca" id-help="nameMarcaHelp" id-for="id" text-help="digite o nome da marca">
                            <input type="text" id="id" name="id" v-model="$store.state.id" disabled>
                            </input-component>
                            <input-component text="Nome da marca" id-help="nameMarcaHelp" id-for="name" text-help="digite o nome da marca">
                            <input type="text" id="name" name="nome" v-model="$store.state.nome" disabled>
                            </input-component>
                        </form>
                    </div>
                </template>
                <template v-slot:modal-footer>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="removeMarca()">Remover</button>
                    </div>
                </template>
            </modal-component>

        </div>
    </div>
</template>
<script>
import { watch } from 'vue'
import modal from './modal.vue'
import Pagination from './pagination.vue'
    export default {
        components: { modal, Pagination },        
        props:['token'],
        data(){
        return{
            marca :'',
            change_nome: false,
            marca_id:'',
            marca_img: '',
            imagem: [],
            marca_nome: '',
            message: '',
            type: '',
            marcas: {data:[]},
            urlBasy: 'http://127.0.0.1:8000/api/v1/marca',
            uriFilter: '',
            uriPagination: '',
            atributos_marca: ['id','nome','imagem'],
            id_message: {
                'remove':'remove_message',
                'add': 'add_message',
                'update':'update_message'
            }
           
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

            changeNome(){
                this.change_nome = true
            },

            addMarca(){
                let data = new FormData()
                data.append('nome', this.marca)
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
                            this.message_alert('success','enviado com sucesso',this.id_message.add)
                        }
                    )
                    .catch(error => {
                            this.message_alert('danger','hover um erro inesperado',this.id_message.add)
                            console.log(error)
                        }
                    )
            },

            getMarcas(){

                let uri = this.uriPagination && this.uriFilter ? 
                        '?'+this.uriPagination +'&'+ this.uriFilter : 
                        '?'+this.uriPagination + this.uriFilter

                let url = this.urlBasy+uri
                axios.get(url)
                    .then(response=>{
                        this.marcas = response.data
                    })
                    .catch(error => {console.log(error)})

                this.uriPagination = ''
                

            },

            removeMarca(){

                let url = this.urlBasy+'/'+this.$store.state.id
                let formData = new FormData()
                formData.append('_method', 'delete')

                let config = {
                    headers : {
                        'Accept': 'application/json',
                        'Authorization' : this.getToken
                    }
                }

                axios.post(url,formData,config)
                    .then(response=>{
                        this.message_alert('success','A marca foi removida com sucesso',this.id_message.remove)
                        this.getMarcas()
                        
                    })
                    .catch(error => {
                        this.message_alert('danger','Houve um erro inesperado, ERROR: '+error,this.id_message.remove)
                            console.log(error)}
                        )

                this.uriPagination = ''


            },

            getMarcasByFilter(){
                let filtro = ''
                if(this.marca){
                    filtro+='nome:like:'+this.marca+'%'
                }
                if(this.marca_id){
                    filtro == '' ? (filtro +='id:' + this.marca_id) : (filtro +=';id:'+ this.marca_id)
                }
                if (filtro === ''){
                    return this.getMarcas()
                }

                this.uriFilter = 'filtro='+filtro
                this.getMarcas()   
            },

            message_alert(type,message,element){
                let div_message = document.querySelector('#'+element);
                if(!div_message) return
                this.type = type;
                this.message = message;

                div_message.removeAttribute('hidden')

                window.setTimeout(
                    function(){
                        div_message.setAttribute('hidden',true)

                },5000)
            },

            pagination(url){
                if(!url) return
                
                this.uriPagination = url.split('?')[1]
                this.getMarcas()
            },

            updateMarca(){
                let url = this.urlBasy+'/'+this.$store.state.id
                let data = new FormData()

                this.change_nome ? data.append('nome', this.$store.state.nome) : 

                this.change_nome = false
                data.append('imagem', this.imagem[0])
                data.append('id', this.$store.state.id)
                data.append('_method', 'PATCH')
                let config = {
                    headers : {
                        'Content-Type' : 'multipart/form-data',
                        'accept': 'application/json',
                        'Authorization' : this.getToken
                    }
                }
                console.log(this.marcas.data)

                axios.post(url, data, config)
                    .then(
                        response => {
                            this.message_alert('success','enviado com sucesso',this.id_message.add)
                            this.marcas.data.forEach((object,index) => {
                                if(object.id === response.data.id){
                                    console.log(index)
                                    console.log(response.data)
                                    this.marcas.data[index] = response.data
                                } 
                            })
                            console.log(this.marcas.data)

                        }
                    )
                    .catch(error => {
                            this.message_alert('danger','hover um erro inesperado',this.id_message.add)
                            console.log(error)
                        }
                    )
            }

        },
        mounted(){
            this.getMarcas()
        }
    }
</script>
