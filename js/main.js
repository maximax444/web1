// change R-value input in form
$('.main__btns button').on("click", function (e) {
    e.preventDefault();
    let btnValue = $(this).attr('data-value');
    $('.main__btns button').removeClass("active");
    $(this).addClass("active");
    $('.main__btns input').val(btnValue);
});

function validateForm() {
    let errors = 0;

    // validateX
    if ($('.main__input-select').val() != 7) {
        $('.main__input-select').removeClass("error");
    } else {
        $('.main__input-select').addClass("error");
        errors = 1;
    }

    // validateY
    const Y_MIN = -3;
    const Y_MAX = 5;
    let yVal = $('.main__input-text').val();
    if (isNum(yVal)) {
        if (yVal >= Y_MIN && yVal <= Y_MAX) {
            $('.main__input-text').removeClass('error');
        } else {
            $('.main__input-text').addClass('error');
            errors = 1;
        }
    } else {
        $('.main__input-text').addClass('error');
        errors = 1;
    }

    // validateR
    if ($('.main__input-hidden').val() != 0) {
        $('.main__btns button').removeClass('error');
    } else {
        $('.main__btns button').addClass('error');
        errors = 1;
    }

    // return result
    if (errors == 0) {
        return true;
    } else {
        return false;
    }

}

function isNum(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

$('form').on('submit', function (e) {
    e.preventDefault();
    if (!validateForm()) return;
    $.ajax({
        url: 'main.php',
        method: 'POST',
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function () {
            $('.main__form-submit').attr('disabled', 'disabled');
        },
        success: function (data) {
            $('.main__form-submit').attr('disabled', false);
            if (data.validate) {
                newRow = '<tr>';
                newRow += '<td>' + data.xval + '</td>';
                newRow += '<td>' + data.yval + '</td>';
                newRow += '<td>' + data.rval + '</td>';
                newRow += '<td>' + data.hitres + '</td>';
                newRow += '<td>' + data.curtime + '</td>';
                newRow += '<td>' + data.exectime + '</td>';

                $('.main__table').append(newRow);
                $("form").trigger("reset");
            }
        }
    });
});