$(document).ready(function () {

    "use strict";
    
    /* Scripts para perfil.html */
    // Iniciacion de variables
    var datepicker = new Datepickk();
    datepicker.today = true;
    datepicker.weekStart = 1;
    datepicker.maxSelections = 1;
    datepicker.container = document.querySelector('#calendario');
    datepicker.disabledDays = [6, 0];
    datepicker.minDate = datepicker.currentDate;

    var fecha = new Date();
    datepicker.show();

    var valCita = '';
    var valLocalizacion = '';
    var valHora = '';

    // Definicion de highlights para las fechas
    var highlight = {
        dates : [
            {
                start: new Date(2019, 2, 1),
                end: new Date(2019, 2, 10)             
            },
            {
                start: new Date(2019, 2, 15),
                end: new Date(2019, 2, 22)                 
            }
        ],
        backgroundColor: '#a5efde',
        color: '#ffffff',
        legend: 'Consultas'
    };

    var highlight2 = {
        start: new Date(2019, 2, 10),
        end: new Date(2019, 2, 25),
        backgroundColor: '#f2cd54',
        color: '#ffffff',
        legend: 'Ecografias' 
    };

    var highlight3 = {
        start: new Date(2019, 2, 10),
        end: new Date(2019, 2, 15),
        backgroundColor: '#722c38',
        color: '#ffffff',
        legend: 'Cli. POZ' 
    };

    var highlight4 = {
        start: new Date(2019, 2, 20),
        end: new Date(2019, 2, 25),
        backgroundColor: '#7a3068',
        color: '#ffffff',
        legend: 'Cli. Chilemex' 
    };

    var highlight5 = {
        start: new Date(2019, 2, 15),
        end: new Date(2019, 2, 20),
        backgroundColor: '#348775',
        color: '#ffffff',
        legend: 'Cli. SA' 
    };

    var highlight6 = {
        start: new Date(2019, 2, 1),
        end: new Date(2019, 2, 25),
        backgroundColor: '#ffe644',
        color: '#ffffff',
        legend: 'Mañana'
    }

    var highlight7 = {
        start: new Date(2019, 2, 15),
        end: new Date(2019, 2, 27),
        backgroundColor: '#333',
        color: '#ffffff',
        legend: 'Tarde'
    }

    // Funciones para la seleccion de multiples opciones en el calendario
    $('#tipo-cita').change(function () {
        if (valCita != '') {
            datepicker.highlight = null;
            datepicker.highlight = [getHighlight(this.value), getHighlight(valLocalizacion), getHighlight(valHora)];
        } else if (valCita == '') {
            datepicker.highlight = [getHighlight(this.value), getHighlight(valLocalizacion), getHighlight(valHora)];
        }
        $('#calendario').css({
            'height': '400px'
        });
        valCita = this.value;
    });

    $('#localizacion').change(function () {
        if (valLocalizacion != '') {
            datepicker.highlight = null;
            datepicker.highlight = [getHighlight(valCita), getHighlight(this.value), getHighlight(valHora)];
        } else if (valLocalizacion == '') {
            datepicker.highlight = [getHighlight(valCita), getHighlight(this.value), getHighlight(valHora)];
        }
        $('#calendario').css({
            'height': '400px'
        });
        valLocalizacion = this.value;
    });

    $('#horario').change(function () {
        if (valHora != '') {
            datepicker.highlight = null;
            datepicker.highlight = [getHighlight(valCita), getHighlight(valLocalizacion), getHighlight(this.value)];
        } else if (valHora == '') {
            datepicker.highlight = [getHighlight(valCita), getHighlight(valLocalizacion), getHighlight(this.value)];
        }
        $('#calendario').css({
            'height': '400px'
        });
        valHora = this.value;
    });

    datepicker.onSelect = function (checked) {
        var state = (checked) ? 'selected' : 'unselected';
        if (this.getTime() >= fecha.getTime()) {
            if (($('#horario option:selected').val() != '') && ($('#localizacion option:selected').val() != '') && ($('#tipo-cita option:selected').val() != '')) {
                datepicker.button = 'Citar';
            }
        } else {
            datepicker.button = '';
            datepicker.unselectAll();
        }
    };

    // Funcion para la seleccion de cita
    datepicker.onConfirm = function () {
        $('#options').hide();
        var fechaCita = $('#fecha');
        var localizacion = $('#ubicacion');
        var horario = $('#hora');
        var tipoCita = $('#tipo');

        fechaCita.append(document.createTextNode(datepicker.selectedDates[0].toLocaleString().slice(0, 9)));
        localizacion.append(document.createTextNode($("#localizacion option:selected").text()));
        horario.append(document.createTextNode($("#horario option:selected").text()));
        tipoCita.append(document.createTextNode($("#tipo-cita option:selected").text()));

        $('#confirm').css({
            'animation-name': 'slide',
            'animation-duration': '.2s',
            'animation-timing-function': 'ease-in',
            'animation-fill-mode': 'both'
        });
        $('#confirm').show();
        $('#calendario').css({
            'height': '350px'
        });
    }
    
    $('#paymentButton').on('click', function() {
        $('#confirm').hide();
        $('#options').show();
    });

    // Funcion para obtener el highlight por valor
    function getHighlight(val) {
        switch (val) {
            case 'consulta':
                return highlight;
            case 'ecografia':
                return highlight2;
            case 'poz':
                return highlight3;
            case 'chilemex':
                return highlight4;
            case 'san':
                return highlight5;
            case 'manana':
                return highlight6;
            case 'tarde':
                return highlight7;
        }
    }
});
