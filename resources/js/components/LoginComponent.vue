<template>
    <div>
        <div class="login-header box-shadow">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div class="brand-logo">
                    <a href="login.html">
                        <img src="imgs/logo_crystal.png" alt="">
                    </a>
                </div>
                <!-- <div class="login-menu">
                    <ul>
                        <li><a href="register.html">Hacerse socio</a></li>
                    </ul>
                </div> -->
            </div>
        </div>
        <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-lg-7">
                        <img src="vendors/images/login-page-img.png" alt="">
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div class="login-box bg-white box-shadow border-radius-10">
                            <div class="login-title">
                                <h2 class="text-center text-primary">Iniciar sesión</h2>
                            </div>
                            <form method="post" action="inicio" id="formLogin">
                                <div class="select-role">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <!-- <label class="btn active">
                                            <input type="radio" name="soyAdmin" id="soyAdmin">
                                            <div class="icon"><img src="vendors/images/briefcase.svg" class="svg" alt=""></div>
                                            <span>Soy </span>
                                            Admin
                                        </label> -->
                                        <label class="btn" @click="registroSocio">
                                            <input type="radio" name="soyMiembro" id="soyMiembro">
                                            <div class="icon"><img src="vendors/images/person.svg" class="svg" alt=""></div>
                                            <span>Registrarse </span>
                                            Nuevo socio
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group custom">
                                    <input type="text" class="form-control form-control-lg" v-model="user" name="user" placeholder="Usuario">
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                    </div>
                                </div>
                                <div class="input-group custom">
                                    <input :type="tipoCampoPass" class="form-control form-control-lg" v-model="password" name="password" placeholder="Contraseña" @keyup.enter="iniciarSesion()">
                                    <input type="hidden" v-model="documento" name="documento">
                                    <input type="hidden" v-model="token" name="token">
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i :class="iconoEye" @click="verCampo"></i></span>
                                    </div>
                                </div>
                                <div class="row pb-30">
                                    <div class="col-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label">Recordar</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="forgot-password"><a href="forgot-password.html">Olvidó su contraseña</a></div>
                                    </div>                                    
                                </div>                                
                            </form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <button class="btn btn-primary btn-lg btn-block" type="buttton" @click="iniciarSesion()">Iniciar</button>										
                                    </div>									
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL FRMULARIO AGREGAR SOCIO -->
        <div class="modal fade bs-example-modal-lg" :class="{'mostrar' : modalRS}" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Registro de socio</h4>
                        <button type="button" class="close" @click="cerrarModal(1)">×</button>
                    </div>
                    <div class="modal-body">
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
                                        <select class="form-control" v-model="formTDoc">
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
                                        <input type="number" class="form-control" v-model="formDoc">                    
                                    </div>
                                </div>
                                           
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Nombres</label>
                                        <input type="text" class="form-control" v-model="formNom">                    
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Apellidos</label>
                                        <input type="text" class="form-control" v-model="formApe">                    
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Correo electrónico</label>
                                        <input type="email" class="form-control" 
                                            :class="{
                                                        'form-control-danger' : incorrectEmail,
                                                        'form-control-success' : correctoEmail
                                                    }"
                                            v-model="formEmail"
                                        >                    
                                    </div>
                                </div>
                            </div>

                            <div class="row">                                
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Barrio</label>
                                        <input type="text" class="form-control" v-model="formBarrio">                    
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <input type="email" class="form-control" v-model="formDir">                    
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Teléfono fijo</label>
                                        <input type="number" class="form-control" v-model="formFijo">                    
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Celular</label>
                                        <input type="number"  class="form-control" 
                                                            :class="{
                                                                        'form-control-danger' : incorrectCel,
                                                                        'form-control-success' : correctCel
                                                                    }"
                                                            v-model="formCel">                    
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Valor cuota mensual</label>
                                        <input type="number"    class="form-control" 
                                                                :class="{
                                                                            'form-control-danger' : incorrectVlr,
                                                                            'form-control-success' : correctVlr
                                                                        }"
                                                                v-model="formCuota" placeholder="$">                    
                                    </div>
                                </div>            
                            </div> 
                        </form>
                        <div class="pd-20 card-box mb-30">
                            <p class="info">
                                La inscripción a este sistema de ahorros tiene un costo de <b>COP 5.000</b>.
                                los cuales deben ser cancelados al momento de iniciar el ahorro.
                            </p>
                        </div>	
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal(1)">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="guradarRegistro">Guardar Registro</button>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data(){
            return {
                user:'',
                password:'',
                documento: '',
                token:'',
                errorCampo: false,
                msjError: '',

                //control de campos
                tipoCampoPass: 'password',
                iconoEye: 'icon-copy fa fa-eye', //icon-copy fa fa-eye-slash


                //modal
                modalRS: 0,

                //FORMULARIO
                formTDoc: '',
                formDoc: '',
                formNom: '',
                formApe: '',
                formEmail: '',
                formBarrio: '',
                formDir: '',
                formFijo: '',
                formCel: '',
                formCuota: '',

                //validacion de campos par ael formulario de registro
                formError: false,
                campoError: '',

                incorrectEmail: 0,
                correctoEmail: 0,

                incorrectCel: 0,
                correctCel: 0,

                incorrectVlr: 0,
                correctVlr: 0,

            }
        },

        methods: {
            verCampo(){
                this.tipoCampoPass = (this.tipoCampoPass == 'password')? 'text' : 'password';
                this.iconoEye = (this.iconoEye == 'icon-copy fa fa-eye')? 'icon-copy fa fa-eye-slash' : 'icon-copy fa fa-eye';
            },

            validarCampos() {
                this.errorCampo = false;
                if (this.user == '')     { this.msjError='Usuario';  this.errorCampo = true; return}
                if (this.password == '') { this.msjError='Contraseña'; this.errorCampo = true; return}
            },

            iniciarSesion() {
                this.validarCampos();
                if(this.errorCampo) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Debe completar el siguiente campo',
                        text: this.msjError
                    });
                }else{
                    loadingGif(0,'Cargando...');
                    let config = {
                        headers: {
                        Autorization: 'value',
                        }
                    }
                    let data = {
                        'HTTP_CONTENT_LANGUAGE': self.language,
                        user: this.user,
                        password: this.password
                    }
                    const url = 'validarCredenciales';
                    axios.post(url, data, config).then(async response =>{                       
                        const resp = response.data.respuesta
                        this.documento = resp['Documento'];
                        this.token = resp['Token'];
                        if(resp['Continuar'] == 'N') {
                            this.user = '';
                            this.password = '';
                            loadingGif(1,'');
                            Sweet('info',resp['Mensaje']);
                        }

                        if (resp['Continuar'] == 'S') {
                            setTimeout(() => {
                                $('#formLogin').submit();
                                loadingGif(1,'');
                            }, 500); 
                           
                            
                            /* 
                            const token = 'Bearer '+resp['Token'];                           
                            const requestOptions = {
                                method: 'POST',
                                headers: { 
                                'Content-Type': 'application/json',
                                'Authorization': token
                                },
                                body: JSON.stringify({ title: 'Vue POST Request Example' })
                            };
                            fetch('inicio', requestOptions)
                                .then(response => response.json())
                                .then(data => this.postId = data.id);
                              */
                        }

                    });
                }
            },

            checkForm: function (e) {
                console.log("chekform");
                e.preventDefault();
            },           

            registroSocio() {
                loadingGif(0,'Cargando Formulario');
                setTimeout(() => {
                    this.abrirModal(1);
                    loadingGif(1,'');
                }, 800);
            },

            abrirModal(level){
                switch(level) {
                    case 1:
                        this.modalRS = 1;
                    break;
                }
            },

            cerrarModal(level){
                switch(level) {
                    case 1:
                        this.modalRS = 0;
                    break;
                }
            },
            
            validarCampos(){
                let t=this;
                t.formError = false;
                t.campoError = '';

                t.incorrectEmail = 0;
                t.correctoEmail = 0;

                t.incorrectCel = 0;
                t.correctCel = 0;

                t.incorrectVlr = 0;
                t.correctVlr = 0;

                if(t.formTDoc=='' || t.formTDoc==[]){
                    t.formError=true; t.campoError="Tipo Documento"; return;
                }
                
                if(t.formDoc==''){
                    t.formError=true; t.campoError="Documento"; return;
                }

                if(t.formNom==''){t.formError=true; t.campoError="Nombres"; return;}
                if(t.formApe==''){t.formError=true; t.campoError="Apellidos"; return;}

                if(t.formEmail==''){t.formError=true; t.campoError="Correo electrónico"; return;}
                const emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
                if (!emailRegex.test(t.formEmail)) {
                    t.incorrectEmail = 1;
                    t.correctoEmail = 0;
                    t.formError=true;
                    t.campoError="La dirección de correo ingresada no es correcta";
                    return;
                }else{
                    t.incorrectEmail = 0;
                    t.correctoEmail = 1;
                }   
                
                if(t.formCel==''){
                    t.formError=true; t.campoError="Celular"; return;
                }else{
                    if(t.formCel.length <10 || t.formCel.length >10){                        
                        t.incorrectCel = 1;
                        t.correctCel = 0;
                        t.formError=true;
                        t.campoError="El número de celular debe tener 10 caracteres";
                        return;
                    }else{
                        t.incorrectCel = 0;
                        t.correctCel = 1;
                    }
                }

                if(t.formCuota==''){
                    t.formError=true; t.campoError="Valor cuota mensual"; return;
                }else{ 
                    if(parseInt(t.formCuota, 10)<20000){                        
                        t.incorrectVlr = 1;
                        t.correctVlr = 0;
                        t.formError = true;
                        t.campoError = "El ahorro mínimo mensual es: COP 20.000";
                        return;
                    }else{
                        t.incorrectVlr = 0;
                        t.correctVlr = 1;
                    }
                }
            },
            guradarRegistro(){
                this.validarCampos();
                if(this.formError){
                    Sweet('info','Validar campo: '+this.campoError);
                }else{
                    loadingGif(0,'Guardando Registro');                    
                    const url = 'preRegistroSocio';
                    const data = {
                        accion:     'preRegistro',
                        tipoDoc:    this.formTDoc,
                        doc:        this.formDoc,
                        nombres:    this.formNom,
                        apellidos:  this.formApe,
                        correo:     this.formEmail,
                        barrio:     this.formBarrio,
                        direccion:  this.formDir,
                        tFijo:      this.formFijo,
                        celular:    this.formCel,
                        valorCuota: this.formCuota
                    }

                    //llamar al servicio que guarda la informacion del registro en la base de datos
                    axios.post(url,data).then(response => {
                        let resp = response.data.respuesta;
                        if(resp['Continuar'] == 'S'){
                            this.limpiarPreRegistro();
                            loadingGif(1,'');
                            this.modalRS = 0;
                            Sweet('success','Registro guardado. un asesor de Crystal se pondra en contacto con usted.')
                        }else if(resp['Continuar'] == 'N'){
                            loadingGif(1,'');
                            Sweet('info',resp['Mensaje']);
                        }else{
                            loadingGif(1,'');
                            Sweet('info','Error inesperado, Intente de nuevo');
                        }
                    }).catch(error =>{
                        loadingGif(1,'');
                        e=JSON.stringify(error);
                        Sweet('error',e);
                    });
                }
            },

            limpiarPreRegistro(){
                this.formTDoc = '';
                this.formDoc = '';
                this.formNom = '';
                this.formApe = '';
                this.formEmail = '';
                this.formBarrio = '';
                this.formDir = '';
                this.formFijo = '';
                this.formCel = '';
                this.formCuota = '';

                this.incorrectEmail = 0;
                this.correctoEmail = 0;

                this.incorrectCel = 0;
                this.correctCel = 0;

                this.incorrectVlr = 0;
                this.correctVlr = 0;
            }
           
        },
        
        mounted() {
            console.log('Component mounted.');
            this.limpiarPreRegistro();
        }
    }
</script>

<style>
    .mostrar{
        padding-top: 100px;
        display: list-item !important;
        opacity: 1 !important;
        /* position: absolute !important; */
        background-color: #3c29297a;
        overflow-y: scroll !important;        
    }

    .info{
        width: 80%;
        margin: auto;
        text-align:center;
    }
</style>
