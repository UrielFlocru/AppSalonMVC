document.addEventListener('DOMContentLoaded',function () {
    iniciarApp();
});

function iniciarApp (){
    buscarFecha();
}

function buscarFecha(){
    const fechaInput = document.querySelector('#date');
    fechaInput.addEventListener('input', function (e){
        const fechaSeleccionada = e.target.value;
        window.location = `?fecha=${fechaSeleccionada}`;
    });
}