<template>
    <div>
        <div class="pd-20 card-box mb-30">
            <div class="row">
                <div class="col-md-3 cuotas">
                    <div class="card-box pd-30 height-100-p cuotas_menu" @click="tipoForm='mes'">						
                        <h5 class="text-blue padding-top-10 h5">Cuota Mensual</h5>
					</div>                    
                </div>

                <div class="col-md-3 cuotas">
                    <div class="card-box pd-30 height-100-p cuotas_menu" @click="tipoForm='prestamo'">						
                        <h5 class="text-blue padding-top-10 h5">Cuota de préstamo</h5>
					</div>                    
                </div>
                <div class="col-md-3 cuotas">
                    <div class="card-box pd-30 height-100-p cuotas_menu" @click="tipoForm='multas'">						
                        <h5 class="text-blue padding-top-10 h5">Multas/Infraciones</h5>
					</div>                  
                </div>
            </div>
        </div>
        
        <cuotas-mensual v-if="tipoForm=='mes'"></cuotas-mensual>
        <cuotas-prestamo v-if="tipoForm=='prestamo'"></cuotas-prestamo>
        <cuotas-multas v-if="tipoForm=='multas'"></cuotas-multas>

    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import { mapMutations } from 'vuex';    
    export default {        
        data() {
            return {                
                tipoForm:'',
            };
        },
        computed: {
            ...mapState(['idPersonaGlobal','tokenGlobal','nombreUsuario']),
        },
        methods: {
            //...mapMutations(['aumentar']),
            /* cerrarModal(){
                this.$emit('cerrarModal');
            }, */

            
                    
        },
        
        mounted() {   
        }
    }
</script>

<style>
    .cuotas_menu, .cuotas{
        text-align:center;
        margin:auto;        
    }
    .cuotas_menu:hover{
        transform: scale(1.2);
        transition: ease;
        cursor: pointer;
        box-shadow: 2px 2px 20px 0px rgba(0,0,0,0.75);
    }
</style>
