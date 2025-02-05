// constantes de herramientas de cyetchn
"use strict";

const formnormalclass = "form-normal";
const debug = true;

// validamos el dominio si no es localhost colocamos el dominio de la pagina
const dominio = window.location.hostname == "localhost" ? "http://localhost/casino/OTSC/" : "http://cytechn.ddns.net/";

// consante de errores controlados
const error = {
    "FORMINCOMPLETO": "Ocurrió un error al recaudar la información de la página, por favor contacte al administrador del sistema.",  // 1001
    "FORMSENDERROR": "Ocurrió un error al enviar los datos, por favor contacte al administrador del sistema.",  // 1002
    "REQUESTERROR": "Ocurrió un error al solicitar los datos al servidor, por favor contacte al administrador del sistema.", // 1003

    "CYTECHNTOKEN": "D4F8FF5E5B6A01C59836CCDDAA45F2C5BA5FA6586A55S4", // 2001
}

// heredamos la funcion console.log para poder lansar a consola mientras constante debug sea true  
function clog(args){
    if(debug){
        console.log(args);
    }
}

class cyetchnHerramientas {
    constructor(){
        this.formNormal();
        this.dataTableCytechn();
    }

    /*
    *   Funcion para enviar un formulario de manera asincrona
    *   tiene que llevar una clase espesifica, la cual se encuentra en la constante formnormalclass
    *  y tiene que tener los atributos action y method en el formulario
    * ejemplo:
    *  <form class="form-normal" action="url" method="post">
    *      <input type="text" name="nombre">
    *     <input type="submit" value="Enviar">
    * </form>
    * el mensaje que debe de resivir el servidor tiene que ser un json con los siguientes atributos
    * --> status: success o danger
    * --> mensaje: mensaje que se mostrara en el notify
    * --> tipo: tipo de notificacion que se mostrara en el notify (success, danger, warning, info, toast)
    * --> reset: true o false, si es true se reseteara el formulario
    * --> redirect: url a donde se redirigira despues de enviar el formulario
    * --> reload: true o false, si es true se recargara la pagina despues de enviar el formulario
    * --> modal: true o false, si es true se cerrara el modal despues de enviar el formulario
    * ejemplo:
    * {"status":"success", "mensaje":"El registro se ha guardado correctamente", "tipo":"success"}
    * enviara un console.log si el debug es true, puedes cambiar el valor de debug en la constante debug
    */
    formNormal(){
        $("."+formnormalclass).submit(function(e){
            e.preventDefault();
            var form = $(this);
            if(form.attr("action") == undefined || form.attr("method") == undefined){
                swal.fire({
                    title: "Error [1001]",
                    text: error.FORMINCOMPLETO,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 10000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    showCloseButton: true
                });
                return;
            }
            $.ajax({
                url: dominio + form.attr("action"),
                method: form.attr("method"),
                data: form.serialize() + "&T=" + error.CYTECHNTOKEN,
                dataType: "json",
                success: function(data){
                    try{
                        swal.fire({
                            title: data.titulo,
                            text: data.mensaje,
                            icon: data.tipo,
                            showConfirmButton: false,
                            timer: 10000,
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            showCloseButton: true
                        });
                        if(data.reset){
                            form.trgger("reset");
                        }
                        if(data.redirect){
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 5000);
                        }
                        if(data.reload){
                            window.location.reload();
                        }
                        if(data.modal){
                            form.closest(".modal").modal("hide");
                        }
                        clog(data);
                    }catch(e){
                        swal.fire({
                            title: "Error [1003]",
                            text: error.FORMSENDERROR,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 10000,
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            showCloseButton: true
                        });
                        clog(e);
                        clog(data);
                    }
                },
                error: function(e){
                    swal.fire({
                        title: "Error [1002]",
                        text: error.FORMSENDERROR,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 10000,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        showCloseButton: true
                    });
                    clog(e);
                }
            });
        });
    }

    /**
     * Funcion para iniciar un datatable de manera asincrona, la funcion s debe de llamar desde la pagina donde esta la tabla con el id de la tabla
     * tiene que tener un data-link con la url de donde se obtendran los datos
     * ejemplo:
     * <table id="tabla" data-link="url">
     */
    dataTableCytechn(){

        //Configuración básica del DataTable
        const basicConfig = {
            info: true,                  // Mostrar información sobre la cantidad de registros
            paging: true,                // Hacer visible el sistema de página
            lengthChange: true,          // Habilitar cambio de número de filas por página
            pageLength: 10,             // Número inicial de filas por página (página 1)
            lengthMenu: [[1, 10, 20, 25, 50, -1], [1, 10, 20, 25, 50, 'Todas']], // Menú de opciones para cambiar el número de filas
            searching: true,             // Habilitar la búsqueda en todas las columnas
            ordering: true,             // Activar el ordenado de las columnas
            order: [[0, "desc"]],       // Ordenar la primera columna en descenso por defecto
            processing: true,           // Mostrar mensaje de procesamiento
            serverSide: true,            // Configurar una fuente externa de datos (server-side)
            responsive: true,           // Hacer la tabla responsiva
            fixedHeader: true,          // Fijar el encabezado de la tabla
            autoWidth: false,            // Ajustar automáticamente el ancho de las columnas
            stateSave: true,             // Guardar el estado de la tabla (página, orden, búsqueda, etc.)
        };
        // Configuración del lenguaje de la tabla
        const languageConfig = {
            sProcessing: 'Procesando...',         // Mensaje al procesar los datos
            sLengthMenu: 'Mostrar _MENU_ registros',  // Menú para cambiar el número de filas
            sZeroRecords: 'No se encontraron resultados',   //Mensaje si no hay resultados
            sEmptyTable: 'No hay datos disponibles en la tabla',
            sInfo: '_START_ - _END_ de _TOTAL_',      //Información sobre el número de registros
            sInfoEmpty: '0 - 0 de 0',               //Mensaje cuando no hay datos y la tabla está vacía
            sInfoFiltered: '(filtrado de _MAX_ registros)',   //Informe filtrado
            sSearch: 'Buscar:',                      //Prompt para la búsqueda
            sUrl: '',                             //URL para redireccionar al resultado de la búsqueda
            sInfoThousands: ',',                  // Separador thousand en los números
            sLoadingRecords: 'Cargando...',         //Mensaje mientras se cargan los registros
            oPaginate: {
                sFirst: '<i class="fa fa-angle-double-left"></i>',  //Botón de "Primero"
                sLast: '<i class="fa fa-angle-double-right"></i>',   //Botón de "Último"
                sNext: '<i class="fa fa-angle-right"></i>',         //Botón de "Siguiente"
                sPrevious: '<i class="fa fa-angle-left"></i>'        //Botón de "Anterior"
            },
            oAria: {
                sSortAscending: ': Activar para ordenar la columna en ascendente',
                sSortDescending: ': Activar para ordenar la columna en descendente'
            },
            buttons: {
                copyTitle: 'Copiado al portapapeles',     //Texto del botón de copiar
                copySuccess: {
                    "_": '%d filas copiadas',          //Mensaje si se copian x filas
                    "1": '1 fila copiada'             //Mensaje si se copia 1 fila
                },
                pageLength: {
                    "_": "Mostrar %d filas",         //Texto del botón para cambiar número de filas
                    "-1": "Mostrar Todo"           //Texto para mostrar todas las filas
                }
            },
            select: {
                rows: {
                    "_": "%d filas seleccionadas",     //Mensaje cuando se selectan x filas
                    "0": "Haz clic en una fila para seleccionarla",   //Mensaje si no se ha seleccionado ninguna
                    "1": "1 fila seleccionada"       //Mensaje si se ha seleccionado 1 fila
                }
            }
        };
        // Configuración de los botones personalizados
        const buttonsConfig = [
            {
                extend: 'excelHtml5',          //Tipo de botón (exportar a Excel)
                text: '<i class="fa fa-file-excel"></i> Excel',      //Texto del botón
                titleAttr: 'Exportar a Excel',     //Atributo del título del botón
                className: 'btn btn-success',      //Clase CSS para estilizar el botón
                exportOptions: {
                    columns: ':visible',         //Hacer visible solo las columnas visibles
                    rows: ':visible'           //Hacer visible solo las filas visibles
                },
                title: 'Control Casinos by CyTechnologies',  //Título del documento
                filename: function(){
                    const d = new Date();      //Fecha actual
                    return document.title + ' ' + d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();  //Nombre del archivo
                },
                messageTop: 'ControlCasinos by CyTechnologies'
            },
            {
                extend: 'pdfHtml5',           //Tipo de botón (exportar a PDF)
                text: '<i class="fa fa-file-pdf"></i> PDF',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                },
                title: 'Control Casinos by CyTechnologies',
                filename: function(){
                    const d = new Date();      //Fecha actual
                    return document.title + ' ' + d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();  //Nombre del archivo
                },
                messageTop: 'ControlCasinos by CyTechnologies'
            },
            {
                extend: 'print',             //Tipo de botón (imprimir)
                text: '<i class="fa fa-print"></i> Imprimir',
                titleAttr: 'Imprimir',
                className: 'btn btn-secondary',
                exportOptions: {
                    columns: ':visible',
                    rows: ':visible'
                },
                title: 'Control Casinos by CyTechnologies',
                filename: function(){
                    const d = new Date();      //Fecha actual
                    return document.title + ' ' + d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();  //Nombre del archivo
                },
                messageTop: 'ControlCasinos by CyTechnologies'
            },
            {
                extend: 'colvis',             //Tipo de botón (ver/ocultar columnas)
                text: '<i class="fa fa-eye"></i> Columnas',
                titleAttr: 'Ver/Ocultar Columnas',
                className: 'btn btn-warning',
                columns: ':gt(0)'           //Hacer visible solo las columnas desde la primera
            },
            {
                text: '<i class="fa fa-refresh"></i> Recargar',    //Texto del botón de recargar
                titleAttr: 'Recargar',
                className: 'btn btn-info',
                action: function(e, dt) {     //Acción al hacer clic en el botón de recargar
                    dt.ajax.reload();        //Recargar la tabla con los nuevos datos
                }
            }
        ];


        // Inicialización de la tabla con las configuraciones anteriores y las personalizadas de cada tabla en particular (si las hay)
        $(".datatableCytechn").each(function(){
            const tableContainer = $(this);
            // Configuración del AJAX para manejar datos externos
            const ajaxConfig = {
                url: dominio + `${tableContainer.attr('data-link')}`, // URL donde se encuentra el archivo o servicio de datos
                type: 'POST',                           // Metodo de envío de datos
                data: "T=" + error.CYTECHNTOKEN,
                dataSrc: 'data',                         // Objeto que contiene los datos a mostrar
                dataType: 'json'                        // Tipo de datos que se esperan recibir
            };
            tableContainer.DataTable({
                config: basicConfig,
                ajax: {
                    url: dominio + `${tableContainer.attr('data-link')}`, // URL donde se encuentra el archivo o servicio de datos
                    type: 'POST',                           // Metodo de envío de datos
                    data: function(d) {
                        return {
                            d,
                            T: error.CYTECHNTOKEN
                        };
                    },
                    dataSrc: 'data',                         // Objeto que contiene los datos a mostrar
                    dataType: 'json'                        // Tipo de datos que se esperan recibir
                    },
                language: languageConfig,
                buttons: buttonsConfig,
                dom: "<'row'<'col-md-6'l><'col-md-6'f>>Brtip",
                initComplete: function() {              //Función llamada cuando el DataTable se inicializa
                    console.log('Tabla initialized successfully');  //Mensaje de éxito al cargar la tabla$(this).buttons().container().appendTo( '#'+tableContainer.attr('id')+'Buttons' );
                }
            }).buttons().container().appendTo( '#'+$(tableContainer).attr('id')+'Buttons');
        });
    }
}