<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Form;

use PrestaShopBundle\Translation\TranslatorInterface;

enum SlideImage: int {
  case Upload = 0;
  case Url = 1;

  public function getReadable(TranslatorInterface $translator): string {
    return match ($this) {
      SlideImage::UPLOAD => $translator->trans('Uploaded image', domain: 'Modules.Mkresponsiveslider.Admin'),
      SlideImage::URL => $translator->trans('Url to image', domain: 'Modules.Mkresponsiveslider.Admin'),
    };
  }
}