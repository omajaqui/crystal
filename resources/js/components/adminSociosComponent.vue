<template>
    <div>
        <div class="card-box pd-20 height-100-p mb-30">
            <!-- tabala simple -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="form-group row box_buscar">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" v-model="buscar" @keyup.enter="listarSocios(1,buscar)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarSocios(1,buscar)" class="btn btn-primary"><i class="icon-copy dw dw-search"></i> Buscar</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">                               
                                    <button class="btn btn-primary" @click="abrilModal(1,'nuevo')"><i class="icon-copy dw dw-add-user"></i> AGREGAR SOCIO</button>
                                </div>
                            </div>
                        </div>                    
                        <div class="card-body p-0">
                            <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 20px;">Editar</th>
                                    <th style="width: 10px;">Ver</th>
                                    <th>Nombres</th>
                                    <th>Telefono</th>
                                    <th>Celular</th>
                                    <th>Correo</th>
                                    <th># Socio</th>
                                    <th>Cuota Mensual</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in dataSocios" :key="item.idPersona">
                                    <td><i class="icon-copy dw dw-edit-1 editar" @click="gestionSocio('editar',item)"></i></td>
                                    <td><i class="icon-copy dw dw-eye ver"    @click="gestionSocio('ver',item)"></i></td>
                                    <td v-text="item.nombres+' '+item.apellidos"></td>
                                    <td v-text="item.telFijo"></td>
                                    <td v-text="item.celular"></td>
                                    <td v-text="item.correo"></td>
                                    <td v-text="item.numeroAsociado"></td>
                                    <td v-text="item.valorCuotaMes"></td>
                                </tr>                            
                            </tbody>
                            </table>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page -1, buscar)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar)" v-text="page"></a>
                                    </li>                    
                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#"  @click.prevent="cambiarPagina(pagination.current_page +1, buscar)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div><!-- /.card-body -->                    
                    </div><!-- /.card -->                
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div>

        <!-- MODAL FRMULARIO AGREGAR SOCIO -->
        <div class="modal fade bs-example-modal-lg" :class="{'mostrar' : modalFormSocio}" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="titleModal"></h4>
                        <button type="button" class="close" @click="cerrarModal(1)">×</button>
                    </div>
                    <div class="modal-body">
                        <!-- <form-socio 
                            @cerrarModal="modalAgregarSocio=0" 
                            @refresh="listarSocios()"
                        ></form-socio> -->
                        <form>
                            <div class="row">
                                <!-- EJEMPLO DE CLASES AL VALIDAR LOS CAMPOS -->
                                <!-- <div class="col-md-6 col-sm-12">
                                    <div class="form-group has-success">
                                        <label class="form-control-label">Input with success</label>
                                        <input type="text" class="form-control form-control-success">
                                        <div class="form-control-feedback">Success! You've done it.</div>
                                        <small class="form-text text-muted">Example help text that remains unchanged.</small>
                                    </div>
                                    <div class="form-group has-warning">
                                        <label class="form-control-label">Input with warning</label>
                                        <input type="text" class="form-control form-control-warning">
                                        <div class="form-control-feedback">Shucks, check the formatting of that and try again.</div>
                                        <small class="form-text text-muted">Example help text that remains unchanged.</small>
                                    </div>
                                    <div class="form-group has-danger">
                                        <label class="form-control-label">Input with danger</label>
                                        <input type="text" class="form-control form-control-danger">
                                        <div class="form-control-feedback">Sorry, that username's taken. Try another?</div>
                                        <small class="form-text text-muted">Example help text that remains unchanged.</small>
                                    </div>
                                </div> -->
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Tipo documento</label>
                                        <select class="form-control" v-model="tipoDocumento">
                                            <option value="RC">Registro civil</option>
                                            <option value="TI">Tarjeta de identidad</option>
                                            <option value="CC">Cédula de ciudadania</option>
                                            <option value="DNI">DNI (Documento Identificación Nacional)</option>
                                            <option value="CE">Cédula extranjeria</option>
                                        </select>
                                    </div>                
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Documento</label>
                                        <input type="number" class="form-control" v-model="documento">                    
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Numero asociado</label>
                                        <select class="form-control" v-model="numeroAsociado">
                                            <option v-for="item in arrayNumerosAsociado" :key="item.idNumeroAsosciado" :value="item.numeroAsociado">{{item.numeroAsociado}}</option>
                                        </select>                  
                                    </div>
                                </div>           
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Nombres</label>
                                        <input type="text" class="form-control" v-model="nombres">                    
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Apellidos</label>
                                        <input type="text" class="form-control" v-model="apellidos">                    
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Correo</label>
                                        <input type="email" class="form-control" v-model="correo">                    
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Ciudad</label>
                                        <input type="text" class="form-control" v-model="ciudad">                    
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Barrio</label>
                                        <input type="text" class="form-control" v-model="barrio">                    
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <input type="email" class="form-control" v-model="direccion">                    
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Teléfono fijo</label>
                                        <input type="number" class="form-control" v-model="tFijo">                    
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Celular</label>
                                        <input type="text" class="form-control" v-model="celular">                    
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Valor cuota mensual</label>
                                        <input type="number" class="form-control" v-model="cuotaMes" placeholder="$">                    
                                    </div>
                                </div>            
                            </div> 
                        </form>	
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal(1)">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarSocio()">Guardar</button>
                    </div>                    
                </div>
            </div>
        </div>

        <!-- MODAL VISTA INFORMACION DE SOCIO -->
        <div class="modal fade bs-example-modal-lg" :class="{'mostrar' : modalVerSocio}" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="titleModal"></h4>
                        <button type="button" class="close" @click="cerrarModal(2)">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Nombres</b></label>
                                    <p v-text="viewNombreCompleto"></p>
                                </div>                
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>N° Documento</b></label>
                                    <p v-text="viewDocumento"></p>
                                </div>                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Teléfonos</b></label>
                                    <p v-text="viewTelefono"></p>
                                </div>                
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Ubicación</b></label>
                                    <p v-text="viewContacto"></p>
                                </div>                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Datos Ahorro</b></label>
                                    <p v-text="viewAhorrroSocio"></p>
                                </div>                
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Direcciones</b></label>
                                    <p v-text="viewDirecciones"></p>
                                </div>                
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="cerrarModal(2)">Aceptar</button>
                    </div>                    
                </div>
            </div>
        </div>        
        
    </div>
