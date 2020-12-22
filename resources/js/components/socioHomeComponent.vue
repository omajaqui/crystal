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
                    <h3 class="text-capitalize">número de asosciado: {{ numeroAsociado }}</h3>                    
                    <input type="hidden" :value="idpersona" id="idPersona">
                    <input type="hidden" :value="nombreFoto" id="nombreF">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-12 marginB">
                <div class="card-box height-100-p widget-style1">
                   <label>Mi ahorro a la fecha: </label>
                   <p style="font-size: 25px;">$ <strong>{{ miAhorro | separadorMiles}}</strong> </p>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 marginB">
                <div class="card-box height-100-p widget-style1">
                   <label>Mi estado en la natillera:</label>
                   <p :class="{'icon_estado_a':miEstadoNatillera==1}" v-if="miEstadoNatillera==1">
                       <i class="icon-copy dw dw-checked"></i>
                        Al día
                    </p>
                   <p :class="{'icon_estado_b':miEstadoNatillera==2}" v-if="miEstadoNatillera==2">
                       <i class="icon-copy dw dw-warning-1"></i> 
                       Debe validar sus cuotas
                    </p>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 marginB">
                <div class="card-box height-100-p widget-style1">
                   <label>Polla del mes: <b class="text-blue">{{ pollaMes }}</b></label>
                   <p>Mi estado: 
                        <span :class="{'icon_estado_a':pollaEstado==1}" v-if="pollaEstado==1">
                           <i class="icon-copy dw dw-checked"></i> Al dia
                        </span>
                        <span :class="{'icon_estado_b':pollaEstado==2}" v-if="pollaEstado==2">
                           <i class="icon-copy dw dw-warning-1"></i> Falta pago
                        </span>  
                    </p>
                   <p>Participantes a la fecha: <b class="text-blue">{{ pollaCantPart }}</b> </p>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
             <div class="col-md-6 col-sm-12">
                <div class="card-box height-100-p widget-style1">
                   <label>Última actividad:</label>
                   <p>Nombre: {{ nombreUltimaAct | mayusculas }}</p>
                   <p>Ganador: {{ ganadorUltimaAct | mayusculas }}</p>
                </div>
            </div>
        </div>

        <!-- MODAL CAMBIO DE CONTRASEÑA -->
        <div class="modal fade bs-example-modal-lg" :class="{'mostrar' : modalPass}" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="titleModal"></h4>
                    </div>
                    <div class="modal-body">                        
                        <div class="row">                          

                            <div class="input-group custom col-md-6 col-sm-12">
                                <input :type="tipoNewPass" class="form-control form-control-lg" v-model="newPass" placeholder="Contraseña Nueva">
                                <div class="input-group-append custom">
                                    <span class="input-group-text ojo"><i :class="iconoEyeNew" @click="verCampo('NewPass')"></i></span>
                                </div>
                            </div>

                            <div class="input-group custom col-md-6 col-sm-12">
                                <input :type="tipoNewPass" class="form-control form-control-lg" v-model="confirmPass" placeholder="Confirmar Contraseña">                                
                            </div>                           
                        </div>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn btn-primary" @click="cambiarContrasenia()">Aceptar</button>
                    </div>                    
                </div>
            </div>
        </div>

        <!-- MODAL CON LAS REGLAS DEL NEGOCIO -->
        <div class="modal fade bs-example-modal-lg" :class="{'mostrar' : modalReglas}" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="titleModal"></h4>
                        <button type="button" class="close" @click="cerrarModal(1)">×</button>
                    </div>
                    <div class="modal-body">                        
                        <comun-reglas></comun-reglas>
                    </div>
                    <div class="modal-footer">                                            
                        <button type="button" class="btn btn-primary" @click="cerrarModal(1)">Aceptar</button>
                    </div>                    
                </div>
            </div>
        </div>  

    <br>         
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import { mapMutations } from 'vuex';

    export default {
        props:['token', 'idpersona'],
        data(){
            return{
                idPersona:'',
                nombreF: '',
                responseData: [], 

                numeroAsociado: '',
                miAhorro: '',
                nombreUltimaAct: '',
                ganadorUltimaAct: '',
                miEstadoNatillera: 0,

                //variables modales
                modalPass: 0,
                modalReglas: 0,
                titleModal: '',

                //campos formulario cambiar contraseña                
                newPass: '',
                confirmPass: '',

                //estado de campos
                tipoNewPass: 'password',
                iconoEyeNew: 'icon-copy fa fa-eye', //icon-copy fa fa-eye-slash

                //validacion de campos formulario
                error: false,
                campoError: '',

                //polla del mes
                pollaMes: '',
                pollaEstado: 0,
                pollaCantPart: 0,
            };
        },
        computed: {
            ...mapState(['idPersonaGlobal','tokenGlobal','nombreUsuario','nombreFoto']),
        },
        methods: {
            ...mapMutations(['restablecer']),
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
            ** Fecha: 23/11/2020
            ** Autor: Omar jaramillo
            ** descripcion: validar los campos del formulario, cambio de contraseña, antes de hacer la peticion que realizara el cambio
            */
            validarCampos(){
                this.error = false;
                this.campoError = '';               
                if(this.newPass == '') {this.error=true; this.campoError='Contraseña nueva'; return; }
                if(this.confirmPass == '') {this.error=true; this.campoError='Confirmar Contraseña'; return; }
                //validar si la contraseña nueva y confirmar contraseña son iguales
                if(this.newPass != this.confirmPass) {this.error=true; this.campoError='Nueva contraseña no coincide con la confirmación contraseña'; return;}
            },

            /*
            ** Fecha: 30/11/2020
            ** Autor: Omar jaramillo
            ** descripcion: alterna el estado de los campos en el formulario de cambiar contraseña, alterna el nombre del icono
            */
            verCampo(campo){
                switch(campo){  
                    case 'NewPass':
                        this.tipoNewPass = (this.tipoNewPass == 'password')? 'text' : 'password';
                        this.iconoEyeNew = (this.iconoEyeNew == 'icon-copy fa fa-eye')? 'icon-copy fa fa-eye-slash' : 'icon-copy fa fa-eye';
                    break;
                }
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: abre un modal u otro dependiendo del parametro recibido, establece variables o restablece campos
            */
            abrilModal(level){ 
                switch (level) {
                    case 1:
                        this.modalReglas = 1;
                        this.titleModal = 'Reglas de la natillera.'
                    break;   
                }
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: cierra un modal abierto con parametro level
            */
            cerrarModal(level){
                this.titleModal = '';
                switch (level) {                    
                    case 1: this.modalReglas=0; this.titleModal=''; break;                    
                }
            },


            /*
            ** Fecha: 30/11/2020
            ** Autor: Omar jaramillo
            ** descripcion: realiza peticion para realizar el cambio de contraseña y establece que el usuario ya ha iniciado sesion
            */
            cambiarContrasenia(){
                this.validarCampos();
                if(this.error) {
                    Sweet('info','Por favor revisa: '+this.campoError);
                }else{
                    cargandoGif(0,'Cambiando Contraseña');
                    const url = 'cambiarContrasenia';
                    const data = {
                        accion: 'cambiarContrasenia',
                        newPass: this.newPass,
                        id: this.idPersonaGlobal,
                        pi: 'S' // envio parametro para saber que la peticion es cambio de contraseña en primer inicio
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
                            this.numeroAsociado = datos['numeroAsociado'];
                            this.miAhorro = datos['ahorro'];
                            this.miEstadoNatillera = (datos['alDia']=='S')? 1 : 2;
                            this.pollaMes = datos['pollaMes'];
                            this.pollaEstado = (datos['alDiaPolla']=='S')? 1 : 2;
                            this.pollaCantPart = datos['pollaPartipantes'];
                            //validar si es necesario mostrar ventana de cambio de contraseña
                            if(datos['primerInicio'] == 'S') {                                
                                this.modalPass = 1;
                                this.titleModal = this.nombreUsuario+'. Debe cambiar su contraseña';
                            }
                            //mostrar modal con la reglas del negoco
                            this.abrilModal(1);
                        break;

                        case 'cambiarContrasenia':
                            this.modalPass = 0;
                            this.titleModal = '';
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

<style>
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

    .icon_estado_a{        
        font-size: 25px;
        color: green;
    }

    .icon_estado_b{
        font-size: 25px;
        color: red;
    }

    .marginB{
        margin-bottom: 20px;
    }
</style>