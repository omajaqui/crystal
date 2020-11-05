<template>
    <div>
        <div class="login-header box-shadow">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div class="brand-logo">
                    <a href="login.html">
                        <img src="imgs/logo_crystal.png" alt="">
                    </a>
                </div>
                <div class="login-menu">
                    <ul>
                        <li><a href="register.html">Hacerse socio</a></li>
                    </ul>
                </div>
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
                                        <label class="btn active">
                                            <input type="radio" name="soyAdmin" id="soyAdmin">
                                            <div class="icon"><img src="vendors/images/briefcase.svg" class="svg" alt=""></div>
                                            <span>Soy </span>
                                            Admin
                                        </label>
                                        <label class="btn">
                                            <input type="radio" name="soyMiembro" id="soyMiembro">
                                            <div class="icon"><img src="vendors/images/person.svg" class="svg" alt=""></div>
                                            <span>Soy </span>
                                            Miembro
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
                                    <input type="password" class="form-control form-control-lg" v-model="password" name="password" placeholder="Contraseña">
                                    <input type="hidden" v-model="documento" name="documento">
                                    <input type="hidden" v-model="token" name="token">
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
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
            }
        },

        methods: {
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
            }
           
        },
        
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
