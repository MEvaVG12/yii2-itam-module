/**
 * Created by joao on 01/05/17.
 */

function updateGrid() {
    $('#softwareTable').load('/itam/dashboard/ajax-get-software-table?idAsset=' + $('#idAsset').val());
}

function scanAssetPorts() {
    $('#monitoring-socket_port').attr('disabled', 'disabled');
    $('#btnScanPorts').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-spin fa-spinner"></i> Scanning...');
    $.ajax({
        type: 'post',
        url: '/itam/dashboard/ajax-scan-asset-ports',
        data: {'id_asset': $('#monitoring-id_asset').val()},
        success: function (data) {
            $('#btnScanPorts').removeClass('disabled').removeAttr('disabled').html('Scan ports');
            $('#monitoring-socket_port').removeAttr('disabled').html(data);
            var options = [];
            $('#monitoring-socket_port > option').each(function() {
                if ($(this).val() !== '') options.push($(this).text());
            });
            $('#monitoring-socket_open_ports').val(options.join(','));
        }
    });
}

function activateMonitoringSettings() {
    var check_type = $('#monitoring-check_type').val();
    if (check_type === 'ping') {
        $('#pingSettings').show();
        $('#socketSettings').hide();
    } else if (check_type === 'socket') {
        $('#pingSettings').hide();
        $('#socketSettings').show();
        if ($('#monitoring-socket_open_ports').val() === '') scanAssetPorts();
    }
}

$('document').ready(function () {
    $('#ddOs').change(function() {
        $.get('/itam/dashboard/ajax-get-os-licenses-dropdown-options?id_os=' + $(this).val(), function(result) {
            $('#ddOsLicense').html(result);
        });
    });
    $('#ddOfficeSuite').change(function() {
        $.get('/itam/dashboard/ajax-get-office-suite-licenses-dropdown-options?id_office_suite=' + $(this).val(), function(result) {
            $('#ddOfficeSuiteLicense').html(result);
        });
    });
    $('#softwareasset-id_software').change(function() {
        $.get('/itam/dashboard/ajax-get-software-licenses-dropdown-options?id_software=' + $(this).val(), function(result) {
            $('#softwareasset-id_software_license').html(result);
        });
    });
    $('#btnAddSoftware').click(function() {
        $('#modalAddSoftware').modal('show');
    });
    $('#btnModalAddSoftwareSave').click(function () {
        $.ajax({
            type: 'post',
            url: '/itam/dashboard/ajax-add-software-asset',
            data: $('#formAddSoftware').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.result === true) {
                    $('#modalAddSoftware').modal('hide');
                    updateGrid();
                }
            }
        });
    });
    $('body').on('click', '.btn-del-software', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var url = $(this).attr('href');
        console.log(url);
        $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
            success: function () {
                updateGrid();
            }
        });
        return false;
    });
    $('#idLicense').change(function() {
        window.location.href = window.location.pathname + '?idLicense=' + $(this).val();
    });
    $('#idUser').change(function() {
        window.location.href = '/itam/user/permissions?idUser=' + $(this).val();
    });
    $('#monitoring-check_type').change(function() {
        activateMonitoringSettings();
    });
    $('#btnScanPorts').click(function() {
        scanAssetPorts();
    });
});
