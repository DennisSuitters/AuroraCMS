<?php
/**
 * PHPMailer - PHP email creation and transport class.
 * PHP Version 5.5.
 *
 * @see       https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 *
 * @author    Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 * @author    Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author    Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author    Brent R. Matzelle (original founder)
 * @copyright 2012 - 2015 Marcus Bointon
 * @copyright 2010 - 2012 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace PHPMailer\PHPMailer;
use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
class OAuth {
  protected $provider;
  protected $oauthToken;
  protected $oauthUserEmail = '';
  protected $oauthClientSecret = '';
  protected $oauthClientId = '';
  protected $oauthRefreshToken = '';
  public function __construct($options) {
    $this->provider = $options['provider'];
    $this->oauthUserEmail = $options['userName'];
    $this->oauthClientSecret = $options['clientSecret'];
    $this->oauthClientId = $options['clientId'];
    $this->oauthRefreshToken = $options['refreshToken'];
  }
  protected function getGrant() {
    return new RefreshToken();
  }
  protected function getToken() {
    return $this -> provider -> getAccessToken( $this -> getGrant(), ['refresh_token' => $this -> oauthRefreshToken]);
  }
  public function getOauth64() {
    if (null === $this -> oauthToken || $this -> oauthToken -> hasExpired()) $this -> oauthToken = $this -> getToken();
    return base64_encode('user=' . $this -> oauthUserEmail . "\001auth=Bearer " . $this -> oauthToken . "\001\001");
  }
}
