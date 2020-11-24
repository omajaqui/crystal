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
                            <div class="h4 mb-0">52</div>
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
                <div class="card-box height-100-p pd-20">
                    <h2 class="h4 mb-20">Lead Target</h2>
                    <div id="chart6"></div>
                </div>
            </div>
        </div>        
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
            };
        },
        computed: {
            ...mapState(['idPersonaGlobal','tokenGlobal','nombreUsuario','nombreFoto']),
        },
        methods: {
            ...mapMutations(['']),
             /*
             ** fecha: 07-11-2020
             ** descripcion: consulta los datos de la persona qu inicio sesion y los guardo en el store
             */
            inicio(){
                cargandoGif(0,'Cargando datos iniciales');
                if(this.tokenGlobal==''){window.location.replace("./"); }
                const url = 'datosUsuario';
                const data = { idUSuario: this.idPersonaGlobal };               
                axios({
                    method: 'post',
                    url,
                    data,
                    params: {'HTTP_CONTENT_LANGUAGE': self.language},
                    headers: {'Authorization': 'Bearer '+this.tokenGlobal }
                }).then(response => {
                    let resp = response.data.respuesta;
                    if(resp['Continuar'] == 'S'){
                        const datos = resp['DatosUsuario'][0];
                        this.$store.state.nombreUsuario = datos['nombres']+' '+datos['apellidos'];
                        this.$store.state.nombreFoto = datos['nombreFoto'];
                    }else{
                        Sweet('info',resp['Mensaje']);
                    }                    
                    cargandoGif(1,'');
                }).catch(e =>{
                    console.log(e);
                    cargandoGif(1,'');
                });                             
            },    
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
