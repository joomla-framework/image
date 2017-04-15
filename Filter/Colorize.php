<?php
/**
 * Part of the Joomla Framework Image Package
 *
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Image\Filter;

use Joomla\Image\ImageFilter;
use InvalidArgumentException;

/**
 * Image Filter class to colorize an image.
 *
 * @since  1.0
 */
class Colorize extends ImageFilter
{
	
	/**
	 * @var    array  Available predefines values for the colorize filter.
	 */ 
	protected $colors = array(
		'CORDOVAN' => '893F45',
		'COFFEE' => '6F4E37',
		'MAHAGONY' => 'A52A2A',
		'SEPIA' => '704214',
		'SINOPIA' => 'CB410B'
	);
		
	/**
	 * Method to apply a filter to an image resource.
	 *
	 * @param   array  $options  An array of options for the filter.
	 *
	 * @return  void
	 *
	 */
	public function execute(array $options = array())
	{
		
		// Validate that the colorize value exists and is a string.
		if (!isset($options[IMG_FILTER_COLORIZE]) || !is_string($options[IMG_FILTER_COLORIZE]))
		{
			throw new InvalidArgumentException('No valid colorize value was given. Expected an hexidecimal color code string');
		}
		
		// Uppercase the string to avoid misspelling
		$options[IMG_FILTER_COLORIZE] = strtoupper($options[IMG_FILTER_COLORIZE]);
		
		// Check for defined colorize values
		if (isset($this->colors[$options[IMG_FILTER_COLORIZE]]))
		{
			// Set the corresponding hex color value
			$options[IMG_FILTER_COLORIZE] = $this->colors[$options[IMG_FILTER_COLORIZE]];	
		}
		
		// Check for potential # sign, strip it off
		$options[IMG_FILTER_COLORIZE] = ltrim($options[IMG_FILTER_COLORIZE], '#');
				
		// Check if the string is a valid hex color value
		if (ctype_xdigit($options[IMG_FILTER_COLORIZE]) && (strlen($options[IMG_FILTER_COLORIZE]) == 6 || strlen($options[IMG_FILTER_COLORIZE]) == 3)) {
		
			//Convert the hex color value to rgb
			if(strlen($options[IMG_FILTER_COLORIZE]) == 3) {
				$r = hexdec(substr($options[IMG_FILTER_COLORIZE],0,1).substr($options[IMG_FILTER_COLORIZE],0,1));
				$g = hexdec(substr($options[IMG_FILTER_COLORIZE],1,1).substr($options[IMG_FILTER_COLORIZE],1,1));
				$b = hexdec(substr($options[IMG_FILTER_COLORIZE],2,1).substr($options[IMG_FILTER_COLORIZE],2,1));	
			} else {
				$r = hexdec(substr($options[IMG_FILTER_COLORIZE],0,2));
				$g = hexdec(substr($options[IMG_FILTER_COLORIZE],2,2));
				$b = hexdec(substr($options[IMG_FILTER_COLORIZE],4,2));
			}
			
			$options[IMG_FILTER_COLORIZE] = array($r, $g, $b);
		}
		else {
			throw new InvalidArgumentException('No valid colorize value was given.  Expected an hexidecimal color code');
		}
		
		// Perform the colorize filter
		imagefilter($this->handle, IMG_FILTER_COLORIZE, $options[IMG_FILTER_COLORIZE][0], $options[IMG_FILTER_COLORIZE][1], $options[IMG_FILTER_COLORIZE][2]);
	}
}
