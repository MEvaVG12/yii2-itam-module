/**
 * Created by joao on 01/05/17.
 */

function updateGrid() {
    $('#softwareTable').load('/itam/dashboard/ajax-get-software-table?idAsset=' + $('#idAsset').val());
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
});
