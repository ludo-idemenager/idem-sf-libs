<?php

/**
 * Zend Framework
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
 * @subpackage Gdata
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: ClientLogin.php 20096 2010-01-06 02:05:09Z bkarwin $
 */

/**
 * Zend_Gdata_HttpClient
 */
require_once 'Zend/Gdata/HttpClient.php';

/**
 * Zend_Version
 */
require_once 'Zend/Version.php';

/**
 * Class to facilitate Google's "Account Authentication
 * for Installed Applications" also known as "ClientLogin".
 * @see http://code.google.com/apis/accounts/AuthForInstalledApps.html
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @subpackage Gdata
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Gdata_ClientOAuth
{

    /**
     * The Google client login URI
     *
     */
    const CLIENTLOGIN_URI = 'https://www.google.com/accounts/ClientLogin';

    /**
     * The default 'source' parameter to send to Google
     *
     */
    const DEFAULT_SOURCE = 'Zend-ZendFramework';

    /**
     * Set Google authentication credentials.
     * Must be done before trying to do any Google Data operations that
     * require authentication.
     * For example, viewing private data, or posting or deleting entries.
     *
     * @param string $email
     * @param string $password
     * @param string $service
     * @param Zend_Gdata_HttpClient $client
     * @param string $source
     * @param string $loginToken The token identifier as provided by the server.
     * @param string $loginCaptcha The user's response to the CAPTCHA challenge.
     * @param string $accountType An optional string to identify whether the
     * account to be authenticated is a google or a hosted account. Defaults to
     * 'HOSTED_OR_GOOGLE'. See: http://code.google.com/apis/accounts/docs/AuthForInstalledApps.html#Request
     * @throws Zend_Gdata_App_AuthException
     * @throws Zend_Gdata_App_HttpException
     * @throws Zend_Gdata_App_CaptchaRequiredException
     * @return Zend_Gdata_HttpClient
     */
    public static function getHttpClient($accessToken, $client = null,
        $source = self::DEFAULT_SOURCE)
    {
        if (!$accessToken) {
            require_once 'Zend/Gdata/App/AuthException.php';
            throw new Zend_Gdata_App_AuthException(
                   'Please set your Google access token before trying to ' .
                   'authenticate');
        }

        if ($client == null) {
            $client = new Zend_Gdata_HttpClient();
        }
        
        if (!$client instanceof Zend_Http_Client) {
            require_once 'Zend/Gdata/App/HttpException.php';
            throw new Zend_Gdata_App_HttpException(
                    'Client is not an instance of Zend_Http_Client.');
        }

        $decoded = json_decode($accessToken, true);
        if ($decoded == NULL) {
        	require_once 'Zend/Gdata/App/HttpException.php';
            throw new Zend_Gdata_App_HttpException(
                    'Impossible de décoder le access token.');
        }
		$decodedAccessToken = $decoded["access_token"];
        
        $client->setOAuthAccessToken($decodedAccessToken);
        $useragent = $source . ' Zend_Framework_Gdata/' . Zend_Version::VERSION;
        $client->setConfig(array(
              'strictredirects' => true,
              'useragent' => $useragent
            )
        );
        
        return $client;

    }

}

