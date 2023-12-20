<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Helpers;

use Exception;
use Marduk\Module\Mk_ResponsiveSlider\Entity\MkResponsiveSlide;

class FileHelper
{
  public static function getFileExtenstion(string $filename): string|bool
  {
    $nameExplode = explode('.', $filename);
    if (count($nameExplode) >= 2) {
      return strtolower($nameExplode[count($nameExplode) - 1]);
    }
    return false;
  }

  public static function randomizeName(string $filename): string
  {
    return static::uniqid("MK_SLIDE_") . '.' . static::getFileExtenstion($filename);
  }

  public static function uniqid(string $prefix = ''): string
  {
    if (function_exists("random_bytes")) {
      $bytes = random_bytes(12);
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
      $bytes = openssl_random_pseudo_bytes(12);
    } else {
      throw new Exception("no cryptographically secure random function available");
    }
    return $prefix . substr(bin2hex($bytes), 0, 24);
  }

  static function getDesktopSlidePath(MkResponsiveSlide $slide): string | false {
    if ($slide) {
      return static::getSlideFilePath($slide->getDesktopImageName());
    }
    return false;
  }

  static function getMobileSlidePath(MkResponsiveSlide $slide): string | false {
    if ($slide) {
      return static::getSlideFilePath($slide->getMobileImageName());
    }
    return false;
  }

  static function getSlideFilePath(string $imageName): string {
    return _PS_SUPP_IMG_DIR_ . $imageName;
  }

  static function getSlideUrl(string $imageName): string {
    return '/img/su/' . $imageName;
  }

}
