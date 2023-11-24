$(function() {

	let sum = 0;

	$('input[type=radio][name=goods]').change(function() {
		console.log(`price: ${$(this).data('price')}; id: ${this.value}`);
	})
});