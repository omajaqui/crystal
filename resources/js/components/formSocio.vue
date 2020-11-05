<template>      
    <form>
        <div class="row">
            <!-- EJEMPLO DE CLASES AL VALIDAR LOS CAMPOS -->
            <!-- <div class="col-md-6 col-sm-12">
                <div class="form-group has-success">
                    <label class="form-control-label">Input with success</label>
                    <input type="text" class="form-control form-control-success">
                    <div class="form-control-feedback">Success! You've done it.</div>
                    <small class="form-text text-muted">Example help text that remains unchanged.</small>
                </div>
                <div class="form-group has-warning">
                    <label class="form-control-label">Input with warning</label>
                    <input type="text" class="form-control form-control-warning">
                    <div class="form-control-feedback">Shucks, check the formatting of that and try again.</div>
                    <small class="form-text text-muted">Example help text that remains unchanged.</small>
                </div>
                <div class="form-group has-danger">
                    <label class="form-control-label">Input with danger</label>
                    <input type="text" class="form-control form-control-danger">
                    <div class="form-control-feedback">Sorry, that username's taken. Try another?</div>
                    <small class="form-text text-muted">Example help text that remains unchanged.</small>
                </div>
            </div> -->
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
                    <select class="form-control" v-model="numeroAsociado">
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
        data() {
            return {
                //datos precargados
                arrayNumerosAsociado: [],

                //formulario add socio
                tipoDocumento:'',
                documento:'',
                numeroAsociado:'',
                nombres:'',
                apellidos:'',
                correo:'',
                tFijo:'',
                celular:0,
                ciudad:'',
                barrio:'',
                direccion:'',
                cuotaMes:'',

                //validacioon de campo
                error:false,
                errorCampo:'',
            }
        },

        methods: {
            cerrarModal(){
                this.$emit('cerrarModal');
            },

            guardarSocio(){
                this.validarCampos();
                if(this.errorCampo) {
                    Sweet('info','Debe completar el campo '+this.errorCampo);
                }else{
                    this.guardarSocioConfirmar();
                }
            },

            validarCampos(){
                this.errorCampo=false;
                if(this.tipoDocumento == '')    {this.error = true; this.errorCampo='Tipo documento'; return;}
                if(this.documento == '')        {this.error = true; this.errorCampo='Documento'; return;}
                if(this.numeroAsociado == '')   {this.error = true; this.errorCampo='Número asociado'; return;}
                if(this.nombres == '')          {this.error = true; this.errorCampo='Nombres'; return;}
                if(this.apellidos == '')        {this.error = true; this.errorCampo='Apellidos'; return;}
                if(this.correo == '')           {this.error = true; this.errorCampo='Correo'; return;}
                if(this.tFijo == '')            {this.error = true; this.errorCampo='Teléfono fijo'; return;}
                if(this.celular == '')          {this.error = true; this.errorCampo='Celular'; return;}
                if(this.ciudad == '')           {this.error = true; this.errorCampo='Ciudad'; return;}
                if(this.barrio == '')           {this.error = true; this.errorCampo='Barrio'; return;}
                if(this.direccion == '')        {this.error = true; this.errorCampo='Dirección'; return;}
                if(this.cuotaMes == '')         {this.error = true; this.errorCampo='Valor cuota mensual'; return;}  
            },

            guardarSocioConfirmar(){
                loadingGif(0,'Guardando');
                let parametros = {
                    accion: 'guardarSocio',
                    tipoDocumento: this.tipoDocumento,
                    documento: this.documento,
                    numeroAsociado: this.numeroAsociado,
                    nombres: this.nombres,
                    apellidos: this.apellidos,
                    correo: this.correo,
                    tFijo: this.tFijo,
                    celular: this.celular,
                    ciudad: this.ciudad,
                    barrio: this.barrio,
                    direccion: this.direccion,
                    cuotaMes: this.cuotaMes
                };
                let url = 'confirmarGuardar';
                axios.post(url,parametros).then(response => {
                    let resp=response['data']['respuesta'];
                    if(resp['Continuar'] == 'S'){
                        this.cerrarModal();
                        this.restablecerCampos();
                        loadingGif(1,'');
                        this.$emit("refresh");
                        sweetBienHecho('Guardao Correctamente');
                    }else{
                        loadingGif(1,'');
                        Sweet('info',resp['Mensaje']);
                    } 
                })
                .catch(error => {
                    console.log(error);
                    loadingGif(1,'');
                });
            },

            cargarDatosForm(){
                loadingGif(0,'Cargado datos.');
                let url = 'consultarNumsAsociado';
                axios.post(url).then(response =>{
                    let resp = response.data.respuesta;
                    if(resp['Continuar'] == 'S') {
                        this.arrayNumerosAsociado = resp['Numeros'];
                    }else{
                        Sweet('info',resp['Mensaje']);
                    }
                    
                    loadingGif(1,'');
                }).catch(e => {
                    console.log(e);
                    loadingGif(1,'');
                });
            },

            restablecerCampos(){
                //formulario add socio
                this.tipoDocumento= '';
                this.documento= '';
                this.numeroAsociado= '';
                this.nombres= '';
                this.apellidos= '';
                this.correo= '';
                this.tFijo= '',
                this.celula= '';
                this.ciudad= '';
                this.barrio= '';
                this.direccion= '';
                this.cuotaMes= '';
            }

        },
            
        mounted() {
            console.log('Component mounted.');
            this.cargarDatosForm();
        }
    }
</script>
