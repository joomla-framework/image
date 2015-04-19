<?php
/**
 * Part of the Joomla Framework Image Package
 *
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Image\Filter;

use Joomla\Image\ImageFilter;
use InvalidArgumentException;

/**
 * Image Filter class to blurs the image using the Gaussian method.
 * To increase blur effect, the filter must be applied multiple times. This can be quite slow.
 *
 * @since  1.1.5
 */
class Gaussianblur extends ImageFilter
{
    /**
     * Method to apply a filter to an image resource.
     *
     * @param   array  $options  An array of options for the filter.
     *
     * @return  void
     *
     * @since   1.0
     * @throws  InvalidArgumentException
     */
    public function execute(array $options = array())
    {
        // Validate that the blur iterations number exists and is an integer. Default is 1.
        if (!isset($options[IMG_FILTER_GAUSSIAN_BLUR]) || !is_int($options[IMG_FILTER_GAUSSIAN_BLUR]))
        {
            $options[IMG_FILTER_GAUSSIAN_BLUR] = 1;
        }

        // Perform the gaussian blur filter.
        for ($i=0;$i<$options[IMG_FILTER_GAUSSIAN_BLUR];$i++)
        {
            imagefilter($this->handle, IMG_FILTER_GAUSSIAN_BLUR);
        }
    }
}
