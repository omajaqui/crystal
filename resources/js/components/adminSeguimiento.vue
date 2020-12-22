<template>
    <div>
        <div class="card-box pd-20 height-100-p mb-30">
            <div class="clearfix">
                <h3 class="text-blue text-center">Seguimiento a ahorros y recaudos de la natillera</h3>
            </div>
            <br>
            <h4 class="text-blue h4">TOTALES</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="card-box pd-30 height-100-p" >						
                        <h5 class="text-blue h5">Ahorros socios</h5>
                        <p><b>$ {{ totalAhorros | separadorMiles }}</b></p>
					</div>                    
                </div>

                <div class="col-md-4">
                    <div class="card-box pd-30 height-100-p" >						
                        <h5 class="text-blue h5">Ganancias Actividades</h5>
                        <p><b>$ {{ gananciasActi | separadorMiles }}</b></p>
					</div>                    
                </div>
                <div class="col-md-4">
                    <div class="card-box pd-30 height-100-p">						
                        <h5 class="text-blue h5">Intereses/Multas</h5>
                        <p><b>$ {{ InterMultas | separadorMiles }}</b></p>
					</div>                  
                </div>
            </div>
        </div>
        <br>
        <div class="card-box pd-20 height-100-p mb-30">
            <div class="clearfix">
                <h4 class="text-blue h4">Ver ahorros por socio</h4>                
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
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
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>Total Ahorros del socio</label>
                        <h4 class="text-blue h4">$ {{ ahorrosSocio }}</h4>                      
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
                socioSelecionado: [],
                ahorrosSocio: '',

                totalAhorros: '',
                gananciasActi: '',
                InterMultas: '',
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
                this.ahorrosSocio = '';             
                setTimeout(() => {
                    const url = 'ahorroSocio';
                    const data = {
                        accion: 'consultarAhorro',
                        id: this.socioSelecionado['documento']
                    };
                    //consultar el valor del ahorro del socio para establecer un maximo sugerido
                    this.peticionComun(url,data); 
                }, 500);                

            },

            /*
            ** Fecha: 9/12/2020
            ** Autor: Omar jaramillo
            ** descripcion: consulta la informacion inicial del que se usa en el component
            */
            inicio() {
                cargandoGif(0,'Cargando...')
                const url = 'seguimientos';
                const data = {
                    accion: 'consultaTotales',
                    id: this.idPersonaGlobal
                }
                this.peticionComun(url,data);
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
                        case 'consultaTotales':
                            this.arraySocios = resp['DataRespuesta']['Socios'];
                            const datos=resp['DataRespuesta']['Resultado'][0];
                            this.totalAhorros = datos['totalAhorros'];
                            this.gananciasActi = datos['totalGanancias'];
                            this.InterMultas = datos['totalInteMultas'];                           
                        break;

                        case 'consultarAhorro':
                            this.ahorrosSocio='';
                            this.ahorrosSocio = format(resp['DatosRespuesta'][0]['Ahorros']);
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
            //console.log('Component mounted.')
            this.inicio();
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
