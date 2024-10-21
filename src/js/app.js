
let step = 1;
const finalStep = 3;
const firstStep = 1;

const appointment = {
    id: '',
    name: '',
    date: '',
    hour: '',
    services: []
}

document.addEventListener('DOMContentLoaded', function(){
    inicarApp();
})

function inicarApp (){
    mostrarSeccion(); // Muestra y oculta las secciones
    tabs(); //Cambia de seccion cuando se presionen los tabs
    botonesPaginador(); //Agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();

    consultarAPI(); //Consulta la API en el backend de PHP

    idCliente();
    nombreCliente(); //Añade el nombre del cliente
    seleccionarFecha();
    seleccionarHora();

    mostrarResumen(); //Muestra el resumen de la cita


}

function mostrarSeccion(){

    //Ocultar la seccion que tenga la clase de mostrar
    const previousSection = document.querySelector('.mostrar');
    if (previousSection){
        previousSection.classList.remove('mostrar');
    }

    //Seleccionar la seccion 
    const stepSelector = `#step-${step}`;
    const section =  document.querySelector(stepSelector);
    section.classList.add('mostrar');

    //Quitar class .actual al anterior
    const previousTab = document.querySelector('.actual');
    if (previousTab){
        previousTab.classList.remove('actual');
    }

    //Resalta el tab actual
    const tab = document.querySelector(`[data-step="${step}"]`);
    tab.classList.add('actual');

}

function tabs(){
    const buttons = document.querySelectorAll('.tabs button');

    buttons.forEach(button => {
        button.addEventListener('click', function(e){
            step = parseInt (e.target.dataset.step);

            mostrarSeccion();
            botonesPaginador();

        })
    })
}

function botonesPaginador (){
    const nextPage = document.querySelector('#next');
    const previousPage = document.querySelector('#previous');

    if (step === 1){
        previousPage.classList.add('ocultar');
        nextPage.classList.remove('ocultar');
    }
    else if (step === 3){
        previousPage.classList.remove('ocultar');
        nextPage.classList.add('ocultar');

        mostrarResumen();
    }else{
        previousPage.classList.remove('ocultar');
        nextPage.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior(){
    const previousPage = document.querySelector('#previous');
    previousPage.addEventListener('click', function(){
        
        if (step<= firstStep) return;
        step--;

        botonesPaginador();

    });
}
function paginaSiguiente(){
    const nextPage = document.querySelector('#next');
    nextPage.addEventListener('click', function(){
        
        if (step>= finalStep) return;
        step++;

        botonesPaginador();

    });
}

async function consultarAPI (){
    try {
        const url = '/api/services';
        const result = await fetch(url);
        const services = await result.json();
        mostrarServicios(services);
        

    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios (services){
    services.forEach (service => {
        const {id, servicename, price} = service;

        const serviceName = document.createElement('P');
        serviceName.classList.add('nombre-servicio');
        serviceName.textContent = servicename;

        const servicePrice = document.createElement('P');
        servicePrice.classList.add('precio-servicio');
        servicePrice.textContent = `$${price}`;

        const serviceDiv = document.createElement('DIV');
        serviceDiv.classList.add('servicio');
        serviceDiv.dataset.idServicio = id;
        serviceDiv.onclick = function () {
            seleccionarServicio(service);
        }

        serviceDiv.appendChild(serviceName);
        serviceDiv.appendChild(servicePrice);

        document.querySelector('#services').appendChild(serviceDiv);
    })
}

function seleccionarServicio(service){
    const {id} = service;
    const {services} = appointment;

    //Identificar al elemento que se le da click
    const divService = document.querySelector(`[data-id-servicio="${id}"]`);

    //Comprobar si el servicio fue agregado 
    if (services.some(agregado => agregado.id === id)){
        //Eliminar si esta agregado
        appointment.services = services.filter(agregado => agregado.id !== id);
        divService.classList.remove('seleccionado');
    }else{
        appointment.services = [...services, service];
        divService.classList.add('seleccionado');
    }

}

function idCliente (){
    appointment.id = document.querySelector('#id').value;
}

function nombreCliente () {
    appointment.name = document.querySelector('#name').value;
}

function seleccionarFecha(){
    const inputDate = document.querySelector('#date');
    inputDate.addEventListener('input', function (e){
        const day = new Date(e.target.value).getUTCDay();

        if ([6,0].includes(day)){
            e.target.value = '';
            mostrarAlerta('Fines de semana no permitidos','error', '.formulario');
        }else{
            appointment.date = e.target.value;
        }
    });
}

function seleccionarHora (){
    const inputHour = document.querySelector('#hour');
    inputHour.addEventListener('input', function(e){
        const hourAppo = e.target.value;
        const hour = hourAppo.split(":")[0];

        if (hour <10 || hour >18){
            e.target.value='';
            mostrarAlerta('Hora no valida', 'error', '.formulario');
        }else{
            appointment.hour = e.target.value;
            //console.log(appointment);
        }

    });
}

function mostrarAlerta(msj, tipo, elemento, desaparece = true){ 

    //Previene que se genere mas de una alerta
    const previousAlert = document.querySelector('.alerta');
    if (previousAlert) {
        previousAlert.remove();
    }

    //Generar una alerta
    const alert = document.createElement('DIV');
    alert.textContent = msj;
    alert.classList.add('alerta');
    alert.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alert);

    if (desaparece){
        //Elimina la alerta
        setTimeout(() =>{
            alert.remove();
        }, 3000)
    }
    

}

function mostrarResumen (){

    const resumen = document.querySelector('.contenido-resumen');

    //Limpiar el contenido de resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }


    if (Object.values(appointment).includes('') || appointment.services.length === 0){
        mostrarAlerta('Faltan datos datos o agregar servicios', 'error', '.contenido-resumen',false);
        return;
    }

    // Formatear el div de resumen
    const {name, date, hour, services} = appointment;

    //Heading para servicios en resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);


    //Iterando y mostrando los servicios
    services.forEach(service =>{
        const {id, servicename, price} = service;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = servicename;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: </span> $${price}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    //Heading para servicios en resumen
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);


    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre: </span> ${name}`;

    //Formatear la fecha en español
    const fechaObj = new Date(date);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();


    const fechaUTC = new Date(Date.UTC(year,mes,dia))

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones)

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha: </span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span> ${hour}`;

    //Boton para reservar la cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = "Reservar Cita";
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);

}

async function reservarCita (){

    const {date, hour, services, id} = appointment;
    const idServicios = services.map(servicio => servicio.id);
    //console.log(idServicios);


    const datos = new FormData();
    datos.append('usuarioId', id);
    datos.append('fecha', date);
    datos.append('hora', hour);
    datos.append('servicios', idServicios);

    //console.log([...datos]);


    try {
        //Peticion hacia la Api
        const url = '/api/appointment';

        const respuesta = await fetch(url,{
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();

        if (resultado.resultado.resultado === true){
            Swal.fire({
                icon: "success",
                title: "Cita Registrada",
                text: "Tu cita fue reservada correctamente!",
                button: "Ok"
            }).then(()=> {
                window.location.reload();
            })
        }
        
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Hubo un error al guardar la cita, intentelo más tarde"
          });
    }
    
}