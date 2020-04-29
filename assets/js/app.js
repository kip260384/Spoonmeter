import '../css/app.css';

import $ from 'jquery';
require('bootstrap');
require('select2');

const apiUrl = '/api/v1/';

$(document).ready(function() {
    $('.select2').select2({
        placeholder: 'Select an option'
    });

    $('#converter_form').submit(function(e) {
        e.preventDefault();
        let substance = $('#substance').find(':selected').val();
        let amount = $('#amount').val();
        let unit_from = $('#unit_from').find(':selected').val();
        let unit_to = $('#unit_to').find(':selected').val();

        $.get(apiUrl+"convert", {
            'substance': substance, 'amount': amount, 'unit_from': unit_from, 'unit_to': unit_to, 'key': 'id'
        }).done(function(data) {
            let resp = $.parseJSON(data);
            $('#result').text(resp.body);
        });
    });
});
