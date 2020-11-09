jQuery(document).ready(function ($) {
    $('.commentlist li').each(function (i) {
        $(this).find('div.commentNumber').text('#' + (i + 1))
    });

    $('#commentform').on('click', '#submit', function (e) {
        e.preventDefault();

        let comParent = $(this);

        $('.wrap_result').css('color', 'green')
            .text('Сохранение комментария')
            .fadeIn(500, function () {
                let data = $('#commentform').serializeArray();

                $.ajax({
                    url:  $('#commentform').attr('action'),
                    data: data,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function () {

                    },
                    error: function () {

                    }
                })
            });


    });
})