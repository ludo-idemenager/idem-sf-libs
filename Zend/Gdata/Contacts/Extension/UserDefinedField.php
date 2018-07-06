<?php

/**
 * https://github.com/prasad83/Zend-Gdata-Contacts
 * @author prasad
 * 
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Contacts
 */
require_once 'Zend/Gdata/Extension.php';

class Zend_Gdata_Contacts_Extension_UserDefinedField extends Zend_Gdata_Extension {
    protected $_rootElement = 'userDefinedField';
    protected $_rootNamespace = 'gContact';
    protected $_key = null;
    protected $_value = null;

    public function __construct($key = null, $value = null)
    {
        parent::__construct();
        $this->_key = $key;
        $this->_value = $value;
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_key !== null) {
            $element->setAttribute('key', $this->_key);
        }
        if ($this->_value !== null) {
            $element->setAttribute('value', $this->_value);
        }
        return $element;
    }

    protected function takeAttributeFromDOM($attribute)
    {
        switch ($attribute->localName) {
        case 'key':
            $this->_key = $attribute->nodeValue;
            break;
        case 'value':
            $this->_value = $attribute->nodeValue;
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
    }

    public function __toString()
    {
        return $this->getKey() . '=' . $this->getValue();
    }

    public function getKey()
    {
        return $this->_key;
    }

    public function setKey($value)
    {
        $this->_key = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->_value;
    }

    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }
}