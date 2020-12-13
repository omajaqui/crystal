<template>
    <div>
        <div class="pd-20 card-box mb-30">
            <p class="text-center titulo">CRYSTAL.</br>
                REGLAMENTO DE LA NATILLERA
            </p>
            <p><b>OBJETO SOCIAL: </b>El objetivo principal de la natillera, fomentar el ahorrro entre sus asociados para alivianarles los gastos decembrinos del siguiente año.</p>
            <br>
            <p><b>1. DURACIÓN: </b>Inicia el día 1 al 15 de diciembre de 2020 y finaliza el 15 de noviembre de 2021.</p>
            <p><b>2. CUOTA: </b>La cuota mínima de ahorro es de $20.000 (veinte mil pesos) mensuales, a partir de este monto puede ahorrar lo que desee mensualmente, es decir, no se podrá ahorrar un valor menor al pactado a inicio del ahorro.</p>
            <p><b>3. FECHA DE PAGO: </b>la fecha límite para cancelar la cuota mensual es hasta el día 1 del siguiente mes o en su defecto 2 si el primero no es día hábil. Si el socio paga después de estos días tendrá un cobro por multa de $500 (quinientos pesos) por día de atraso (los cuales serán tomados como actividad y repartido en partes iguales para todos los socios).</p>
            <br>
            <p><b>4. PRÉSTAMOS</b></p>
            <p><b>4.1 </b>Para solicitar el préstamo debe ser con 8 días de anticipación con el fin de recaudar el dinero solicitado.</p>
            <p><b>4.2 </b>Para los socios el préstamo tendrá un 5% de interés mensual.</p>
            <p><b>4.3 </b>Se prestará solo hasta 75% del máximo ahorrado, en caso de necesitar más dinero es necesario un socio de la natillera como codeudor.</p>
            <p><b>4.4 </b>Las personas que no pertenezcan a la natillera tendrán que tener un SOCIO como codeudor y la cantidad a prestar será hasta el 75% del máximo ahorrado de dicho socio. Este tendrá un 10% de interés mensual.</p>
            <p><b>4.5 </b>El socio que requiera el préstamo debe firmar una letra como constancia de este.</p>
            <p><b>4.6 </b>Si uno de los socios toma el papel de codeudor para una persona que no pertenezca a la natillera, la letra será firmada por el socio y codeudor.</p>
            <p><b>4.7 </b>A partir del 1 de octubre no se realizarán prestamos (esto con el fin de ir recaudando el dinero prestado y poder cancelar la natillera a tiempo).</p>
            <p><b>4.8 </b>Los préstamos deben estar cancelados, máximo el 1 de noviembre.</p>
            <br>
            <p><b>5. RETIRO DE SOCIOS</b></p>
            <p><b>5.1 </b>El socio que se retire antes del 15 de noviembre NO TENDRA DERECHO A UTILIDADES DE LAS ACTIVIDADES NI A LOS INTERESES, y se le devolverá el capital ahorrado hasta el momento de su retiro. al momento de realizar la liquidación seran descontandos saldos pendientes a la fecha como intereses, multas, pollas sin cancelar, saldos de préstamos. el socio debe anunciar su retiro con al menos un mes de anticipación.</p>
            <p><b>5.2 </b>En caso de que uno de los socios se atrase en 3 meses aleatorios o consecutivos, será expulsado automáticamente de la natillera y sin liquidación de los intereses.</p>
            <br>
            <p><b>6. ACTIVIDADES</b></p>
            <p><b>6.1 </b>Se realizará una polla mensual con un valor de $10.000 (OBLIGATORIA), el socio que gane la polla recibirá el 50% del total recaudado en dinero, el otro 50% será ganancia para la natillera, la polla jugará con el número que identifica al socio dentro de la misma. Este evento será el último viernes de cada mes con las dos úlmias cifras de la loteria de Medellín. Si no gana ningún número que identifique a algún socio. el total del valor de la polla será ganancia para la natillera.</p>
            <p><b>6.2 </b>Para participar en la polla esta debe estar cancela antes del evento. Socio que no haya cancelado la polla al momento del evento no participa en la misma.</p>
            <p><b>6.3 </b>Si un socio de la natillera gana una polla y tiene saldos pendientes por pagar en la natillera como: intereses de los préstamos, pollas o multas. Se le descuenta de la ganancia el valor correspondiente.</p>
            <br>
            <p><b>7. LIQUIDACIÓN DE LA NATILLERA</b></p>
            <p><b>7.1 </b>La natillera será liquidada a más tardar el día 30 de noviembre.</p>
            <p><b>7.2 </b>En el momento de la liquidación el socio recibirá junto con su dinero, utilidades de actividades e intereses de préstamo y la especificación de cada uno de estos procesos.</p>
            <br>
            <p style="font-size: 20px"><b>!IMPORTANTE¡</b></p>
            <p style="font-size: 20px">Leer muy bien estas reglas para culaquier reclamo queja o duda.</p>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import { mapMutations } from 'vuex';
    export default {
        data() {
            return {

            };
        },
        computed: {
            ...mapState(['idPersonaGlobal','tokenGlobal','nombreUsuario']),
        },
        methods: {
            ...mapMutations(['restablecer']),

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
                        case '':                            
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
        }
    }
</script>

<style>
    .titulo{
        color: blue;
        font-size: 20px;
        font-weight: bold;
    }
</style>
