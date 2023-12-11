<template>
   <table class="table mt-5 table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="t, key in titles" :key="key">{{ t.toLocaleUpperCase() }}</th>
                <th>...</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="object in dataList" :key="object.id">
                
                <td :scope="key==0?'row':''" v-for="t, key in titles" :key="key">
                    <template v-if="t=='imagem'">
                        <img :src="'/storage/'+ object[t]" width="30">
                    </template>
                    <template v-else>{{object[t]}}</template>
                </td>
                <td>
                    <button class="btn btn-outline-primary" data-toggle="modal" data-target="#atualizar_marca" @click="setItemMarca(object)">Atualizar</button>
                    <button data-toggle="modal" data-target="#show_marca" class="btn btn-outline-primary" @click="setItemMarca(object)">Visualizar</button>
                    <button class="btn btn-outline-danger" data-toggle="modal" data-target="#remover_marca" @click="setItemMarca(object)">Remover</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import { kem } from 'node-forge';

    export default {
        props:['dataList','titles'],
        methods:{
            setItemMarca(object){
                this.$store.replaceState(object)                
            }
        }
    }
</script>
