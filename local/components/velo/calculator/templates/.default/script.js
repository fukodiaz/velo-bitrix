$(function() {
	let sum = 0;
	let priceGoods = 0;
	let priceTires = 0;
	let priceCover = 0;
	let nameGoods = '';
	let pdu = '';
	let img = '';

	$('input[type=radio][name=goods]').change(function() {
		priceGoods = $(this).data('price'); 
		nameGoods = $(this).data('name');
		pdu = $(this).data('pdu');
		img = $(this).data('img');
		// console.log(`priceVelo: ${priceGoods}; id: ${this.value}`);
		// console.log(`Final sum: ${+priceGoods + +priceTires + +priceCover};`);
		// console.log(`PDU: ${pdu}`);
		// console.log(`name: ${nameGoods}`);
	});
	$('input[type=radio][name=service_tires]').change(function() {
		priceTires = $(this).data('price'); 
		// console.log(`priceTires: ${priceTires}; id: ${this.value}`);
		// console.log(`Final sum: ${+priceGoods + +priceTires + +priceCover};`);
	});
	$('input[type=radio][name=covering]').change(function() {
		priceCover = $(this).data('price');
		// console.log(`priceCovering: ${priceCover}; id: ${this.value}`);
		// console.log(`Final sum: ${+priceGoods + +priceTires + +priceCover};`);
	});

	function addModifiedItem(name, price, pdu, img) {
		$.ajax({
			type: 'POST',
			url: '/local/ajax/addNewItemToBasket.php',
			data: `name=${name}&price=${price}&pdu=${pdu}&img=${img}`,
			beforeSend: function() {
				$('.addModifiedItem').attr('disabled', true);
			},
			success: function(res) {
				$('.addModifiedItem').attr('disabled', false);
				alert('Товар добавлен в корзину!');
			},
			error: function(err) {
				console.log(err, 'error');
			}
		});
	}

	$('.addModifiedItem').click(function() {
		sum = priceGoods + priceTires + priceCover;
		if (sum != 0 && priceGoods != 0 && nameGoods != '') {
			addModifiedItem(nameGoods, sum, pdu, img);
		} else {
			console.log('Something is wrong');
			alert('Выберите подходящую позицию!');
		}
	});
});