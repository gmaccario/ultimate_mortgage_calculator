<?php

namespace UMC\Controller\Classes;

use UMC\General\Classes\Common;

if(!interface_exists('UMC\Controllers\Classes\iFrontend'))
{
    interface iFrontend
    {
        public function get_mortgage_shortcode() : string;
        public function get_mortgage_calculator_results() : string;
    }
}

if(!class_exists('\UMC\Controllers\Classes\Frontend'))
{
    /**
     * @name Frontend
     * @description Generic class for the Frontend controller
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
    class Frontend extends Controller implements iFrontend
	{
		/**
		 * @name __construct
		 *
		 * @param Common $common
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function __construct(Common $common)
		{
		    parent::__construct($common);
		}

		/**
		 * get_mortgage_shortcode
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 * 
		 */
		public function get_mortgage_shortcode() : string
		{
		    $this->params['action'] = null;
			
		    $this->params['currency_symbol']	= get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_CURRENCY );
		    $this->params['currency_entity'] 	= $this->common->get_currency_entity( $this->params['currency_symbol'] );
		    $this->params['country'] 			= get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_COUNTRY );
			$this->params['mortgage_start_value']= get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEFAULT_MORTGAGE_START_VALUE);
			
			$this->params['hex_color'] 		    = get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_HEX_LINE_COLOR );
			$this->params['rgba_color'] 		= $this->common->get_rgba_from_hex( $this->params['hex_color'] );
			
			$this->params['add_bootstrap'] = get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_ADD_BOOTSTRAP );
			
			if( 1 === intval( $this->params['add_bootstrap'] ))
			{
				wp_enqueue_style( 'mortgage_calculator-frontend-bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
				wp_enqueue_style( 'mortgage_calculator-frontend-bootstrap-css-theme', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' );
			
				wp_enqueue_script( 'mortgage_calculator-frontend-bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), null, true );
			}
			
			return $this->common->renderView( $this, 'ultimate_mortgage_calculator', $this->params );
		}
		
		/**
		 * get_mortgage_calculator_results
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 * 
		 */
		public function get_mortgage_calculator_results() : string
		{
			$present_value 		= filter_input( INPUT_POST, 'present_value', FILTER_SANITIZE_NUMBER_INT );
			$numbers_of_period 	= filter_input( INPUT_POST, 'numbers_of_period', FILTER_SANITIZE_NUMBER_INT );
			$rate_per_period 	= filter_input( INPUT_POST, 'rate_per_period', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			
			$months = ($numbers_of_period * 12);
			
			/* monthly payment	*/
			$j = $rate_per_period / (12 * 100);
			$divisor = 1 - pow((1 + $j), -1 * $months);
			$monthly_payment = floor($present_value * ($j / $divisor));
			
			/* total amount */
			$total_amount = $months * $monthly_payment;
			
			/* interest value */
			$interest_value = $total_amount - $present_value;
			
			/* x|y for chart */
			$charts = $this->calculateXYCharts( $present_value, $rate_per_period, $numbers_of_period );
			
			wp_send_json( array( 'results' => array(
				'success' 			=> true,
				'present_value' 	=> $present_value,
				'rate_per_period' 	=> $rate_per_period,
				'numbers_of_period' => $numbers_of_period,
				'monthly_payment' 	=> $monthly_payment,
				'total_amount' 		=> $total_amount,
				'interest_value' 	=> $interest_value,
				'charts' 			=> $charts,
				'error' 			=> array()
			)));
			
			wp_die();
		}
		
		/**
		 * calculateXYCharts
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * 
		 * return array
		 * 
		 */
		private function calculateXYCharts( $p, $iy, $ny ) : array
		{
			$x = array();
			$y = array();
			
			array_push($x, 0);
			array_push($y, $p);
			
			$newbal = 0;
			$im = ($iy / 12) / 100;
			$nm = $ny * 12;
			$mp = 0;
			$ip = 0;
			$pp = 0;

			$mp = $p * $im * pow(1 + $im, $nm) / (pow(1 + $im, $nm) - 1);
			
			for( $i=1; $i<=$nm; $i++ )
			{     
				$ip = $p * $im; /* interest paid */
				$pp = $mp - $ip; /* princial paid */
				$newbal = $p - $pp; /* new balance */               
				
				array_push($x, $i / 12);
				
				if( floor($newbal * 100) / 10 >= 0 )
				{
					array_push($y, floor($newbal * 100) / 100);
				}

				$p=$newbal; /* update old balance */
			}
			
			return array(
				'x' => $x, 
				'y' => $y
			);
		}
	}
}