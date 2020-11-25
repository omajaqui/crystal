<template>
    <div>
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <h4 class="text-blue h4">Agregar una cuota</h4>
            </div>
            <div class="wizard-content">
                <form class="tab-wizard wizard-circle wizard" v-if="arraySocios.length>0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>SOCIO</label>
                                <multiselect 
                                    v-model="socioSelecionado" 
                                    :options="arraySocios"
                                    :close-on-select="true"                                     
                                    :custom-label="customLabel"
                                    placeholder="Seleccione un socio" 
                                    @select="onSelect"
                                >
                                </multiselect>
                                <!-- <pre>{{socioSelecionado}}</pre> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CUOTA MENSUAL ESTABLECIDA</label>
                                <pre class="textoResalt">{{cuotaMensual | separadorMiles}}</pre>
                            </div>
                        </div>                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CORRESPONDE AL MES</label>
                                <multiselect 
                                    v-model="mes" 
                                    :options="arrayMeses"                                   
                                    label="nombre"
                                    track-by="id"
                                    placeholder="Seleccione un mes" 
                                >
                                </multiselect>
                            </div>
                            <div class="form-group">
                                <label>VALOR CUOTA:</label>
                                <input class="form-control" type="number" v-model="valorCuotaRecivida">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>DESCRIPCIÓN (opcional) :</label>
                                <textarea class="form-control" max-rows="2" v-model="descripcion"></textarea>
                            </div>
                        </div>                        
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">                                
                            <button class="btn btn-primary btn-lg btn-block" type="buttton" @click="guardarCuota">GUARDAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import { mapMutations } from 'vuex';
    import Multiselect from 'vue-multiselect';
    export default {
        components: { Multiselect },
        data() {
            return {                
                arraySocios: [],
                arrayMeses: [
                    {nombre: 'Enero', id: '0'},
                    {nombre: 'Febrero', id: '1'},
                    {nombre: 'Marzo', id: '2'},
                    {nombre: 'Abril', id: '3'},
                    {nombre: 'Mayo', id: '4'},
                    {nombre: 'Junio', id: '5'},
                    {nombre: 'Julio', id: '6'},
                    {nombre: 'Agosto', id: '7'},
                    {nombre: 'Septiembre', id: '8'},
                    {nombre: 'Octubre', id: '9'},
                    {nombre: 'Noviembre', id: '10'},
                    {nombre: 'Diciembre', id: '11'}
                ],

                //variables de formulario
                socioSelecionado: '',
                cuotaMensual: '',
                mes:'',
                valorCuotaRecivida: '',
                descripcion:'',                

                //validacion de campos
                error: false,
                campoError: '',
            };
        },
        computed: {
            ...mapState(['idPersonaGlobal','tokenGlobal','nombreUsuario']),
        },
        methods: {
            ...mapMutations(['restablecer']),

            customLabel (option) {
                return `${option.nombreCompleto} - Documento: ${option.documento}`
            },

            onSelect(){
                cargandoGif(0,'Cargando');
                setTimeout(() => {
                    this.cuotaMensual = format(this.socioSelecionado['valorCuotaMes']);
                    cargandoGif(1,''); 
                }, 500);                
            },

            listarSoicos() {
                cargandoGif(0,'Cargando socios');
                const data = { 
                    accion: 'sociosCuotas'
                };
                const url = 'listarSocios';
                this.peticionComun(url,data); 
            },
            validarCampos(){   
                this.error = false;
                this.campoError = '';             
                if (this.socioSelecionado == '' || this.socioSelecionado == []) { this.error = true; this.campoError="Socio"; return }
                if (this.mes == '' || this.mes == []) {this.error = true; this. campoError='Mes'; return }
                if (this.valorCuotaRecivida == '') {this.error = true; this.campoError="Valor Cuota"; return}
                if (this.valorCuotaRecivida < this.cuotaMensual ) {
                    this.error = true; 
                    this.campoError="la cuota mensual minima para el socio seleccionado es de: "+format(this.cuotaMensual); 
                    return;
                }

            },
            guardarCuota(){
                this.validarCampos();
                if(this.error){
                    Sweet('info','Debe verificar: '+this.campoError);
                }else{
                    cargandoGif(0,'Guardando Cuota.');
                    const url = 'gestionCuotas';
                    const data = {
                        accion: 'MensualGuardar',
                        id: this.idPersonaGlobal,
                        documentoSocio: this.socioSelecionado['documento'],
                        mes: this.mes['nombre'],
                        cuota: this.valorCuotaRecivida,
                        descripcion: this.descripcion
                    };
                    this.peticionComun(url,data);
                }
            },

            /*
            ** Fecha: 24/11/2020
            ** Autor: Omar jaramillo
            ** descripcion: limpia los campos del formulario cuota mensual
            */
            limpiarCampos(){
                this.socioSelecionado = '';
                this.cuotaMensual = '';
                this.mes = '';
                this.valorCuotaRecivida = '';
                this.descripcion ='';
            },

            /*
            ** Fecha: 20/11/2020
            ** Autor: Omar jaramillo
            ** descripcion: Peticion comun Axios devuelve response para ser manejado en metodo decidir()
            */
            peticionComun(url,data){
                cargandoGif(0,'Cargando...')
                axios({
                    method: 'post',
                    url,
                    data,
                    params: {'HTTP_CONTENT_LANGUAGE': self.language},
                    headers: {'Authorization': 'Bearer '+this.tokenGlobal }
                }).then(async response => {
                    //validacion cuando el token expire
                    if(response['data']['status'] == 'Token is Expired') {                        
                        this.decidir('','Token is Expired');                        
                    }else{
                        let resp = response.data.respuesta;
                        this.decidir(resp,data.accion);
                    }
                }).catch(e =>{
                    console.log(e);
                    cargandoGif(1,'');
                });
            },

            /*
            ** Fecha: 20/11/2020
            ** Autor: Omar jaramillo
            ** descripcion: recibe response de peticion axios y una accion para decidir lo que se hara
            */
            decidir(resp,accion){
                // control cuando la peticion devuelve token expired
                if(accion == 'Token is Expired'){
                    this.restablecer(); 
                    sweetSesionCaduca('La sesión ha caducado'); 
                }
                
                if(resp['Continuar'] == 'S'){
                    switch(accion){                      

                        case 'sociosCuotas':                            
                            this.arraySocios = resp['Socios'];                         
                        break;

                        case 'MensualGuardar':
                            this.limpiarCampos();
                        break;
                        
                    }
                }

                //cerrar el loading desde cualquier accion
                if (accion != 'Token is Expired'){
                    cargandoGif(1,'');
                    if(accion == 'MensualGuardar') {Sweet('success','Cuota guardada.');}
                }                

                //mostar sweet si resp['Continuar']=='N' en cualquier accion
                if(resp['Continuar'] == 'N'){
                    Sweet('info',resp['Mensaje']);
                }
            }
        },
        
        mounted() {
            this.listarSoicos();
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
     .textoResalt{
        text-align: center;
        font-size: 25px;
        font-weight: bold;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }
</style>
