<template>
    <form>
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Tipo documento</label>
                    <select class="form-control" v-model="tipoDocumento">
                        <option value="RC">Registro civil</option>
                        <option value="TI">Tarjeta de identidad</option>
                        <option value="CC">Cédula de ciudadania</option>
                        <option value="DNI">DNI (Documento Identificación Nacional)</option>
                        <option value="CE">Cédula extranjeria</option>
                    </select>
                </div>                
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Documento</label>
                    <input type="number" class="form-control" v-model="documento">                    
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Numero asociado</label>
                    <select class="form-control" v-model="numeroAsociado" disabled>
                        <option v-for="item in arrayNumerosAsociado" :key="item.idNumeroAsosciado" :value="item.numeroAsociado">{{item.numeroAsociado}}</option>
                    </select>                  
                </div>
            </div>           
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" class="form-control" v-model="nombres">                    
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" class="form-control" v-model="apellidos">                    
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Correo</label>
                    <input type="email" class="form-control" v-model="correo">                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Ciudad</label>
                    <input type="text" class="form-control" v-model="ciudad">                    
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Barrio</label>
                    <input type="text" class="form-control" v-model="barrio">                    
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Dirección</label>
                    <input type="email" class="form-control" v-model="direccion">                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Teléfono fijo</label>
                    <input type="number" class="form-control" v-model="tFijo">                    
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Celular</label>
                    <input type="text" class="form-control" v-model="celular">                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label>Valor cuota mensual</label>
                    <input type="number" class="form-control" v-model="cuotaMes" placeholder="$">                    
                </div>
            </div>            
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
            <button type="button" class="btn btn-primary" @click="guardarSocio()">Guardar</button>
        </div>
    </form>
</template>

<script>
    export default {
        props: ['data','modalEditarSocio'],
        data() {
            return {

            };
        },
        methods: {
            cerrarModal(){
                this.$emit('cerrarModal');
            },
        },
        
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
