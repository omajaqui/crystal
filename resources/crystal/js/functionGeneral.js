function loadinSweet(op,msj){
    if(op == 0) {
        Swal.fire({
            title: msj,
            allowEscapeKey: false,
            allowOutsideClick: false,
            onOpen: () => {
            Swal.showLoading();
            }
        });
    } else {
        Swal.close();
    }
}

function Sweet(icon,text){
    Swal.fire({
        icon,
        text
    })
}

function loadingGif(op,title){
    if(op == 0){
        Swal.fire({
            title,
            allowEscapeKey: false,
            allowOutsideClick: false,
            imageUrl: 'imgs/loading_crystal.gif',
            imageWidth: 300,
            imageHeight: 225,
            imageAlt: 'Custom image',
            showConfirmButton: false,
            
        });
    }else{
        Swal.close();
    }
}

function sweetBienHecho(title) {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title,
        showConfirmButton: false,
        timer: 1500
    });
}

function cargandoGif(op,title){
    if(op == 0){
        Swal.fire({
            title,
            allowEscapeKey: false,
            allowOutsideClick: false,
            imageUrl: 'imgs/cargando.gif',
            imageWidth: 300,
            imageHeight: 225,
            imageAlt: 'Custom image',
            showConfirmButton: false,
            
        });
    }else{
        Swal.close();
    }
}

/*
** Autor: Omar Jaramillo
** Fecha: 09-11-2020
** Descripcion: formatea un numero y coloca seprador de miles
*/
function format(n) {
    n = n.toString()
    while (true) {
    var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1.$2$3')
    if (n == n2) break
    n = n2
    }
    return n
}

/*
** Autor: Omar Jaramillo
** Fecha: 09-11-2020
** Descripcion: muestra ventana con informacion, al dar click en aceptar redirige al login
*/
function sweetSesionCaduca(text){    
    Swal.fire({
        allowEscapeKey: false,
        allowOutsideClick: false,
        icon: 'warning',
        text,
        showCancelButton: false,
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
    }).then((result) => {        
        if (result.value) {
            window.location.href = "./";                
        }
    });
}

