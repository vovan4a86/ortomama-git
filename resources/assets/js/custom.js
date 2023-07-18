function sendAjax(url, data, callback, type){
    data = data || {};
    if (typeof type == 'undefined') type = 'json';
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        // processData: false,
        // contentType: false,
        dataType: type,
        beforeSend: function(request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success: function(json){
            if (typeof callback == 'function') {
                callback(json);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            alert('Не удалось выполнить запрос! Ошибка на сервере.');
        },
    });
}

let Cart = {
    add: function (id, count, size, callback) {
        sendAjax('/ajax/add-to-cart',
            {id, count, size}, (result) => {
                if (typeof callback == 'function') {
                    callback(result);
                }
            });
    },

    update: function (id, count, callback) {
        sendAjax('/ajax/update-to-cart',
            {id, count}, (result) => {
                if (typeof callback == 'function') {
                    callback(result);
                }
            });
    },

    edit:  function (id, count, callback) {
        sendAjax('/ajax/edit-cart-product',
            {id, count}, (result) => {
                if (typeof callback == 'function') {
                    callback(result);
                }
            });
    },

    remove: function (id, callback) {
        sendAjax('/ajax/remove-from-cart',
            {id: id}, (result) => {
                if (typeof callback == 'function') {
                    callback(result);
                }
            });
    },

    purge: function (callback) {
        sendAjax('/ajax/purge-cart',
            {}, (result) => {
                if (typeof callback == 'function') {
                    callback(result);
                }
            });
    },

}

function resetForm(form) {
    $(form).trigger('reset');
    $(form).find('.err-msg-block').remove();
    $(form).find('.has-error').remove();
    $(form).find('.invalid').attr('title', '').removeClass('invalid');
}

function selectPerPage(count) {
    const url = '/ajax/per-page-select';
    console.log(count);

    sendAjax(url, {count}, function (json) {
        if(json.success) {
            // console.log('change');
            location.reload();
        } else {
            alert('Ajax Error! ' . json.error);
        }
    });
}

function sendRequest(frm, e) {
    e.preventDefault();
    var form = $(frm);
    var data = form.serialize();
    var url = form.attr('action');
    sendAjax(url, data, function (json) {
        if (typeof json.errors !== 'undefined') {
            let focused = false;
            for (var key in json.errors) {
                if (!focused) {
                    form.find('#' + key).focus();
                    focused = true;
                }
                form.find('#' + key).after('<span class="has-error">' + json.errors[key] + '</span>');
            }
            form.find('.sending__title').after('<div class="err-msg-block has-error">Заполните, пожалуйста, обязательные поля.</div>');
        } else {
            showThankDialog('#form');
        }
    });
}

function addItemToCart(elem, e) {
    //e.preventDefault();
    const id = $(elem).attr('data-product');
    const size = $('.radios__input:checked').val();
    if (!size) {
        alert('Не выбран размер');
        e.preventDefault();
    }
    Cart.add(id, 1, size, function(res) {
        if (res.success) {
            $('.header__column--basket').replaceWith(res.header_cart);
            // var lazyLoadInstance = new LazyLoad();
            // lazyLoadInstance.update();
        }
    });
}
