<?php

namespace DVNWPF\General\Classes;

if(!interface_exists('DVNWPF\General\Classes\iBasic'))
{
    interface iBasic
    {
        public function debugArray(array $data = [], bool $die = false) : void;
    }
}

if( !class_exists('\DVNWPF\General\Classes\Basic'))
{    
    /**
     * @name Basic
     * @description Set basic attributes
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
    class Basic implements iBasic
	{		
		protected $params = [];
		
		/**
		 * @name __construct
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function __construct(){}

		/**
		 * @name debugArray
		 *
		 * @param array $arr
		 * @param bool $die
		 * 
		 * @return void
		 */
		public function debugArray(array $data = [], bool $die = false) : void
		{
			echo "<pre>";
			print_r($data);
			echo "</pre>";
			
			if($die) die();
		}
	}
}