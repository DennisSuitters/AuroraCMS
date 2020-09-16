<?php

require '../../zebra_image.php';

class elFinderPluginMultiImages extends elFinderPlugin {
  private $options = [];
  private $defaultOptions = [
    'enable' => true,
    'images_path' => '',
    'imageSizes' =>  [
      'thumbs' => null,
      'sm'  => null,
      'md' => null,
      'lg'  => null,
    ],
    'imageQuality' => 80
  ];

  public function __construct($options) {
    $this -> options = array_merge($this -> defaultOptions, $options );
  }

  public function generateMultiImages(&$path, &$name, $src, $elfinder, $volume) {
    $options = $this -> options;
    if($options == 'false' || $options['images_path']=='') return false;
    $imgTypes = $this -> mimeType($options, $src);
    if($imgTypes == 'false') return false;
    $imagesPath = $options['images_path'];
    $this -> createFolders($imagesPath);
    $this -> resize($src, $imagesPath, $name);
  }

  public function removeThumbs($cmd, $targets) {
    $thumbs = $this -> options['imageSizes'];
    foreach( $thumbs as $key => $value) {
      if(is_dir( $this -> options['images_path'] . $key )) {
        foreach ($targets['targets'] as $target) {
          $h = explode('_', $target);
          $fileName = explode('/', base64_decode(strtr(end($h), '-_.', '+/=')));
          if (file_exists($this -> options['images_path'] . $key . '/' . end($fileName)))
            unlink($this -> options['images_path'] . $key . '/' . end($fileName));
        }
      }
    }
  }

  protected function mimeType($opts, $src) {
    $srcImgInfo = @getimagesize( $src );
    if ( $srcImgInfo === false ) return 'false';
    switch ( $srcImgInfo[ 'mime' ] ) {
      case 'image/gif':
        break;
      case 'image/jpeg':
        break;
      case 'image/png':
        break;
      default:
        return 'false';
    }
  }

  private function createFolders($imagesPath) {
    $images = $this -> options['imageSizes'];
    foreach( $images as $key => $value) {
      if($value != '') {
        if( ! is_dir( $imagesPath . $key )) mkdir($imagesPath . $key, 0777, true);
      }
    }
  }

  private function resize($src, $imagesPath, $name) {
    $images = $this -> options['imageSizes'];
    foreach( $images as $key => $value) {
      if(is_array($value) and count($value) == 2) {
        $fakeName = $this -> getName($imagesPath . $key . '/',$name);
        $image = new Zebra_Image();
        $image -> source_path = $src;
        $image -> target_path = $imagesPath . $key . '/' . $fakeName;
        $image -> jpeg_quality = $this -> options['imageQuality'];
        $image -> preserve_aspect_ratio = true;
        $image -> sharpen_images = true;
        $image -> resize($value[0], $value[1], ZEBRA_IMAGE_CROP_CENTER);
      }
    }
  }

  private function getName($imagesPath, $name) {
    $fileName = explode('.', $name);
    $count = count($fileName);
    $name = '';
    foreach ($fileName as $a => $item) {
      if ($a == ($count - 2)) {
        if (!file_exists($imagesPath. $name . $item . '.' . end($fileName))) {
          $name .= $item . '.' . end($fileName);
          break;
        }else {
          for ($i = 1; $i <= 100; $i++) {
            if (file_exists($imagesPath . $name.$item . '-' . $i . '.' . end($fileName))) {
              $this->getName($imagesPath, $name.$item . '-' . $i . '.' . end($fileName));
            } else {
              $name .= $item . '-' . $i . '.';
              break;
            }
          }
        }
      }else{
        $name .= $item;
      }
    }
    return $name;
  }
}
