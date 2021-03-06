$(function() {

    // Check device to show Youtube video in Survey process
    if('ontouchstart' in window || 'onmsgesturechange' in window) {
        $('#pc-utube-vdo').hide();
        $('#tablet-utube-vdo').show();
    } else {
        $('#tablet-utube-vdo').hide();
        $('#pc-utube-vdo').show();
    }

    // This variable is used to hold change status of options in survey questions
    changed = false;

    // Make answers sortable
    $('.answers-container').sortable({
        change: function( event, ui ) {
            changed = true;
        },
        stop: function( event, ui ) {
            var container = ui.item.closest('.answers-container');
            var answers = container.find('.answers');
        }
    });
    $('.answers-container').disableSelection();

    // Handle Click Next Button in survey process
    $('.survey-container .next').on('click', function () {

        var next = true;
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if($(this).closest('.user-info').length) {
            if (!$('.user-info .user-name').val().length) {
                $('.user-info .error-message').html('Name is required').show();
                next = false;
            } else if($('.user-info .user-name').val().length < 3) {
                $('.user-info .error-message').html('Name should have minimum 3 characters').show();
                next = false;
            } else if(!$('.user-info .user-email').val().length) {
                $('.user-info .error-message').html('Email is required').show();
                next = false;
            } else if(!regex.test($('.user-info .user-email').val())) {
                $('.user-info .error-message').html('Email is invalid').show();
                next = false;
            } else if(!$('.user-info .role').val().length) {
                $('.user-info .error-message').html('Email is required').show();
                next = false;
            } else {
                $('.user-info .error-message').html('').hide();
            }
        }

        if($(this).parents('.panel:first').hasClass('question-container') && !changed) {
            $('#confirm-next').modal('show');
            changed = true;
            next = false;
        }


        if (next) {
            var parent = $(this).closest('.panel');
            if (parent.find('.answers-container').length) {
                parent.find('.answers-container').sortable('disable');
            }
            var next = parent.next('.panel');

            parent.hide('slide', {direction: 'left'}, function () {
                next.show("slide", {direction: "right"});
                changed = false;
            });
        }

    });

    // Handle Finish button in Survey Process
    $('.survey-container .finish').on('click', function () {

        if($(this).parents('.panel:first').hasClass('question-container') && !changed) {
            $('#confirm-next').modal('show');
            changed = true;
            return;
        }

        var couponId = $('.survey-container').data('coupon-id');
        var userName = $('.user-info .user-name').val();
        var userEmail = $('.user-info .user-email').val();
        var role = $('.user-info .role').val();
        var responses = {};
        var i = 0;

        $('.survey-container').find('.question-container').each(function () {

            var parent = $(this);
            var questionId = parent.data('question-id');
            var categoryId = parent.data('category-id');
            var traitsCount = parent.find('.traits-count:first').val();
            var answersCount = parent.find('.answer').length;
            var answersPosition = answersCount;

            $(this).find('.answer').each(function () {

                var answer = {};
                var traitId = $(this).data('trait-id');
                answer['question_id'] = questionId;
                answer['category_id'] = categoryId;
                answer['answer_id'] = $(this).data('answer-id');
                answer['trait_id'] = traitId;
                answer['answer_position'] = answersPosition;
                answer['traits_count'] = traitsCount;
                answer['trait_occurrence'] = parent.find('.trait-' + traitId + '-occurrence:first').val();
                answer['answers_count'] = answersCount;
                answer['questions_count'] = $('#traits-' + traitId + '-questions').val();
                responses[i] = answer;
                answersPosition--;
                i++;
            });

        });

        $.ajax({
            url: '/save-survey-response',
            type: 'post',
            data: {
                _token: $('input[name="_token"]').val(),
                coupon_id: couponId,
                user_name: userName,
                user_email: userEmail,
                role: role,
                responses: responses
            }
        });

        setTimeout(function() {
            window.location.href = '/thank-you';
        }, 1000);

    });

});
