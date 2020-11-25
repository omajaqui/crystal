<template>
    <div>
        <div class="header">
            <div class="header-left">
                <div class="menu-icon dw dw-menu"></div>			
            </div>
            <div class="header-right">
                <div class="user-info-dropdown">
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <span class="user-icon">
                                <img :src="nombreFoto" alt="">
                            </span>
                            <span class="user-name" v-text="nombreUsuario"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="profile.html"><i class="dw dw-user1"></i> Perfil</a>
                            <a class="dropdown-item" @click="abrirModal(1)">
                                <i class="dw dw-settings2"></i> 
                                Cambiar Contraseña
                            </a>
                            <!-- <a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Ayuda</a> -->
                            <a class="dropdown-item" @click="cerrarSesion"><i class="dw dw-logout"></i> Cerrar sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL CAMBIO DE CONTRASEÑA -->
        <div class="modal fade bs-example-modal-lg" :class="{'mostrar' : modalPass}" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="titleModal"></h4>
                        <button type="button" class="close" @click="cerrarModal(1)">×</button>
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
    export default {
        data() {
            return {
                return: '', //variable de prueba no asignada 

                //control de campos
                tipoPassActual: 'password',
                tipoNewPass: 'password',
                iconoEye: 'icon-copy fa fa-eye', //icon-copy fa fa-eye-slash
                iconoEyeNew: 'icon-copy fa fa-eye', //icon-copy fa fa-eye-slash

                //variables modal
                modalPass: 0,
                titleModal: '',

                //campos formulario cambiar contraseña                
                newPass: '',
                confirmPass: '',

                //validacion de campos formulario
                error: false,
                campoError: '',
            };
        },
        computed: {
            ...mapState(['idPersonaGlobal','tokenGlobal','nombreUsuario','nombreFoto']),
        },
        methods: {
            ...mapMutations(['restablecer']),            

            cerrarSesion(){
                this.sweetConfirm('¿cerrar sesion?','','warning');
            },

            sweetConfirm(title,html,icon){
                Swal.fire({
                    title,
                    html,
                    icon,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        this.restablecer();
                        window.location.replace("./");  
                    }
                })
            },

            abrirModal(level){
                switch(level){
                    case 1:
                        this.restablecerCamposCambiarContraseña();
                        this.titleModal = 'Cambio de contraseña';
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

            verCampo(campo){
                switch(campo){  
                    case 'NewPass':
                        this.tipoNewPass = (this.tipoNewPass == 'password')? 'text' : 'password';
                        this.iconoEyeNew = (this.iconoEyeNew == 'icon-copy fa fa-eye')? 'icon-copy fa fa-eye-slash' : 'icon-copy fa fa-eye';
                    break;
                }

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
                    const url = 'cambiarContrasenia';
                    const data = {
                        accion: 'cambiarContrasenia',
                        newPass: this.newPass,
                        id: this.idPersonaGlobal,
                    }
                    this.peticionComun(url,data);
                }
            },

            /*
            ** Fecha: 23/11/2020
            ** Autor: Omar jaramillo
            ** descripcion: restablece los campos utilizados en el formulario para cambiar la contraseña
            */
            restablecerCamposCambiarContraseña(){
                this.tipoNewPass ='password';
                this.iconoEyeNew = 'icon-copy fa fa-eye';                
                this.newPass = '';
                this.confirmPass = '';
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
                if(accion == 'Token is Expired'){ sweetSesionCaduca('La sesión ha caducado'); }
                
                if(resp['Continuar'] == 'S'){
                    switch(accion){ 
                        case 'cambiarContrasenia':
                            this.restablecerCamposCambiarContraseña();                            
                            this.modalPass = 0;
                            this.titleModal = '';   
                        break;
                    }
                }

                //cerrar el loading desde cualquier accion
                if (accion != 'Token is Expired'){
                    cargandoGif(1,'');
                    if(accion == 'cambiarContrasenia'){Sweet('info',resp['Mensaje']);}
                }                

                //mostar sweet si resp['Continuar']=='N' en cualquier accion
                if(resp['Continuar'] == 'N'){
                    Sweet('info',resp['Mensaje']);
                }
            }
        },
        
        mounted() {
            console.log('comun-header Component mounted.')
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
</style>
