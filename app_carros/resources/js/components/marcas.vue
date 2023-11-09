<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Marcas</div>

                <div class="card-body">
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
                </div>
                <div class="card-footer">
                        <button class="float-right btn btn-primary" type="submit">buscar</button>
                    </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>

</script>
