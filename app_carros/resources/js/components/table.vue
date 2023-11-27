<template>
   <table class="table mt-5 table-hover">
        <thead>
            <tr>
            <th scope="col" v-for="t, key in titles" :key="key">{{ t.toLocaleUpperCase() }}</th>
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
            </tr>
        </tbody>
    </table>
</template>

<script>
import { kem } from 'node-forge';

    export default {
        props:['dataList','titles'],
    }
</script>
