(function($) {
    $('.mw-add').on('click', function(e) {
        e.preventDefault();
        var productQty = $(this).parent().find('.mw-quantity');
        productQty.val(parseInt(productQty.val()) + 1);
        updateTotalPrice();
        if (document.getElementById('add-more-option').checked) {
            fixVietCodePrice();
        }
        if (document.getElementById('add-more-option-2').checked) {
            fixVietCodePrice2();
        }
        if (document.getElementById('add-more-option-3').checked) {
            fixVietCodePrice3();
        }
        $("input[name^='mw-number-']").each(function(e) {
        var qty = parseInt(productQty.val())
        qtyy = qty;
    });
        useAddOption(qtyy);
    });
    $('.mw-sub').on('click', function(e) {
        e.preventDefault();
        var productQty = $(this).parent().find('.mw-quantity');
        productQty.val(parseInt(productQty.val()) - 1);
        if (parseInt(productQty.val()) < 0) {
            productQty.val(0);
        }
        updateTotalPrice();
        if (document.getElementById('add-more-option').checked) {
            fixVietCodePrice();
        }
        if (document.getElementById('add-more-option-2').checked) {
            fixVietCodePrice2();
        }
        if (document.getElementById('add-more-option-3').checked) {
            fixVietCodePrice3();
        }
        $("input[name^='mw-number-']").each(function(e) {
        var qty = parseInt(productQty.val())
        qtyy = qty;
    });
        useAddOption(qtyy);
    });
    $("input[name^='mw-number-']").on('change', function(e) {
        var windowPrice = $(this).data('price');
        var newAmount = $(this).val();
        if ($(this).val() < 0) {
            $(this).val(0);
        }
        updateTotalPrice();
        useAddOption(parseInt(newAmount));
    })

    $("input[name='add-more-option']").on('change', function(e) {
        var optionPrice = $('input[name="add_option_price"]').val();
        var initPrice = $('#mw-init-price-value');
        var initPriceValue = initPrice.val();
        var currentTotalPrice = $('#mw-totally-price');
        var totalPriceDisplay = $('#mw-total-price-display');
        var orderPrice = $('#mw-order-price');
        if ($(this).is(':checked')) {


            var totalPriceValue = parseInt(currentTotalPrice.val()) + parseInt(optionPrice);
        } else {
            var totalPriceValue = parseInt(currentTotalPrice.val()) - parseInt(optionPrice);
        }
        if (totalPriceValue > initPriceValue) {
            totalPriceDisplay.text(totalPriceValue);
            orderPrice.val(totalPriceValue);
        } else {
            totalPriceDisplay.text(initPriceValue);
            orderPrice.val(initPriceValue);
        }
        currentTotalPrice.val(totalPriceValue);
    });

    function fixVietCodePrice() {
        var optionPrice = $('input[name="add_option_price"]').val();
        var initPrice = $('#mw-init-price-value');
        var initPriceValue = initPrice.val();
        var currentTotalPrice = $('#mw-totally-price');
        var totalPriceDisplay = $('#mw-total-price-display');
        var orderPrice = $('#mw-order-price');

        var totalPriceValue = parseInt(currentTotalPrice.val()) + parseInt(optionPrice);
        if (totalPriceValue > initPriceValue) {
            totalPriceDisplay.text(totalPriceValue);
            orderPrice.val(totalPriceValue);
        } else {
            totalPriceDisplay.text(initPriceValue);
            orderPrice.val(initPriceValue);
        }
        currentTotalPrice.val(totalPriceValue);
    }

    $("input[name='add-more-option-2']").on('change', function(e) {
        var optionTwoTal = 0;
		            $("input[name^='mw-number-']").each(function(e) {
                var qty = parseInt($(this).val());
                var optionTwo = $('input[name="add_option_price_2"]').val();
                optionTwoTal += qty * optionTwo;
            });
        var initPrice = $('#mw-init-price-value');
        var initPriceValue = initPrice.val();
        var currentTotalPrice = $('#mw-totally-price');
        var totalPriceDisplay = $('#mw-total-price-display');
        var orderPrice = $('#mw-order-price');
		var optionPrice = $('input[name="add_option_price"]').val();
        if (document.getElementById('add-more-option-2').checked) {
            var totalPriceValue = parseInt(currentTotalPrice.val()) + parseInt(optionTwoTal);
        } else {
            var totalPriceValue = parseInt(currentTotalPrice.val()) - parseInt(optionTwoTal);
        }
        if (totalPriceValue > initPriceValue) {
            totalPriceDisplay.text(totalPriceValue);
            orderPrice.val(totalPriceValue);
        } else {
            totalPriceDisplay.text(initPriceValue);
            orderPrice.val(initPriceValue);
        }
        currentTotalPrice.val(totalPriceValue);
    });

    $("input[name='add-more-option-3']").on('change', function(e) {
        var optionTwoTal = 0;
        $("input[name^='mw-number-']").each(function(e) {
            var qty = parseInt($(this).val());
            var optionTwo = $('input[name="add_option_price_3"]').val();
            optionTwoTal += qty * optionTwo;
        });
        var initPrice = $('#mw-init-price-value');
        var initPriceValue = initPrice.val();
        var currentTotalPrice = $('#mw-totally-price');
        var totalPriceDisplay = $('#mw-total-price-display');
        var orderPrice = $('#mw-order-price');
        var optionPrice = $('input[name="add_option_price"]').val();
        if (document.getElementById('add-more-option-3').checked) {
            var totalPriceValue = parseInt(currentTotalPrice.val()) + parseInt(optionTwoTal);
        } else {
            var totalPriceValue = parseInt(currentTotalPrice.val()) - parseInt(optionTwoTal);
        }
        if (totalPriceValue > initPriceValue) {
            totalPriceDisplay.text(totalPriceValue);
            orderPrice.val(totalPriceValue);
        } else {
            totalPriceDisplay.text(initPriceValue);
            orderPrice.val(initPriceValue);
        }
        currentTotalPrice.val(totalPriceValue);
    });

    function fixVietCodePrice2() { // new options
        var optionTwoTal = 0;
        $("input[name^='mw-number-']").each(function(e) {
            var qty = parseInt($(this).val());
            var optionTwo = $('input[name="add_option_price_2"]').val();
            optionTwoTal += qty * optionTwo;
        });

        var optionPrice = $('input[name="add_option_price"]').val();
        var initPrice = $('#mw-init-price-value');
        var initPriceValue = initPrice.val();
        var currentTotalPrice = $('#mw-totally-price');
        var totalPriceDisplay = $('#mw-total-price-display');
        var orderPrice = $('#mw-order-price');

        var totalPriceValue = parseInt(currentTotalPrice.val()) + parseInt(optionTwoTal);
        if (totalPriceValue > initPriceValue) {
            totalPriceDisplay.text(totalPriceValue);
            orderPrice.val(totalPriceValue);
        } else {
            totalPriceDisplay.text(initPriceValue);
            orderPrice.val(initPriceValue);
        }
        currentTotalPrice.val(totalPriceValue);
    }

    function fixVietCodePrice3() {
        var optionTwoTal = 0;
        $("input[name^='mw-number-']").each(function(e) {
            var qty = parseInt($(this).val());
            var optionTwo = $('input[name="add_option_price_3"]').val();
            optionTwoTal += qty * optionTwo;
        });

        var optionPrice = $('input[name="add_option_price"]').val();
        var initPrice = $('#mw-init-price-value');
        var initPriceValue = initPrice.val();
        var currentTotalPrice = $('#mw-totally-price');
        var totalPriceDisplay = $('#mw-total-price-display');
        var orderPrice = $('#mw-order-price');

        var totalPriceValue = parseInt(currentTotalPrice.val()) + parseInt(optionTwoTal);
        if (totalPriceValue > initPriceValue) {
            totalPriceDisplay.text(totalPriceValue);
            orderPrice.val(totalPriceValue);
        } else {
            totalPriceDisplay.text(initPriceValue);
            orderPrice.val(initPriceValue);
        }
        currentTotalPrice.val(totalPriceValue);
    }

    function updateTotalPrice() {
        var totalPrice = 0;
        var currentTotalPrice = $('#mw-totally-price');
        $("input[name^='mw-number-']").each(function(e) {
            var qty = parseInt($(this).val());
            var price = $(this).data('price');
            totalPrice += qty * price;
        });
        var initPrice = $('#mw-init-price-value');
        var orderPrice = $('#mw-order-price');
        var totalPriceValue = totalPrice;
        var initPriceValue = initPrice.val();
        var totalPriceDisplay = $('#mw-total-price-display');
        currentTotalPrice.val(totalPriceValue);
        if (totalPriceValue > initPriceValue) {
            totalPriceDisplay.text(totalPriceValue);
            orderPrice.val(totalPriceValue);
        } else {
            if (totalPrice < 1) {
                totalPriceDisplay.text(0);
                orderPrice.val(0);
            } else {
                totalPriceDisplay.text(initPriceValue);
                orderPrice.val(initPriceValue);
            }
        }
    }

    function useAddOption(quantity) {
        var addOption = $('#add-more-option');
        var addOption2 = $('#add-more-option-2');
        var addOption3 = $('#add-more-option-3');


        addOption.removeAttr('disabled');
        addOption2.removeAttr('disabled');
        addOption3.removeAttr('disabled');
    }
})(jQuery);
