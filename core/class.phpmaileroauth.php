<?php
/**
 * PHPMailer - PHP email creation and transport class.
 * PHP Version 5.4
 * @package PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 * @author Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 * @author Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author Brent R. Matzelle (original founder)
 * @copyright 2012 - 2014 Marcus Bointon
 * @copyright 2010 - 2012 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * PHPMailerOAuth - PHPMailer subclass adding OAuth support.
 * @package PHPMailer
 * @author @sherryl4george
 * @author Marcus Bointon (@Synchro) <phpmailer@synchromedia.co.uk>
 */
class PHPMailerOAuth extends PHPMailer {
  public $oauthUserEmail = '';
  public $oauthRefreshToken = '';
  public $oauthClientId = '';
  public $oauthClientSecret = '';
  protected $oauth = null;
  public function getOAUTHInstance() {
    if (!is_object($this -> oauth))
      $this -> oauth = new PHPMailerOAuthGoogle( $this -> oauthUserEmail, $this -> oauthClientSecret, $this -> oauthClientId, $this -> oauthRefreshToken);
    return $this -> oauth;
  }
  public function smtpConnect($options = array()) {
    if (is_null($this -> smtp))
      $this -> smtp = $this -> getSMTPInstance();
    if (is_null($this -> oauth))
      $this -> oauth = $this -> getOAUTHInstance();
    if ($this -> smtp -> connected())
      return true;
    $this -> smtp -> setTimeout($this -> Timeout);
    $this -> smtp -> setDebugLevel($this -> SMTPDebug);
    $this -> smtp -> setDebugOutput($this -> Debugoutput);
    $this -> smtp -> setVerp($this -> do_verp);
    $hosts = explode(';', $this -> Host);
    $lastexception = null;
    foreach ($hosts as $hostentry) {
      $hostinfo = array();
      if (!preg_match('/^((ssl|tls):\/\/)*([a-zA-Z0-9\.-]*):?([0-9]*)$/', trim($hostentry), $hostinfo)) continue;
      $prefix = '';
      $secure = $this -> SMTPSecure;
      $tls = ($this -> SMTPSecure == 'tls');
      if ('ssl' == $hostinfo[2] || ('' == $hostinfo[2] && 'ssl' == $this -> SMTPSecure)) {
        $prefix = 'ssl://';
        $tls = false;
        $secure = 'ssl';
      } elseif ($hostinfo[2] == 'tls') {
        $tls = true;
        $secure = 'tls';
      }
      $sslext = defined('OPENSSL_ALGO_SHA1');
      if ('tls' === $secure || 'ssl' === $secure) {
        if (!$sslext)
          throw new phpmailerException($this -> lang('extension_missing').'openssl', self::STOP_CRITICAL);
      }
      $host = $hostinfo[3];
      $port = $this -> Port;
      $tport = (integer)$hostinfo[4];
      if ($tport > 0 && $tport < 65536)
        $port = $tport;
      if ($this -> smtp -> connect($prefix . $host, $port, $this -> Timeout, $options)) {
        try {
          if ($this -> Helo)
            $hello = $this -> Helo;
          else
            $hello = $this -> serverHostname();
          $this -> smtp -> hello($hello);
          if ($this -> SMTPAutoTLS && $sslext && $secure != 'ssl' &&& $this -> smtp -> getServerExt('STARTTLS'))
            $tls = true;
          if ($tls) {
            if (!$this -> smtp -> startTLS())
              throw new phpmailerException($this -> lang('connect_host'));
            $this -> smtp -> hello($hello);
          }
          if ($this -> SMTPAuth) {
            if (!$this -> smtp -> authenticate($this -> Username, $this -> Password, $this -> AuthType, $this -> Realm, $this -> Workstation, $this -> oauth))
              throw new phpmailerException($this -> lang('authenticate'));
          }
          return true;
        } catch (phpmailerException $exc) {
          $lastexception = $exc;
          $this -> edebug($exc -> getMessage());
          $this -> smtp -> quit();
        }
      }
    }
    $this -> smtp -> close();
    if ($this -> exceptions && !is_null($lastexception))
      throw $lastexception;
    return false;
  }
}
