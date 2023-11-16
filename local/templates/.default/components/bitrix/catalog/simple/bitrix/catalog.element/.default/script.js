$(function(){
	$('.add2cart').submit(function(){
		let $this = $(this),
		data = $this.serialize(),
		loader = $('.loader'),
		btn = $this.find('button');
		console.log(data);
	$.ajax({
		url: '/catalog/' + path,
		type: 'POST',
		data: data,
		beforeSend: function(){
			btn.attr('disabled', true);
			loader.fadeIn();
		},
		success: function(res){
			loader.delay(500).fadeOut(300, function(){
					btn.attr('disabled', false);
					alert(res.MESSAGE);
			});
		},
		error: function(){
			alert('Ошибка!');
		}
	});
	return false;
});

	$('.color-props li').click(function(){
		let id = $(this).data('id'),
		value = $(this).data('value'),
		price = $(this).data('price');

		$('.color-props li').removeClass('active-prop');
		$(this).addClass('active-prop');

		$(this).closest('.price').find('.price-value').text(price + ' (' + value + ')');

		$(this).parent().next().find('.id-offer').val(id);
	});


});