$(function() {

    // initialise Datatable
    //$('#surveys-taken-table').DataTable({
    //    "order": [0, 'desc'],
    //    "columnDefs": [ {
    //        "targets": 5,
    //        "orderable": false
    //    } ]
    //});

    $('.dataTables').DataTable({});

    $('.country').on('change', function () {
        $.get('/get-cities/'+$(this).val(), function (data) {
            if(data.length) {
                var html = '';
                $.each(data, function (key, value) {
                    html += '<option value="'+value.id+'">'+value.name;+'</option>';
                });
                $('.city').html(html);
            }
        });
    });

});