</template>

   
<script>    
    export default {
        data() {
            return {
                dataSocios: [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                buscar : '',

                //modales
                modalFormSocio:0,
                modalVerSocio:0,
                titleModal:'',

                //datos precargados
                arrayNumerosAsociado: [],

                //formulario add socio
                tipoDocumento:'',
                documento:'',
                numeroAsociado:'',
                nombres:'',
                apellidos:'',
                correo:'',
                tFijo:'',
                celular:0,
                ciudad:'',
                barrio:'',
                direccion:'',
                cuotaMes:'',

                //validacioon de campo
                error:false,
                errorCampo:'',
                
                //varibles al editar la info de un socio
                editando: 'N',
                numeroAsociadoAnterior: '',
                idPersona: '',

                //variables al mostrar datos del socio
                viewNombreCompleto: '',
                viewDocumento: '',
                viewTelefono: '',
                viewContacto: '',
                viewDirecciones:'',
                viewAhorrroSocio:'',
            };
        },

        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },

        methods: {

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: consulta un listado de socios segus parametros de busqueda, o trae todos los socios guardados en BD
            */
            listarSocios(page, buscar){ 
                loadingGif(0,'Cargando...');
                const url = 'listarSocios';
                axios.post(url,{
                    accion: 'listarSocios',
                    page,
                    buscar
                }).then(response => {
                    let resp=response['data']['respuesta'];
                    if(resp['Continuar'] == 'S'){
                        this.dataSocios = resp['Socios']['data'].filter(s => s.idTipoUsuario == 3);
                        this.pagination = resp['pagination'];
                    }                    
                    loadingGif(1,'');
                })
                .catch(error => {
                    console.log(error);
                });
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: cambia datos en el paginador
            */
            cambiarPagina(page, buscar){
                let me = this;
                me.pagination.current_page = page;
                me.listarSocios(page, buscar);
            },


            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: abre un modal u otro dependiendo del parametro recibido, establece variables o restablece campos
            */
            abrilModal(level,accion){ 
                switch (level) {
                    case 1:                           
                        if (accion == 'nuevo')  { this.titleModal = 'Agregar socio';  this.editando="N"; this.restablecerCampos(); }
                        if (accion == 'editar') { this.titleModal = 'Editar datos del Socio'; this.editando="S" }
                        this.modalFormSocio = 1;
                        break;
                    case 2:
                        this.titleModal = 'Información del socio';
                        this.modalVerSocio = 1;

                }
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: cierra un modal abierto con parametro level
            */
            cerrarModal(level){
                this.titleModal = '';
                switch (level) {                    
                    case 1: this.modalFormSocio = 0; this.editando="N"; this.restablecerCampos(); break;
                    case 2: this.modalVerSocio  = 0; this.restablecerViewDatosSocio(); break;
                }
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: abre un modal con formulario de socio, nuevo o con datos del socio seleccionado
            */
            gestionSocio(accion,socio){
                loadingGif(0,'Cargando.');
                if (accion == 'editar') {
                    this.llenarCampos(socio);
                    this.abrilModal(1,'editar'); 
                }
                if (accion == 'ver') { this.viewDatosSocio(socio); this.abrilModal(2);}
                loadingGif(1,'');
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: valida la procedencia del form y establece variables para hacer llamado a metodo de guardado o update
            */
            guardarSocio(){
                let accion = '';
                this.validarCampos();
                if(this.errorCampo) {
                    Sweet('info','Debe completar el campo '+this.errorCampo);
                }else{
                    if(this.editando == 'S') {accion="editarSocio";}
                    if(this.editando == 'N') {accion="guardarSocio";}
                    this.guardarSocioConfirmar(accion);
                }
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: valida si los campos estan diligenciados returna true o false
            */
            validarCampos(){
                this.errorCampo=false;
                if(this.tipoDocumento == '')    {this.error = true; this.errorCampo='Tipo documento'; return;}
                if(this.documento == '')        {this.error = true; this.errorCampo='Documento'; return;}
                if(this.numeroAsociado == '')   {this.error = true; this.errorCampo='Número asociado'; return;}
                if(this.nombres == '')          {this.error = true; this.errorCampo='Nombres'; return;}
                if(this.apellidos == '')        {this.error = true; this.errorCampo='Apellidos'; return;}
                if(this.correo == '')           {this.error = true; this.errorCampo='Correo'; return;}
                if(this.tFijo == '')            {this.error = true; this.errorCampo='Teléfono fijo'; return;}
                if(this.celular == '')          {this.error = true; this.errorCampo='Celular'; return;}
                if(this.ciudad == '')           {this.error = true; this.errorCampo='Ciudad'; return;}
                if(this.barrio == '')           {this.error = true; this.errorCampo='Barrio'; return;}
                if(this.direccion == '')        {this.error = true; this.errorCampo='Dirección'; return;}
                if(this.cuotaMes == '')         {this.error = true; this.errorCampo='Valor cuota mensual'; return;}  
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: inserta o actualiza datos de persona, socio, numerosasociados y usuario
            */
            guardarSocioConfirmar(accion){
                loadingGif(0,'Guardando');
                let parametros = {
                    accion,
                    tipoDocumento: this.tipoDocumento,
                    documento: this.documento,
                    numeroAsociado: this.numeroAsociado,
                    nombres: this.nombres,
                    apellidos: this.apellidos,
                    correo: this.correo,
                    tFijo: this.tFijo,
                    celular: this.celular,
                    ciudad: this.ciudad,
                    barrio: this.barrio,
                    direccion: this.direccion,
                    cuotaMes: this.cuotaMes,
                    idPersona: this.idPersona,
                    numeroAsociadoAnterior: this.numeroAsociadoAnterior
                };
                let url = 'confirmarGuardar';
                axios.post(url,parametros).then(response => {
                    let resp=response['data']['respuesta'];
                    if(resp['Continuar'] == 'S'){
                        this.cerrarModal(1);
                        this.restablecerCampos();
                        loadingGif(1,'');
                        this.cargarDatosForm();
                        this.listarSocios(1,this.buscar);
                        sweetBienHecho('Guardao Correctamente');
                    }else{
                        loadingGif(1,'');
                        Sweet('info',resp['Mensaje']);
                    } 
                })
                .catch(error => {
                    console.log(error);
                    loadingGif(1,'');
                });
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: actualiza el listado de numeros de asociado disponibles
            */
            cargarDatosForm(){
                loadingGif(0,'Cargando datos.');
                let url = 'consultarNumsAsociado';
                axios.post(url).then(response =>{
                    let resp = response.data.respuesta;
                    if(resp['Continuar'] == 'S') {
                        this.arrayNumerosAsociado = resp['Numeros'];
                    }else{
                        Sweet('info',resp['Mensaje']);
                    }
                    
                    loadingGif(1,'');
                }).catch(e => {
                    console.log(e);
                    loadingGif(1,'');
                });
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: establece todos los campos del formulario socio a vacios
            */
            restablecerCampos(){
                //formulario add socio
                this.tipoDocumento= '';
                this.documento= '';
                this.numeroAsociado= '';
                this.nombres= '';
                this.apellidos= '';
                this.correo= '';
                this.tFijo= '',
                this.celular= '';
                this.ciudad= '';
                this.barrio= '';
                this.direccion= '';
                this.cuotaMes= '';

                this.numeroAsociadoAnterior = '';
                this.idPersona = '';
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: llena todos los campos del formulario con los datos del socio seleccionado
            */
            llenarCampos(socio){
                this.numeroAsociadoAnterior = socio['numeroAsociado'];
                this.idPersona = socio['idPersona'];

                this.tipoDocumento = socio['tipoDocumento'];
                this.documento = socio['documento'];
                this.numeroAsociado = socio['numeroAsociado'];
                this.nombres = socio['nombres'];
                this.apellidos = socio['apellidos'];
                this.correo = socio['correo'];
                this.ciudad = socio['ciudad'];
                this.barrio = socio['barrio'];
                this.direccion = socio['direccion'];
                this.tFijo = socio['telFijo'];
                this.celular = socio['celular'];
                this.cuotaMes = socio['valorCuotaMes'];
            },

            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: llena los datos para mostrar del socio
            */
            viewDatosSocio(socio){
                this.viewNombreCompleto = socio['nombres']+' '+socio['apellidos'];
                this.viewDocumento = socio['tipoDocumento']+' '+socio['documento'];
                this.viewTelefono = 'Fijo: '+socio['telFijo']+'. Celuar: '+socio['celular'];
                this.viewContacto = 'Ciudad: '+socio['ciudad']+'. Barrio: '+socio['barrio'];
                this.viewDirecciones = 'Dirección: '+socio['direccion']+'. Correo: '+socio['correo'];
                this.viewAhorrroSocio = 'Cuota Mensula: '+socio['valorCuotaMes']+'. Numero de asociado: '+socio['numeroAsociado'];
            },
            
            /*
            ** Fecha: 3/10/2020
            ** Autor: Omar jaramillo
            ** descripcion: restablece a vacio los datos para mostrar del socio
            */
            restablecerViewDatosSocio() {
                this.viewNombreCompleto = '';
                this.viewDocumento = '';
                this.viewTelefono = '';
                this.viewContacto = '';
                this.viewDirecciones = '';
                this.viewAhorrroSocio ='';
            }

           
        },

        mounted() {
            this.listarSocios(1,this.buscar);
            this.cargarDatosForm();
        }
    }
</script>
<style>
    .box_buscar{
        margin-top: 20px;
        margin-left: 10px;
        margin-bottom: -10px;
    }

    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a;
    }

    .editar{
        font-size: 20px;
        color:rgb(12, 35, 165);
    }  

    .ver{
        font-size:20px;
        color:rgb(228, 33, 33);
    }  
</style>

