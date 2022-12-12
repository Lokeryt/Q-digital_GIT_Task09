function ajax(data, id) {
    $.ajax({
        type: 'GET',
        url: '/profile/' + id,
        data: data,
        success: (response) => {
            if (response.success && response.html) {
                let place = $('.comments');
                place.html(response.html);
                $('.show-all').hide();
                modal();
            }
        },
    });
}
$(document).ready(function(){
    $('.show-all').on('click', function () {
        let data = {
            all: true,
        };
        let id = $(this).attr('data-id');

        ajax(data, id);
    })
});
function modal() {
    $('.js-open-modal').on('click', function () {
        let id = $(this).attr('data-id');
        $(".modal-overlay[data-id='" + id + "']").removeClass('not-active');
    });
    $('.modal-cross').on('click', function () {
        let id = $(this).attr('data-id');
        $(".modal-overlay[data-id='" + id + "']").addClass('not-active');
    });
}
modal();
