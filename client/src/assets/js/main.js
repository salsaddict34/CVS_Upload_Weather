import $ from 'jquery';
import 'jszip';
import * as pdfMake from 'pdfmake/build/pdfmake.js';
import * as pdfFonts from 'pdfmake/build/vfs_fonts';
pdfMake.vfs = pdfFonts.pdfMake.vfs;
// import 'pdfmake';
import "datatables.net";
import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.colVis.js';
import 'datatables.net-buttons/js/buttons.html5.js';
import 'datatables.net-buttons/js/buttons.print.js';
import "datatables.net-dt";
import 'datatables.net-buttons-dt';
import 'datatables.net-colreorder-dt';
import 'datatables.net-select-dt';
import 'datatables.net-responsive-dt';
import 'datatables.net-rowreorder-dt';
import * as Weather from './modules/weather.js';
import TestModule from 'module-test';
import "../css/style.css";

$(function () {

    Weather.refreshFromLocalStorage();
    $('.tableW').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#btn').on('click', function (event) {
        Weather.fetchCityWeather($('#addCity').val());
        $('#addCity').val("");
        event.preventDefault();
    })
    $('.delete').on('click', function (event) {
        Weather.deleteCity($(event.target).attr('name'));
        event.preventDefault();
    })
    TestModule();
});
