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
        var countrySelect = $(this);
        $.get('/get-cities/'+$(this).val(), function (data) {
            if(data.length) {
                var html = '';
                $.each(data, function (key, value) {
                    html += '<option value="'+value.id+'">'+value.name+'</option>';
                });
                var city = countrySelect.parents('form:first').find('select.city:first');
                city.html(html);

                var cityId = city.data('city-id');
                if(typeof cityId !== 'undefined') {
                    city.val(cityId);
                }

            }
        });
    });


    $('.questions-answers .show-answer-modal').on('click', function(e) {
        e.preventDefault();
        $('.answer-modal-form')[0].reset();
        $('.answer-modal-form').attr('action', $(this).attr('href'));

        if($(this).hasClass('update')) {
            $('.answer-modal-heading').html('Update Answer');
            $('.answer-modal-submit').html('Update');

            $('.answer-modal-form .text').val($(this).parents('.answer-tr:first').find('.text').html());
            $('.answer-modal-form .trait').val($(this).parents('.answer-tr:first').find('.trait').data('trait-id'));
            $('.answer-modal-form .sort_order').val($(this).parents('.answer-tr:first').find('.sort_order').html());

        } else {
            $('.answer-modal-heading').html('Create New Answer');
            $('.answer-modal-submit').html('Create');
        }

        $('#answer-form-modal').modal('show');
    });

    $('.companies-departments .show-department-modal').on('click', function(e) {
        e.preventDefault();
        $('.department-modal-form')[0].reset();
        $('.department-modal-form').attr('action', $(this).attr('href'));

        if($(this).hasClass('update')) {

            $('.department-modal-heading').html('Update Department');
            $('.department-modal-submit').html('Update');

            $('.department-modal-form .name').val($(this).parents('.department-tr:first').find('.name').html());
            $('.department-modal-form .description').val($(this).parents('.department-tr:first').find('.description').html());
            $('.department-modal-form .country').val($(this).parents('.department-tr:first').find('.country').data('country-id'));

            $('.department-modal-form .city').attr('data-city-id', $(this).parents('tr:first').find('.city').data('city-id'));
            $('.department-modal-form .country').trigger('change');

        } else {
            $('.department-modal-heading').html('Create New Department');
            $('.department-modal-submit').html('Create');
        }

        $('#department-form-modal').modal('show');
    });

    $('.categories-traits .show-trait-modal').on('click', function(e) {
        e.preventDefault();
        $('.trait-modal-form')[0].reset();
        $('.trait-modal-form').attr('action', $(this).attr('href'));

        if($(this).hasClass('update')) {
            $('.trait-modal-heading').html('Update Trait');
            $('.trait-modal-submit').html('Update');

            $('.trait-modal-form .name').val($(this).parents('.trait-tr:first').find('.name').html());
            $('.trait-modal-form .description').val($(this).parents('.trait-tr:first').find('.description').html());

        } else {
            $('.trait-modal-heading').html('Create New Trait');
            $('.trait-modal-submit').html('Create');
        }

        $('#trait-form-modal').modal('show');
    });


});
