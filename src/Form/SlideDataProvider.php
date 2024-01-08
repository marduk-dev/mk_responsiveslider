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
      SlideFields::Description => $slide->getDescription(),
      SlideFields::TextVisible => $slide->isTextVisible(),
      SlideFields::LinkUrl => $slide->getLinkUrl(),
      SlideFields::DesktopImageUrl => $slide->getDesktopImageUrl(),
      SlideFields::DesktopImagePreview => $slide->getDesktopImageUrl(),
      SlideFields::MobileImageUrl => $slide->getMobileImageUrl(),
      SlideFields::MobileImagePreview => $slide->getMobileImageUrl(),
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
    $slide = $this->loadSlide(); 

    if (is_null($slide)) {
      throw new PrestaShopObjectNotFoundException("Slide was removed by someone else.");
    }

    $data[SlideFields::Enabled]
      ? $slide->enable()
      : $slide->disable();
    $slide->setTitle($data[SlideFields::Title]);
    $slide->setDescription($data[SlideFields::Description]);
    $slide->setLinkUrl($data[SlideFields::LinkUrl]);
    $slide->setDesktopImageUrl($data[SlideFields::DesktopImageUrl]);
    $slide->setMobileImageUrl($data[SlideFields::MobileImageUrl]);
    $data[SlideFields::TextVisible]
      ? $slide->showText()
      : $slide->hideText();

    $desktopImage = $data[SlideFields::DesktopImageUpload];
    if (!is_null($desktopImage)) {
      $name = $this->uploadImage($desktopImage);
      $url = FileHelper::getSlideUrl($name);
      $slide->setDesktopImageUrl($url);
    }

    $mobileImage = $data[SlideFields::MobileImageUpload];
    if (!is_null($mobileImage)) {
      $name = $this->uploadImage($mobileImage);
      $url = FileHelper::getSlideUrl($name);
      $slide->setMobileImageUrl($url);
    }

    $this->repository->set($slide);

    $this->slideId = $slide->getId();

    return [];
  }

}
