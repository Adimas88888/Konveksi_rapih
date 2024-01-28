$(document).ready(function () {
    $(".plus").click(function (e) {
        e.preventDefault();
        var card = $(this).closest(".card-body");
        var harga = card.find("#harga").val();
        var qty = card.find("#qty").val();
        var url = card.find("#harga").attr('data-url');
        var csrf = card.find("#harga").attr('data-csrf');

        var tambah = parseInt(qty) + 1;
        card.find("#qty").val(tambah);

        var subtotal = parseInt(harga) * parseInt(tambah);
        card.find(".total").val(subtotal);

        updateQuantityAjax(url, tambah, csrf);

        if (qty > 0) {
            card.find(".minus").prop("disabled", false);
        }
    });

    $(".minus").click(function (e) {
        e.preventDefault();
        var card = $(this).closest(".card-body");
        var harga = card.find("#harga").val();
        var qty = card.find("#qty").val();
        var url = card.find("#harga").attr('data-url');
        var csrf = card.find("#harga").attr('data-csrf');

        var tambah = parseInt(qty) - 1;
        card.find("#qty").val(tambah);

        var subtotal = parseInt(harga) * parseInt(tambah);
        card.find(".total").val(subtotal);

        updateQuantityAjax(url, tambah, csrf);

        if (qty <= 1) {
            card.find(".minus").prop("disabled", true);
        }
    });

    $(".card-body").each(function () {
        var card = $(this);
        var harga = card.find("#harga").val();
        var qty = card.find("#qty").val();
        var total = parseInt(harga) * parseInt(qty);
        card.find("#total").val(total);
    });

    function updateQuantityAjax (url, quantity, csrf) {
        $.ajax({
            url: url,
            data: {
                qty: quantity,
                _token: csrf
            },
            success: function (res) {
                console.log('berhasil');
            },
            error: function (err) {
                console.log('gagal');
            }
        });
    }
});

