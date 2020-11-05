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

function sweetConfirm(title,html,icon) {
    Swal.fire({
        title,
        html,
        icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            window.location.replace('/');
        }
      })
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