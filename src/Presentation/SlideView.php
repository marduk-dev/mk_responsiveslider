<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Presentation;

use Marduk\Module\Mk_ResponsiveSlider\Entity\MkResponsiveSlide;
use Marduk\Module\Mk_ResponsiveSlider\Repository\MkResponsiveSlideRepository;
use Marduk\Module\Mk_ResponsiveSlider\Helpers\FileHelper;

class SlideView {

  const SlideId = 'id';
  const SlideTitle = 'title';
  const SlideDescription = 'description';
  const SlidePosition = 'position';
  const SlideIsEnabled = 'enabled';
  const SlideDesktopImg = 'desktop_img';
  const SlideMobileImg = 'mobile_img';
  const SlideLegend = 'legend';

  private MkResponsiveSlideRepository $repository;
  public function __construct(MkResponsiveSlideRepository $repository)
  {
    $this->repository = $repository;
  }

  public function all(): array
  {
    $raw = $this->repository->findBy([], ['position' => 'asc']);
    return array_map(static::toView(...), $raw);
  }

  public function allEnabled()
  {
    $raw = $this->repository->findBy(['enabled' => 'true'], ['position' => 'asc']);
    return array_map(static::toView(...), $raw);
  }

  public static function toView(MkResponsiveSlide  $slide)
  {
    return [
      static::SlideId => $slide->getId(),
      static::SlideTitle => $slide->getTitle(),
      static::SlidePosition => $slide->getPosition(),
      static::SlideIsEnabled => $slide->isEnabled(),
      static::SlideDescription => $slide->getSubTitle(),
      static::SlideLegend => $slide->getTitle(),
      static::SlideDesktopImg => FileHelper::getSlideUrl($slide->getDesktopImageName()),
      static::SlideMobileImg => FileHelper::getSlideUrl($slide->getMobileImageName()),
    ];
  }
}
