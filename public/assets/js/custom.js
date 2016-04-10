$(function() {

    $('.answers-container').sortable({
        stop: function( event, ui ) {
            var container = ui.item.closest('.answers-container');
            var answers = container.find('.answers');
        }
    });
    $('.answers-container').disableSelection();

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
        if (next) {
            var parent = $(this).closest('.panel');
            if (parent.find('.answers-container').length) {
                parent.find('.answers-container').sortable('disable');
            }
            var next = parent.next('.panel');

            parent.hide('slide', {direction: 'left'}, function () {
                next.show("slide", {direction: "right"});
            });
        }

    });

    $('.survey-container .finish').on('click', function () {
        couponId = $('.survey-container').data('coupon-id');
        userName = $('.user-info .user-name').val();
        userEmail = $('.user-info .user-email').val();
        role = $('.user-info .role').val();

        responses = {};
        var i = 0;
        $('.survey-container').find('.question-container').each(function () {

            questionId = $(this).data('question-id');
            categoryId = $(this).data('category-id');

            var answersCount = $(this).find('.answer').length;
            $(this).find('.answer').each(function () {

                var answer = {};
                answer['question_id'] = questionId;
                answer['category_id'] = categoryId;
                answer['answer_id'] = $(this).data('answer-id');
                answer['trait_id'] = $(this).data('trait-id');
                answer['answer_position'] = answersCount;
                responses[i] = answer;
                answersCount--;
                i++;
            });

        });

        $.ajax({
            url: '/save-survey-response',
            type: 'post',
            data: {
                coupon_id: couponId,
                user_name: userName,
                user_email: userEmail,
                role: role,
                responses: responses
            }
        });

        setTimeout(function(){
            window.location.href = '/thank-you';
        }, 250);

    });

});
