if ($.fn.tooltip && $('[data-toggle="tooltip"]').length) {
    $('[data-toggle="tooltip"]').tooltip().on("mouseleave", function () {
        $(this).tooltip('hide');
    });
}

$(".select-on-check-all").on('change', function () {
    $('input[type=checkbox][name*=select]').prop('checked', $(this).prop('checked'));
    buttonAction();
});

$("input[type=checkbox][name*=select]").on('change', function () {
    buttonAction();
});

function buttonAction() {
    let disabled = $('input[type=checkbox][name*=select]:checked').length <= 0;

    $('.button-action').prop('disabled', disabled);

    if (disabled) {
        $('.button-action').addClass('disabled');
    } else {
        $('.button-action').removeClass('disabled');
    }
}

$('body').on('click', '.favorites-action-link', function () {
    let $link = $(this);

    $link.css('opacity', 0.5);

    if ($link.data('method') === 'DELETE') {
        axios.delete($link.attr('href')).then((response) => {
            $link.css('opacity', 1);
            $link.removeClass('btn-warning').addClass('btn-outline-secondary');
        }).catch((error) => {
            console.log(error);
        });
    } else {
        axios.post($link.attr('href')).then((response) => {
            $link.css('opacity', 1);
            $link.removeClass('btn-outline-secondary').addClass('btn-warning');
        }).catch((error) => {
            console.log(error);
        });
    }

    return false;
});

$(document).on('click', '[data-submit-form]:not(:disabled)', function () {
    let $form = $('form' + $(this).data('submit-form'));

    if ($(this).data('form-action')) {
        $form.prop('action', $(this).data('form-action'))
    }

    if ($(this).data('form-method')) {
        let $methodInput = $('<input>')
            .attr('name', '_method')
            .attr('value', $(this).data('form-method'))
            .attr('type', 'hidden');

        $form.append($methodInput);
    }

    $form.submit();
});

$(document).on('click', 'a[data-method]', function () {
    let $object = $(this);

    let $tokenInput = $('<input>')
        .attr('name', '_token')
        .attr('value', $('meta[name=csrf-token]').attr('content'))
        .attr('type', 'hidden');

    let $methodInput = $('<input>')
        .attr('name', '_method')
        .attr('value', $object.data('method'))
        .attr('type', 'hidden');

    let $form = $('<form>')
        .attr('method', 'POST')
        .attr('action', $object.attr('href'))
        .append($tokenInput)
        .append($methodInput);

    $form.appendTo('body').submit();

    return false;
});