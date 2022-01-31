$(function () {
    var base = $('link[rel="base"]').attr('href') + "/_cdn/widgets/imobi";

    $('.wc_mobile_filter').click(function () {
        $('.wc_imobi_filter .content').slideToggle();
    });

    $('.wc_imobi_filter_form select').change(function () {
        var WcDataAction = $(this).attr('name');
        var WcDataFilter = $('.wc_imobi_filter_form').serialize() + "&workcontrol=" + WcDataAction;

        $(this).nextAll('select').html('<option value="">Selecione o campos anterior...</option>');
        $.post(base + '/filter.ajax.php', WcDataFilter, function (data) {
            if (data.type) {
                $('select[name="type"]').html('<option value="">Selecione o tipo:</option>' + data.type);
            }
            if (data.finality) {
                $('select[name="finality"]').html('<option value="">Selecione a finalidade:</option>' + data.finality);
            }
            if (data.district) {
                $('select[name="district"]').html('<option value="">Selecione o bairro:</option>' + data.district);
            }
            if (data.bedrooms) {
                $('select[name="bedrooms"]').html('<option value="">Selecione quantidade de quartos:</option>' + data.bedrooms);
            }
            if (data.min_price) {
                $('select[name="min_price"]').html('<option value="">Selecione um valor mínimo:</option>' + data.min_price);
            }
            if (data.max_price) {
                $('select[name="max_price"]').html('<option value="">Selecione um valor máximo:</option>' + data.max_price);
            }
        }, 'json');
    });
});