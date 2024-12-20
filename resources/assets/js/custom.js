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
            location.reload();
        } else {
            console.error('Ajax request error! ' . json.error);
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
        Fancybox.show([
            {
                src: '#size-error',
                type: 'inline'
            }
        ]);
        e.preventDefault();
    }
    Cart.add(id, 1, size, function(json) {
        if (json.success) {
            $('.header__column--basket').replaceWith(json.header_cart);
        }
    });
}

function purgeCart(elem, e) {
    e.preventDefault();
    const form = $(elem).closest('form');
    const url = '/ajax/purge-cart'
    const cartContainer = $('.cart__container')

    resetForm(form);

    sendAjax(url, {}, function(json) {
        if (json.success) {
            $('.header__column--basket').replaceWith(json.header_cart);
            cartContainer.empty();
            cartContainer.append('<div class="cart__title centered">Корзина</div><div><div>Ни одного товара не добавлено...</div></div>')
        }
    })
}

//меняем скидку в корзине при изменении способа оплаты
function paymentChange(elem) {
    const value = $(elem).val();
    const urlApplyDiscount = '/ajax/apply-discount-payment';
    const urlDiscardDiscount = '/ajax/discard-discount-payment';

    const containerItems = $('.cart-items');
    const footer = $('.tbl-order__row--footer');

    //1 - безналичный расчет
    if(value == 1) {
        sendAjax(urlApplyDiscount, {}, function(json) {
            if (json.success) {
                containerItems.html(json.items);
                footer.html(json.footer_total);
                initCounter();
            }
        })
    } else {
        sendAjax(urlDiscardDiscount, {}, function(json) {
            if (json.success) {
                containerItems.html(json.items);
                footer.html(json.footer_total);
                initCounter();
            }
        })
    }
}

//меняем скидку в корзине при изменении способа доставки
function deliveryChange(elem) {
    const value = $(elem).val();
    const urlApplyDiscount = '/ajax/apply-discount-delivery';
    const urlDiscardDiscount = '/ajax/discard-discount-delivery';

    const containerItems = $('.cart-items');
    const footer = $('.tbl-order__row--footer');

    //1 - забрать в пункте выдачи
    if(value == 1) {
        sendAjax(urlApplyDiscount, {}, function(json) {
            if (json.success) {
                containerItems.html(json.items);
                footer.html(json.footer_total);
                initCounter();
            }
        })
    } else {
        sendAjax(urlDiscardDiscount, {}, function(json) {
            if (json.success) {
                containerItems.html(json.items);
                footer.html(json.footer_total);
                initCounter();
            }
        })
    }
}