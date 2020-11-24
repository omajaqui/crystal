<template>
    <div>
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <h4 class="text-blue h4">Crear un préstamo</h4>
            </div>
            <div class="wizard-content">
                <div class="row tex-center">
                    <div class="col-md-5 _opcion">
                        <div class="card-box pd-30 height-100-p _menu" @click="tipoPrestamo='socio'">						
                            <h5 class="text-blue padding-top-10 h5">A un socio</h5>
                            <p>Realizar préstamo a un socio.</p>
                            <div class="footBox">SELECCIONAR</div>
                        </div>                    
                    </div>

                    <div class="col-md-5 _opcion">
                        <div class="card-box pd-30 height-100-p _menu" @click="tipoPrestamo='persona'">						
                            <h5 class="text-blue padding-top-10 h5">A persona externa</h5>
                            <p>Realizar préstamo a persona externa.</p>
                            <div class="footBox">SELECCIONAR</div>
                        </div>                    
                    </div>
                </div>
                <!-- <form class="tab-wizard wizard-circle wizard" v-if="arraySocios.length>0">
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
                </form> -->
                
                <!--                 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">                                
                            <button class="btn btn-primary btn-lg btn-block" type="buttton" >GUARDAR</button>
                        </div>
                    </div>
                </div>
                 -->
            </div>
        </div>

        
        <div class="pd-20 card-box mb-30">
            <!-- formulario para nuevo prestamo a un socio -->
            <form class="tab-wizard wizard-circle wizard" v-if="tipoPrestamo=='socio'">
                <div class="row" v-if="arraySocios.length>0">
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
                        </div>
                    </div>
                    <div class="col-md-6">
                            <div class="form-group">
                                <label>AHORROS DEL SOCIO</label>
                                <pre class="textoResalt" v-text="ahorrosSocio"></pre>
                            </div>
                        </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>VALOR CRÉDITO</label>
                            <input class="form-control" type="number" v-model="valorCredito">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>CANTIDAD CUOTAS</label>
                            <input class="form-control" type="number" v-model="cantidadCuotas">
                        </div>
                    </div>                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="text-align: center;">VISUALIZAR CUOTA</label>
                            <p>
                                <i class="icon-copy dw dw-startup icon_Ver" @click="calcularCuota"></i>
                                <input class="form-control" type="text" disabled v-model="valorCuota">
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="text-align: center;">MODO DESEMBOLSO</label>
                            <select class="form-control" v-model="modoDesembolso">
                                <option value="EFECTIVO">EFECTIVO</option>
                                <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="row" v-if="tipoPrestamo!=''">
                <div class="col-md-6">
                    <div class="form-group">                                
                        <button class="btn btn-primary btn-lg btn-block" type="buttton" @click="guardarCredito">GUARDAR</button>
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
                tipoPrestamo: '',

                //campos prestamos
                socioSelecionado: '',
                ahorrosSocio: '',
                valorCredito: '',
                cantidadCuotas: '',
                valorCuota: '',
                modoDesembolso: '',


                //validacion de campos
                error: false,
                campoError: '',
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

            },

            camposCalcularCuota(){
                this.error = false;
                this.campoError = '';
                if (   
                    this.socioSelecionado == '' || 
                    this.socioSelecionado == [] ||
                    this.valorCredito == ''    ||
                    this.cantidadCuotas == ''
                ) {
                    this.error = true;
                    this.campoError = 'Para calcular el valor de la cuota debe seleccionar: SOCIO, VALOR PRÉSTAMO Y CANTIDAD CUOTAS.';
                }
            },

            calcularCuota(){
                this.camposCalcularCuota();
                if (this.error){
                    Sweet('info',this.campoError);
                }else{
                    cargandoGif(0,'Calculando.');
                    //const url = 'ahorroSocio';
                    const data = {
                        accion: 'calcularCuota',
                        tipo: this.tipoPrestamo,
                        valorCredito: this.valorCredito,
                        cantidadCuotas: this.cantidadCuotas
                    };
                    //llamar al servicio que calcula el valor de la cuota segun los parametros ingresado
                    this.peticionComun('ahorroSocio',data);                    
                }
            },

            guardarCredito() {
                const data = {
                    accion: 'creditoGuardar',
                    socio: this.socioSelecionado.nombreCompleto,
                    valorCredito: this.valorCredito,
                    cantCuotas: this.cantidadCuotas,                    
                }
                const listaData = `
                    <lu style="text-align: left;">
                        <li>Responsable crédito: ${data.socio}</li>
                        <li>Valor crédito: ${data.valorCredito}</li>
                        <li>cantidad cuotas: ${data.cantCuotas}</li>
                    </lu>
                `;
                this.SweetConfirmar(listaData, data);
            },
            

            SweetConfirmar(html, data) {      
                Swal.fire({
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    title: '¿Crear Crédito?',
                    html,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.value) {
                        console.log(data);
                        //llamar al servicio que crea y guarda el credito
                        data['documento'] = this.socioSelecionado.documento;
                        this.peticionComun('crearCredito',data);                        
                    }else if (result.dismiss === Swal.DismissReason.cancel) {
                        console.log("cancel operation");
                    }
                });                
            },


            //PETICION COMUN AXIOS POST
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

            decidir(resp,accion){
                //console.log(resp);
                switch (accion) {
                    // control cuando la peticion devuelve token expired
                    case 'Token is Expired':
                        sweetSesionCaduca('La sesión ha caducado');
                    break;

                    case 'sociosCuotas':
                        if(resp['Continuar'] == 'S'){ this.arraySocios = resp['Socios']; }
                    break;

                    case 'consultarAhorro':
                        if(resp['Continuar'] == 'S'){ this.ahorrosSocio = format(resp['DatosRespuesta'][0]['Ahorros']); }
                    break;

                    case 'calcularCuota':
                        if(resp['Continuar'] == 'S'){ this.valorCuota = format(resp['DatosRespuesta']['ValorCuota']); }
                    break;

                    case 'creditoGuardar':

                    break;
                }              

                //cerrar el loading desde cualquier accion
                if (accion != 'Token is Expired'){
                    cargandoGif(1,'');
                }                

                //mostar sweet si resp['Continuar']=='N' en cualquier accion
                if(resp['Continuar'] == 'N'){
                    Sweet('info',resp['Mensaje']);
                }                
            },            
            
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

    ._menu, ._opcion{
        text-align:center;
        margin: auto; 
    }
    ._menu:hover{
        transform: scale(1.2);
        transition: ease;
        cursor: pointer;
        box-shadow: 2px 2px 20px 0px rgba(0,0,0,0.75);
    }
    .footBox{
        width: 118%;
        height: 40px;
        padding-top: 10px;
        margin-left: -9%;
        margin-bottom: -9%;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        background-color: blue;
        color: #ffffff;
    }

    .btn_ver{
        float:right;
    }

    .icon_Ver{
        font-size: 25px;
        color: blue; 
    }
</style>

