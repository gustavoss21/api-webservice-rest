<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <content-component titulo="Marcas">
                <template v-slot:body>
                    <div class="row">
                        <div class="form-group col">
                            <input-componet id-for="id" id-help="idHelp" text="id" text-help="digite o id da marca">
                                <input type="number" class="form-control" id="id" aria-describedby="idHelp" placeholder="ID">
                            </input-componet>
                        </div>
                        <div class="form-group col">
                            <input-componet id-for="nome" id-help="nomeHelp" text="nome" text-help="nome de marca">
                                <input type="text" class="form-control" id="text" aria-describedby="nomeHelp" placeholder="Nome">                                
                            </input-componet>
                        </div>
                    </div>
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
                    <button class="float-right btn btn-primary" type="submit">Adicionar</button>    
                </template>
            </content-component>

        </div>
    </div>
</div>
</template>
<script>

</script>
