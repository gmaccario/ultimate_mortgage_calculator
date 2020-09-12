<div class="container-fluid ultimate_mortgage_calculator_wrapper">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row">
				<div class="module-title" id="calcHeader">
					<h3><?php echo __( 'What will my monthly mortgage payments be?', 'mortgage_calculator' ); ?></h3>
				</div>
			</div>
			<form id="mortgage_calculator" class="mortgage" action="#" method="get">
				<input type="hidden" name="country_code" value="<?php echo $country; ?>" />
				<input type="hidden" name="rgba_color" value="<?php echo $rgba_color; ?>" />
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="mortgage-value"><?php echo __('How much do you want to borrow?', 'mortgage_calculator' ); ?></label>
							<div class="input-group input-group-lg">
								<span id="mortgage-addon" class="input-group-addon">
									<i class="fa-currency" aria-hidden="true"><?php echo $currency_entity; ?></i>
								</span> 
								<input name="mortgage" id="mortgage-value" type="number" min="15000" required="" placeholder="" aria-describedby="mortgage-addon" class="form-control tracking" step="1000" value="<?php echo ( !empty( $mortgage_start_value )) ? $mortgage_start_value : 280000; ?>" />
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="term-years"><?php echo __('Over how many years?', 'mortgage_calculator' ); ?></label> 
							<input name="term-years" id="term-years" type="number" min="1" max="40" required="" placeholder="Years" class="form-control input-lg tracking" value="25" />
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
							<label for="rate"><?php echo __('Interest rate', 'mortgage_calculator' ); ?></label>
							<div class="input-group input-group-lg">
								<span id="rate-addon" class="input-group-addon">
									<i class="fa fa-percent" aria-hidden="true"></i>
								</span> 
								<input name="rate" id="rate" type="number" min="0.1" max="20" required="" placeholder="" aria-describedby="rate-addon" step="0.05" class="form-control tracking" value="2.5" />
							</div>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
							<label>&nbsp;</label> 
							
							<a class="submit-btn btn btn-lg btn-chubby btn-success btn-block">
								<?php echo __('Calculate', 'mortgage_calculator' ); ?>
							</a>
							
							<div class="loader text-center hidden">
								<img alt="<?php echo __('Loading...', 'mortgage_calculator' ); ?>" 
									title="<?php echo __('Loading...', 'mortgage_calculator' ); ?>"
									src="<?php echo ULTIMATE_MORTGAGE_CALCULATOR_URL; ?>/assets/images/loader.gif" />
							</div>
							
							<div class="user_messages hidden">
								<span class="label label-danger"><?php echo __('Value must be numbers.', 'mortgage_calculator' ); ?></span>
							</div>
							<div class="scrollTop"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="help-point" id="help-point">
							<i class="fa fa-question-circle pull-left" aria-hidden="true"></i>
							<div class="text">
								<?php echo __('Enter the values above to calculate how much your mortgage will cost', 'mortgage_calculator' ); ?>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mortgage_calculator_results show_results hidden">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="module-title yourResultHeader">
						<h3><?php echo __('Your results', 'mortgage_calculator' ); ?></h3>
					</div>
					
					<hr />
					
					<div class="row">
						<p class="pull-left">
							<?php echo __('Your monthly payment will be', 'mortgage_calculator' ); ?>:
						</p>
						<p class="pull-right result_monthly_payment">
							<i class="fa-currency" aria-hidden="true"><?php echo $currency_entity; ?></i>
							<span class="value">&nbsp;</span>
						</p>
						<div class="clearfix"></div>
						<p class="small"><?php echo __('Assuming interest rates stay the same', 'mortgage_calculator' ); ?></p>
					</div>
					
					<div class="row">
						<p class="pull-left">
							<?php echo __('The total amount you will pay over the term is', 'mortgage_calculator' ); ?>:
						</p>
						<p class="pull-right result_total_amount">
							<i class="fa-currency" aria-hidden="true"><?php echo $currency_entity; ?></i>
							<span class="value">&nbsp;</span>
						</p>
						<div class="clearfix"></div>
						<p class="made_up small">
							<span><?php echo __('Made up of ', 'mortgage_calculator' ); ?></span>
							<i class="fa-currency" aria-hidden="true"><?php echo $currency_entity; ?></i>
							<span class="capital_value">&nbsp;</span>
							<span><?php echo __('capital and ', 'mortgage_calculator' ); ?></span>
							<i class="fa-currency" aria-hidden="true"><?php echo $currency_entity; ?></i>
							<span class="interest_value">&nbsp;</span>
							<span><?php echo __('interest', 'mortgage_calculator' ); ?>.</span>
						</p>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="module-title yourResultHeader">
						<div class="module-title yourResultHeader">
							<h3><?php echo __('Mortgage debt over time', 'mortgage_calculator' ); ?></h3>
						</div>
						
						<hr />
						
						<canvas id="chart" width="400" height="400"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>