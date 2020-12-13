<template>
    <div >
        <div class="card-box pd-20 height-100-p mb-30">
            <div class="row">
                <!-- <div class="col-sm-4">Fecha</div>
                <div class="col-sm-4">Cuota de</div>
                <div class="col-sm-4">Valor</div> -->
                <table class="table table-striped">
                    <thead>
                        <th>Fecha</th>
                        <th>Cuota de</th>
                        <th>Valor</th>
                    </thead>
                    <tbody>
                        <tr v-for="item in arrayAhorro" :key="item.idAhorro">
                            <td v-text="item.fecha"></td>
                            <td v-text="item.mesPertenee"></td>
                            <td>{{ item.valorCuota | separadorMiles }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td colspan="2" style="text-align: right;"><strong>Total:</strong></td>
                            <td><strong>{{ totalAhorro }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import { mapMutations } from 'vuex';
    export default {
        data() {
            return {
                arrayAhorro: [],
                totalAhorro: 0,
            };
        },
        computed: {
            ...mapState(['idPersonaGlobal','tokenGlobal','nombreUsuario']),
        },
        methods: {
            ...mapMutations(['restablecer']),

            /*
            ** Fecha: 01/12/2020
            ** Autor: Omar jaramillo
            ** descripcion: consulta la informacion general de ahorros del socio
            */
            inicio(){
                const url = 'misAhorros';
                const data = {
                    accion: 'miAhorro',
                    id: this.idPersonaGlobal,
                };
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
                        case 'miAhorro': 
                            this.arrayAhorro =  resp['DatosRespuesta'];
                            this.totalAhorro = 0;
                            let i = 0;
                            let a = 0;
                            for(i=0;i<this.arrayAhorro.length;i++){
                                a += parseInt(this.arrayAhorro[i]['valorCuota']);                                
                            }
                            this.totalAhorro = format(a);         
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
            this.inicio();
        }
    }
</script>

<style>
    .separador{
        border-bottom:blue 1px solid;
        margin-bottom: 5px;        
    }    
</style>
