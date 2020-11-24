<template>
    <div>
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <h4 class="text-blue h4">Agregar pago de cuota a un Préstamo</h4>
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
                        <!-- <div class="col-md-6">
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
                        </div> -->                        
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">                                
                            <button class="btn btn-primary btn-lg btn-block" type="buttton" >GUARDAR</button>
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
                socioSelecionado: '',
                arraySocios: [],
            };
        },
        computed: {
            ...mapState(['idPersonaGlobal','tokenGlobal','nombreUsuario']),
        },
        methods: {
            //...mapMutations(['aumentar']),
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
                axios({
                    method: 'post',
                    url,
                    data,
                    params: {'HTTP_CONTENT_LANGUAGE': self.language},
                    headers: {'Authorization': 'Bearer '+this.tokenGlobal }
                }).then(response => {
                    //validacion cuando el token expire
                    if(response['data']['status'] == 'Token is Expired') {
                        Sweet('info','La sesion ha caducado');
                        window.location.href = "./";
                        return
                    }
                    let resp = response.data.respuesta;
                    if(resp['Continuar'] == 'S'){
                        this.arraySocios = resp['Socios'];
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
            this.listarSoicos();
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
