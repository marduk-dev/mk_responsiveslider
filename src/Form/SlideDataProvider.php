<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Form;

use Marduk\Module\Mk_ResponsiveSlider\Entity\MkResponsiveSlide;
use Marduk\Module\Mk_ResponsiveSlider\Helpers\FileHelper;
use Marduk\Module\Mk_ResponsiveSlider\Repository\MkResponsiveSlideRepository;
use Marduk\Module\Mk_ResponsiveSlider\Uploader\MkResponsiveSlideUploader;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;
use PrestaShopObjectNotFoundException;

final class SlideDataProvider implements FormDataProviderInterface
{
  private MkResponsiveSlideRepository $repository;
  private MkResponsiveSlideUploader $uploader;
  public $slideId = null;

  public function __construct(MkResponsiveSlideRepository $mkResponsiveSlideRepository, MkResponsiveSlideUploader $uploader)
  {
    $this->repository = $mkResponsiveSlideRepository;
    $this->uploader = $uploader;
  }

  private function formData(MkResponsiveSlide $slide): array
  {
    return [
      SlideFields::Enabled => $slide->isEnabled(),
      SlideFields::Title => $slide->getTitle(),
      SlideFields::SubTitle => $slide->getSubTitle(),
      SlideFields::Position => $slide->getPosition(),
      SlideFields::Url => $slide->getUrl(),
      SlideFields::DesktopImagePreview => FileHelper::getSlideUrl($slide->getDesktopImageName()),
      SlideFields::MobileImagePreview => FileHelper::getSlideUrl($slide->getMobileImageName()),
    ];
  }

  public function getData(): array
  {
    if (is_null($this->slideId))
      return [
        SlideFields::Enabled => true,
      ];

    $slide = $this->repository->get($this->slideId);

    if ($slide) {
      return $this->formData($slide);
    }
    throw new PrestaShopObjectNotFoundException("Slide was not found.");
  }

  private function loadSlide(): MkResponsiveSlide {
    if (!is_null($this->slideId)) {
      return $this->repository->get($this->slideId);
    }

    $slide = new MkResponsiveSlide();
    $slide->setPosition($this->repository->getNextPosition());
    return $slide;
  }

  private function uploadImage($image): string {
    $name = FileHelper::randomizeName($image->getClientOriginalName());
    $this->uploader->upload($name, $image);
    return $name;
  }

  public function setData(array $data): array
  {
    $imagesToDelete = [];
    $slide = $this->loadSlide(); 

    if (is_null($slide)) {
      throw new PrestaShopObjectNotFoundException("Slide was removed by someone else.");
    }

    if ($data[SlideFields::Enabled]) {
      $slide->enable();
    } else {
      $slide->disable();
    }
    $slide->setTitle($data[SlideFields::Title]);
    $slide->setSubTitle($data[SlideFields::SubTitle]);
    $slide->setUrl($data[SlideFields::Url]);

    $desktopImage = $data[SlideFields::DesktopImage];
    if (!is_null($desktopImage)) {
      if (!is_null($this->slideId)) {
        array_push($imagesToDelete, $slide->getDesktopImageName());
      }
      $slide->setDesktopImageName($this->uploadImage($desktopImage));
    }

    $mobileImage = $data[SlideFields::MobileImage];
    if (!is_null($mobileImage)) {
      if (!is_null($this->slideId)) {
        array_push($imagesToDelete, $slide->getMobileImageName());
      }
      $slide->setMobileImageName($this->uploadImage($mobileImage));
    }

    $this->repository->set($slide);

    foreach ($imagesToDelete as $image) {
      $this->uploader->deleteImage($image);
    }

    $this->slideId = $slide->getId();

    return [];
  }

}
