$(function() {

	$('.add2cart').submit(function() {
		let data = $(this).serialize();
		let loader = $(this).closest('.item-product').find('.loader');
		let btn = $(this).find('button');
		// console.log(data);

		$.ajax({
			//url: '',
			type: 'POST',
			data: data,
			beforeSend: function() {
				btn.attr('disabled', true);
				loader.fadeIn();
			},
			success: function(res) {
				loader.delay(500).fadeOut(300, function() {
					btn.attr('disabled', false);
					alert(res.MESSAGE);
				});
			},
			error: function(err) {
				console.log(err, 'error');
			}
		});

		return false;
	});

	$('.color-props li').click(function() {
		let id = $(this).data('id');
		let price = $(this).data('price');
		let value = $(this).data('value');
		// console.log(`${id}|${price}|${value}`);
		$('.color-props li').removeClass('active-prop');
		$(this).addClass('active-prop');
		$(this).closest('.price').find('.price-value').text(`${price} (${value})`);
		$(this).parent().next().find('.id-offer').val(id);
	});
});