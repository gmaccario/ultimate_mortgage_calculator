jQuery.noConflict();
jQuery( document ).ready(function( jQuery ) 
{
	function isNumber(n)
	{
		return !isNaN(parseFloat(n)) && isFinite(n);
	}
	
	jQuery( "form.mortgage .submit-btn" ).click(function(e){
		
		e.preventDefault();
		
		let invalidInputs 	= new Array();		
		let _form 			= jQuery(this).parents('form');
		let country_code 	= _form.find('input[type="hidden"][name="country_code"]').val();
		
		let data = {
			action: 'get_mortgage_calculator_results',
			present_value: 		_form.find('#mortgage-value').val(),
			numbers_of_period: 	_form.find('#term-years').val(),
			rate_per_period: 	_form.find('#rate').val().replace( ",", ".")
		};
		
		/* VALIDATION */
		if ( data['present_value'] <= 0 || !isNumber( data['present_value'] ))
		{
			invalidInputs.push(_form.find('#mortgage-value'));
		}
		if( data['numbers_of_period'] <= 0 || !isNumber( data['numbers_of_period'] ))
		{
			invalidInputs.push(_form.find('#term-years'));
		}
		if( data['rate_per_period'] <= 0 || !isNumber( data['rate_per_period'] ))
		{
			invalidInputs.push(_form.find('#rate'));
		}
			
		if ( invalidInputs.length > 0 )
		{
			for(var i=0; i<invalidInputs.length; i++)
			{
				invalidInputs[i].css('border-color', '#ff0000')
			}
			
			jQuery('.user_messages').removeClass('hidden');
			
			setInterval(function(){ 
				jQuery('.user_messages').addClass('hidden'); 
				for(var i=0; i<invalidInputs.length; i++)
				{
					invalidInputs[i].css('border-color', '#c1c1c1')
				}
			}, 5000);
			
			return false;
		}
		
		jQuery('.submit-btn').addClass('hidden');
		jQuery('.loader').removeClass('hidden');
		
		jQuery.post( ajaxurl, data, function(response) {
			
			jQuery('.submit-btn').removeClass('hidden');
			jQuery('.loader').addClass('hidden');
			
			jQuery("html, body").animate({
				scrollTop: jQuery('.scrollTop').offset().top }, 
				2000);
			
			if ( true === response['results']['success'] )
			{
				/* show results */
				jQuery('.show_results').removeClass('hidden');
				
				let monthly_payment = response['results']['monthly_payment'];
				let total_amount 	= response['results']['total_amount'];
				let present_value 	= response['results']['present_value'];
				let interest_value 	= response['results']['interest_value'];
				
				const optionsToLocaleString = { minimumFractionDigits: 2 };
				
				let monthly_paymentToLocaleString 	= Number( monthly_payment ).toLocaleString( country_code, optionsToLocaleString );
				let total_amountToLocaleString 		= Number( total_amount ).toLocaleString( country_code, optionsToLocaleString );
				let present_valueToLocaleString 	= Number( present_value ).toLocaleString( country_code, optionsToLocaleString );
				let interest_valueToLocaleString 	= Number( interest_value ).toLocaleString( country_code, optionsToLocaleString );
								
				jQuery('.show_results .result_monthly_payment .value').text( monthly_paymentToLocaleString );
				jQuery('.show_results .result_total_amount .value').text( total_amountToLocaleString );
				
				jQuery('.show_results .made_up .capital_value').text( present_valueToLocaleString );
				jQuery('.show_results .made_up .interest_value').text( interest_valueToLocaleString );
				
				/*  TODO ... DELETE AND RECREATE CANVAS */
				
				let ctx = document.getElementById('chart').getContext('2d');
				let myChart = new Chart(ctx, {
				  type: 'line',
				  options: {
					 legend: {
						display: false
					 },
					 scales: {
						xAxes: [{
							ticks: {
								callback: function(value, index, values) {
									if( Number.isInteger( value ))
									{
										return Math.trunc( value );
									}
								}
							}
						}]
					}
				  },
				  data: {
					labels: response['results']['charts']['x'] ,
					datasets: [
						{
							data: response['results']['charts']['y'],
							backgroundColor: jQuery( 'input[type="hidden"][name="rgba_color"]' ).val(),
							fill: false /* this option hide background-color */
						}, 
					]
				  }
				});
			}
		});
	});
});