<template>
    <div>
        <div class="card-box pd-20 height-100-p mb-30">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <img src="vendors/images/banner-img.png" alt="">
                </div>
                <div class="col-md-8">
                    <h4 class="font-20 weight-500 mb-10 text-capitalize">
                        Bienvenid@ <div class="weight-600 font-30 text-blue">Johana Loaiza</div>
                    </h4>                    
                    <input type="hidden" :value="idpersona" id="idPersona">
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
            };
        },
        computed: {
            ...mapState(['numeroGlobal','tokenGlobal']),
        },
        methods: {
            ...mapMutations(['aumentar']),
            test(){
                console.log(this.idPersonaGlobal);
                const url = 'datosUsuario';
                const data = { idUSuario: this.idPersonaGlobal }  
                axios({
                    method: 'post',
                    url,
                    data,
                    params: {'HTTP_CONTENT_LANGUAGE': self.language},
                    headers: {'Authorization': `Bearer ${this.tokenGlobal}`}
                }).then(response => {
                    console.log(response);
                });
            }            
        },
        mounted() {
            this.idPersona = $("#idPersona").val();
            //guarda datos de sesion globalmente en el store->vuex 
            this.$store.state.tokenGlobal = this.token;
            this.idPersonaGlobal = this.idPersona;
            this.test();
        }
    }
</script>
