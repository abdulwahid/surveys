$(function() {

    // initialise Datatable
    $('#surveys-taken-table').DataTable({
        "order": [0, 'desc'],
        "columnDefs": [ {
            "targets": 5,
            "orderable": false
        } ]
    });

});
