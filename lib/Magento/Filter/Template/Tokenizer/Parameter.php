<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Magento
 * @package    Magento_Filter
 * @copyright  Copyright (c) 2013 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magento\Filter\Template\Tokenizer;

/**
 * Template constructions parameters tokenizer
 */
class Parameter extends \Magento\Filter\Template\Tokenizer\AbstractTokenizer
{

    /**
     * Tokenize string and return getted parameters
     *
     * @return array
     */
    public function tokenize()
    {
        $parameters = array();
        $parameterName = '';
        while ($this->next()) {
            if ($this->isWhiteSpace()) {
                continue;
            } elseif($this->char() != '=') {
                $parameterName .= $this->char();
            } else {
                $parameters[$parameterName] = $this->getValue();
                $parameterName = '';
            }
        }
        return $parameters;
    }

    /**
     * Get string value in parameters through tokenize
     *
     * @return string
     */
    public function getValue()
    {
        $this->next();
        $value = '';
        if ($this->isWhiteSpace()) {
            return $value;
        }
        $quoteStart = $this->char() == "'" || $this->char() == '"';


        if ($quoteStart) {
           $breakSymbol = $this->char();
        } else {
           $breakSymbol = false;
           $value .= $this->char();
        }

        while ($this->next()) {
            if (!$breakSymbol && $this->isWhiteSpace()) {
                break;
            } elseif ($breakSymbol && $this->char() == $breakSymbol) {
                break;
            } elseif ($this->char() == '\\') {
                $this->next();
                $value .= $this->char();
            } else {
                $value .= $this->char();
            }
        }
        return $value;
    }
}