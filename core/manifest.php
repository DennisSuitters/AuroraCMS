<?php
/**
 * AuroraCMS - Copyright (C) Diemen Design 2019
 *
 * @category   Core - Manifest Generator
 * @package    core/manifest.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    0.0.1
 * @link       https://github.com/DiemenDesign/AuroraCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
header('Content-Type: application/json');
$getcfg=true;
require'db.php';
if(!defined('DS'))define('DS',DIRECTORY_SEPARATOR);
if(!defined('THEME'))define('THEME','layout'.DS.$config['theme']);
if(!defined('URL'))define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
if(!defined('FAVICON128')){
  if(file_exists(THEME.DS.'images'.DS.'favicon-128.png')){define('FAVICON128',THEME.DS.'images'.DS.'favicon-128.png');define('FAVICON128TYPE','image/png');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-128.gif')){define('FAVICON128',THEME.DS.'images'.DS.'favicon-128.gif');define('FAVICON128TYPE','image/gif');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-128.jpg')){define('FAVICON128',THEME.DS.'images'.DS.'favicon-128.jpg');define('FAVICON128TYPE','image/jpg');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-128.ico')){define('FAVICON128',THEME.DS.'images'.DS.'favicon-128.ico');define('FAVICON128TYPE','image/ico');
  }else{define('FAVICON128','core'.DS.'images'.DS.'favicon.png');define('FAVICON128TYPE','image/png');}
}
if(!defined('FAVICON144')){
  if(file_exists(THEME.DS.'images'.DS.'favicon-144.png')){define('FAVICON144',THEME.DS.'images'.DS.'favicon-144.png');define('FAVICON144TYPE','image/png');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-144.gif')){define('FAVICON144',THEME.DS.'images'.DS.'favicon-144.gif');define('FAVICON144TYPE','image/gif');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-144.jpg')){define('FAVICON144',THEME.DS.'images'.DS.'favicon-144.jpg');define('FAVICON144TYPE','image/jpg');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-144.ico')){define('FAVICON144',THEME.DS.'images'.DS.'favicon-144.ico');define('FAVICON144TYPE','image/ico');
  }else{define('FAVICON144','core'.DS.'images'.DS.'favicon.png');define('FAVICON144TYPE','image/png');}
}
if(!defined('FAVICON152')){
  if(file_exists(THEME.DS.'images'.DS.'favicon-152.png')){define('FAVICON152',THEME.DS.'images'.DS.'favicon-152.png');define('FAVICON152TYPE','image/png');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-152.gif')){define('FAVICON152',THEME.DS.'images'.DS.'favicon-152.gif');define('FAVICON152TYPE','image/gif');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-152.jpg')){define('FAVICON152',THEME.DS.'images'.DS.'favicon-152.jpg');define('FAVICON152TYPE','image/jpg');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-152.ico')){define('FAVICON152',THEME.DS.'images'.DS.'favicon-152.ico');define('FAVICON152TYPE','image/ico');
  }else{define('FAVICON152','core'.DS.'images'.DS.'favicon.png');define('FAVICON152TYPE','image/png');}
}
if(!defined('FAVICON192')){
  if(file_exists(THEME.DS.'images'.DS.'favicon-192.png')){define('FAVICON192',THEME.DS.'images'.DS.'favicon-192.png');define('FAVICON192TYPE','image/png');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-192.gif')){define('FAVICON192',THEME.DS.'images'.DS.'favicon-192.gif');define('FAVICON192TYPE','image/gif');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-192.jpg')){define('FAVICON192',THEME.DS.'images'.DS.'favicon-192.jpg');define('FAVICON192TYPE','image/jpg');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-192.ico')){define('FAVICON192',THEME.DS.'images'.DS.'favicon-192.ico');define('FAVICON192TYPE','image/ico');
  }else{define('FAVICON192','core'.DS.'images'.DS.'favicon.png');define('FAVICON192TYPE','image/png');}
}
if(!defined('FAVICON256')){
  if(file_exists(THEME.DS.'images'.DS.'favicon-256.png')){define('FAVICON256',THEME.DS.'images'.DS.'favicon-256.png');define('FAVICON256TYPE','image/png');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-256.gif')){define('FAVICON256',THEME.DS.'images'.DS.'favicon-256.gif');define('FAVICON256TYPE','image/gif');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-256.jpg')){define('FAVICON256',THEME.DS.'images'.DS.'favicon-256.jpg');define('FAVICON256TYPE','image/jpg');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-256.ico')){define('FAVICON256',THEME.DS.'images'.DS.'favicon-256.ico');define('FAVICON256TYPE','image/ico');
  }else{define('FAVICON256','core'.DS.'images'.DS.'favicon.png');define('FAVICON256TYPE','image/png');}
}
if(!defined('FAVICON512')){
  if(file_exists(THEME.DS.'images'.DS.'favicon-512.png')){define('FAVICON512',THEME.DS.'images'.DS.'favicon-512.png');define('FAVICON512TYPE','image/png');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-512.gif')){define('FAVICON512',THEME.DS.'images'.DS.'favicon-512.gif');define('FAVICON512TYPE','image/gif');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-512.jpg')){define('FAVICON512',THEME.DS.'images'.DS.'favicon-512.jpg');define('FAVICON512TYPE','image/jpg');
  }elseif(file_exists(THEME.DS.'images'.DS.'favicon-512.ico')){define('FAVICON512',THEME.DS.'images'.DS.'favicon-512.ico');define('FAVICON512TYPE','image/ico');
  }else{define('FAVICON512','core'.DS.'images'.DS.'favicon.png');define('FAVICON512TYPE','image/png');}
}
echo json_encode([
  "name"=>$config['business'],
  "short_name"=>'AuroraCMS',
  "gcm_user_visible_only"=>true,
  "description"=>$config['seoDescription'],
  "start_url"=>'/',
  "display"=>"standalone",
  "background_color"=>'#000000',
  "theme_color"=>"#000000",
  "icons"=>[
    [
      "src"=>FAVICON128,
      "sizes"=>"128x128",
      "type"=>FAVICON128TYPE
    ],
    [
      "src"=>FAVICON144,
      "sizes"=>"144x144",
      "type"=>FAVICON144TYPE
    ],
    [
      "src"=>FAVICON152,
      "sizes"=>"152x152",
      "type"=>FAVICON152TYPE
    ],
    [
      "src"=>FAVICON192,
      "sizes"=>"192x192",
      "type"=>FAVICON192TYPE
    ],
    [
      "src"=>FAVICON256,
      "sizes"=>"256x256",
      "type"=>FAVICON256TYPE
    ],
    [
      "src"=>FAVICON512,
      "sizes"=>"512x512",
      "type"=>FAVICON512TYPE
    ]
  ]
]);
