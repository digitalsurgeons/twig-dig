<?php
/**
 * TwigDig plugin for Craft CMS 3.x
 *
 * A few twig helpers for digging into variables
 *
 * @link      https://www.digitalsurgeons.com
 * @copyright Copyright (c) 2019 Digital Surgeons
 */

namespace digitalsurgeons\twigdig\twigextensions;

use digitalsurgeons\twigdig\TwigDig;

use Craft;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Digital Surgeons
 * @package   TwigDig
 * @since     1.0.0
 */
class TwigDigTwigExtension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'TwigDig';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *      {{ 'something' | someFilter }}
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            // new \Twig_SimpleFilter('someFilter', [$this, 'someInternalFunction']),
        ];
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     *      {% set this = someFunction('something') %}
     *
    * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('typeOf', [$this, 'getTypeOf']),
            new \Twig_SimpleFunction('existsOrTrue', [$this, 'existsOrTrue'])
        ];
    }

    /**
     * Our function called via Twig; it can do anything you want
     *
     * @param null $text
     *
     * @return string
     */
    public function getTypeOf($variable)
    {
        return gettype($variable);
    }

    public function existsOrTrue($variable)
    {
        if (isset($variable)) {
            if ($variable == NULL) {
                return false;
            }

            switch (\gettype($variable)) {
                case 'NULL':
                    return false;
                    break;
                case 'array':
                    if (sizeof($variable) < 1) {
                        return false;
                    } else {
                        return true;
                    }
                    break;
                case 'string':
                    if (strlen($variable) == 0) {
                        return false;
                    } else {
                        return true;
                    }
                    break;
                case 'integer':
                case 'double':
                    if ($variable == 0) {
                        return false;
                    } else {
                        return true;
                    }
                    break;
                case 'boolean':
                    return $variable;
                    break;
                case 'object':
                    if (sizeof(get_object_vars($variable)) < 1) {
                        return false;
                    } else {
                        return true;
                    }
                    break;
            }
        } else {
            return false;
        }
    }
}
