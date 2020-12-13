<template>
    <div>
        <div class="card-box pd-20 height-100-p mb-30">
            <div class="clearfix">
                <h2 class="text-blue">Polla activa: <b>{{ pollaActiva }}</b></h2>
            </div>
            <p>Recaudo polla a la fecha: <b>$ {{ totalRecaudos }}</b></p>
        </div>

        <div class="card-box pd-20 height-100-p mb-30">
            <div class="clearfix">
                <h4 class="text-blue h4">Registro de recaudos</h4>
                <div class="card-box pd-20 height-100-p mb-30">
                    <p class="text-center">Para los registros que pertenescan a la actividad polla mensual, se entiende que la cuota es de $10.000</p>
                </div>
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
                        >
                        </multiselect>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label>TIPO RECAUDO</label>
                        <select class="form-control" v-model="tipoRecaudo">
                            <option value="P">Polla del mes: {{ pollaActiva }}</option>
                        </select>                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">                                
                        <button class="btn btn-primary btn-lg btn-block" type="buttton" @click="guardarPolla">GUARDAR</button>
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
                pollaActiva: '',
                totalRecaudos:0,                

                //formulario guardar cuota polla mensual
                socioSelecionado: [],
                tipoRecaudo:'',

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
            

            /*
            ** Fecha: 9/12/2020
            ** Autor: Omar jaramillo
            ** descripcion: consulta la informacion inicial del que se usa en el component
            */
            inicio() {
                cargandoGif(0,'Cargando...')
                const url = 'actividades';
                const data = {
                    accion: 'consultaActiva'
                }
                this.peticionComun(url,data);
            },

            /*
            ** Fecha: 12/12/2020
            ** Autor: Omar jaramillo
            ** descripcion: valida los campos obligatorios antes de guarar el valor de la polla
            */
            validarCamposPolla(){
                this.error = false;
                this.campoError = '';
                if(!this.socioSelecionado.documento) {this.error=true; this.campoError='Socio'; return}
                if(this.tipoRecaudo==''){this.error=true; this.campoError='Tipo recaudo'; return}
            },

            /*
            ** Fecha: 12/12/2020
            ** Autor: Omar jaramillo
            ** descripcion: guarda la valor de la polla que el socio pagó
            */
            guardarPolla(){
                this.validarCamposPolla();
                if(this.error){
                    Sweet('info','validar el campo: '+this.campoError);
                }else{
                    const url = 'pollaMensual';
                    const data = {
                        accion: 'guardarPolla',
                        doc: this.socioSelecionado['documento'],
                        idp: this.idPersonaGlobal
                    }
                    this.peticionComun(url,data);
                }
            },

            /*
            ** Fecha: 12/12/2020
            ** Autor: Omar jaramillo
            ** descripcion: restablecer los valores de los campos del formulario
            */
            limpiarCampos(){
                this.socioSelecionado=[];
                this.tipoRecaudo='';
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
                        case 'consultaActiva':
                            this.arraySocios = resp['DataRespuesta']['socios'];
                            this.pollaActiva = resp['DataRespuesta']['pollaMes'][0]['nombre'];

                            //recorrer los datos de recaudos para establecer el total recaudado a la fecha
                            this.totalRecaudos=0;
                            let r = resp['DataRespuesta']['recaudos'];
                            let i=0;
                            for(i=0;i<r.length;i++){
                                let v=0;
                                v=parseInt(r[i]['valor'], 10);
                                this.totalRecaudos += v;
                            }
                            this.totalRecaudos=format(this.totalRecaudos);                                                      
                        break;

                        case 'guardarPolla':
                            this.limpiarCampos();
                            this.inicio();
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
