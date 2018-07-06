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
require_once 'Zend/Gdata/Contacts/Extension.php';

class Zend_Gdata_Contacts_Extension_GroupMembershipInfo extends Zend_Gdata_Contacts_Extension {
	
	protected $_rootNamespace = 'gContact';
	protected $_rootElement = 'groupMembershipInfo';
	
	protected $_valueAttrName = 'href';
	
	public function __construct($user = null, $groupId = null) {
		$groupUri = null;
		if ($user != null && $groupId != null)
			$groupUri = "http://www.google.com/m8/feeds/groups/".urlencode($user)."/base/".$groupId;
		parent::__construct($groupUri);
    }
	
	public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null) {
		$element = parent::getDOM($doc, $majorVersion, $minorVersion);
		$element->setAttribute('deleted', 'false');
		return $element;
	}
	
}