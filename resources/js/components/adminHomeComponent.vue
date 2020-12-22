<template>
    <div>
        <div class="card-box pd-20 height-100-p mb-30">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <img src="vendors/images/banner-img.png" alt="">
                </div>
                <div class="col-md-8">
                    <h4 class="font-20 weight-500 mb-10 text-capitalize">
                        Bienvenid@ <div class="weight-600 font-30 text-blue" v-text="nombreUsuario"></div>
                    </h4>                    
                    <input type="hidden" :value="idpersona" id="idPersona">
                    <input type="hidden" :value="nombreFoto" id="nombreF">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <img src="vendors/images/product-1.jpg" alt="">
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0" v-text="cantidadSocios"></div>
                            <div class="weight-600 font-14">Socios</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <img src="vendors/images/success.png" alt="">
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0">Cuotas</div>
                            <div class="weight-600 font-14">Registrar</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <img src="vendors/images/product-img4.jpg" alt="">
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0">Actividades</div>
                            <div class="weight-600 font-14">Ver</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <img src="vendors/images/product-2.jpg" alt="">
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0">Seguimiento</div>
                            <div class="weight-600 font-14">Ver</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 mb-30">
                <div class="card-box height-100-p pd-20">
                    <h2 class="h4 mb-20">Activity</h2>
                    <div id="chart5"></div>
                </div>
            </div>
            <div class="col-xl-4 mb-30">
                <div class="card-box height-100-p pd-20 cPass"  @click="abrirModal(1)">
                    <h2 class="h4 mb-20">Cambiar Contraseña a Socio</h2>
                </div>
            </div>
        </div>


        <!-- MODAL CAMBIO DE CONTRASEÑA A SOCIO-->
        <div class="modal fade bs-example-modal-lg" :class="{'mostrar' : modalPass}" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="titleModal"></h4>
                        <button type="button" class="close" @click="cerrarModal(1)">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>SOCIO</label>
                                    <multiselect 
                                        v-model="socioSelecionado" 
                                        :options="arraySocios"
                                        :close-on-select="true"                                     
                                        :custom-label="customLabel"
                                        placeholder="Seleccione un socio"
                                    >
                                    </multiselect>
                                </div>
                            </div>
                        </div>
                        <p class="text-center text-blu">La contraseña se restablecera a el mismo numero de documento</p>
                    </div> 
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal(1)">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="cambiarContrasenia()">Aceptar</button>
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
        props:['token', 'idpersona'],
        components: { Multiselect },
        data(){
            return{
                idPersona:'',
                nombreF: '',
                responseData: [], 
                
                cantidadSocios: 0,

                arraySocios: [],
                socioSelecionado: [],

                //MODALES
                modalPass: 0,
                titleModal:'',               

                //validar error
                error: false,
                campoError:'',
            };
        },
        computed: {
            ...mapState(['idPersonaGlobal','tokenGlobal','nombreUsuario','nombreFoto']),
        },
        methods: {
            ...mapMutations(['restablecer']),

            customLabel (option) {
                return `${option.nombreCompleto} - Documento: ${option.documento}`
            },

             /*
             ** fecha: 07-11-2020
             ** descripcion: consulta los datos de la persona qu inicio sesion y los guardo en el store
             */
            inicio(){
                cargandoGif(0,'Cargando datos iniciales');
                if(this.tokenGlobal==''){window.location.replace("./"); }
                const url = 'datosUsuario';
                const data = {
                    accion: 'datosU', 
                    idUSuario: this.idPersonaGlobal 
                };               
                this.peticionComun(url,data);                             
            },

            /*
            ** autor: Omar Jaramillo
            ** fecha: 15-12-2020
            ** descripcion: abre modal seun el parametro recivido
            */
            abrirModal(level){
                switch(level){
                    case 1:
                        cargandoGif(0,'Cargando...')
                        const url = 'seguimientos';
                        const data = {
                            accion: 'CCS',
                            id: this.idPersonaGlobal
                        }
                        this.peticionComun(url,data);                       

                        this.titleModal = 'Restablecer contraseña a un socio';
                        this.modalPass = 1;
                    break;
                }
            },

            cerrarModal(level){
                switch(level){
                    case 1:
                        this.titleModal = '';
                        this.modalPass = 0;
                    break;
                }
            },

           
            

            /*
            ** Fecha: 15-12-2020
            ** Autor: Omar jaramillo
            ** descripcion: validar los campos del formulario, cambio de contraseña, antes de hacer la peticion que realizara el cambio
            */
            validarCampos(){
                this.error = false;
                this.campoError = '';               
                if(!this.socioSelecionado.documento) {
                    this.error=true; this.campoError='Seleccione un socio'; 
                    return; 
                }                
            },


            /*
            ** Fecha: 23/11/2020
            ** Autor: Omar jaramillo
            ** descripcion: realiza peticion para realizar el cambio de contraseña
            */
            cambiarContrasenia(){
                this.validarCampos();
                if(this.error) {
                    Sweet('info','Por favor revisa: '+this.campoError);
                }else{
                    cargandoGif(0,'Cambiando Contraseña');
                    const url = 'restablecerContrasenia';
                    const data = {
                        accion: 'restablecer',
                        documento: this.socioSelecionado['documento'],
                        id: this.idPersonaGlobal,
                    }
                    this.peticionComun(url,data);
                }
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
                        case 'datosU':
                            const datos = resp['DatosUsuario'][0];
                            this.$store.state.nombreUsuario = datos['nombres']+' '+datos['apellidos'];
                            this.$store.state.nombreFoto = datos['nombreFoto'];
                            this.cantidadSocios = resp['Cantidad'];
                        break;

                        case 'CCS':
                            this.arraySocios = resp['DataRespuesta']['Socios']
                        break;

                        case 'restablecer':
                            this.titleModal = '';
                            this.modalPass = 0;
                            setTimeout(() => {
                                Sweet('success',resp['Mensaje']);
                            }, 1000);                            
                        break;
                    }
                }

                //cerrar el loading desde cualquier accion
                if (accion != 'Token is Expired'){
                    cargandoGif(1,'');
                }                

                //mostar sweet si resp['Continuar']=='N' en cualquier accion
                if(resp['Continuar'] == 'N'){
                    Sweet('info',resp['Mensaje']);
                }
            }
        },
        mounted() {
            this.idPersona = $("#idPersona").val();
            this.nombreF   = $("#nombreF").val();
            //guarda datos de sesion globalmente en el store->vuex 
            this.$store.state.tokenGlobal = this.token;
            this.$store.state.idPersonaGlobal = this.idPersona;            
            this.inicio();
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
    .cPass:hover{
        transform: scale(1.3);
        transition: ease;
        cursor:pointer;        
    }

    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a;
    }

    .ojo{
        position: fixed;
        margin-left: -12%;
        margin-top: 10px;
        
    }
    
</style>
