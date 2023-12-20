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
	private MkResponsiveSlideRepository $mkResponsiveSlideRepository;
  private MkResponsiveSlideUploader $uploader;
  public $slideId = null;

	public function __construct(MkResponsiveSlideRepository $mkResponsiveSlideRepository, MkResponsiveSlideUploader $uploader)
	{
		$this->mkResponsiveSlideRepository = $mkResponsiveSlideRepository;
    $this->uploader = $uploader;
	}

  private function formData(MkResponsiveSlide $slide): array {
    return [
      SlideFields::Title => $slide->getTitle(),
      SlideFields::SubTitle => $slide->getSubTitle(),
      SlideFields::OrderValue => $slide->getOrderWeight(),
      SlideFields::DesktopImagePreview => FileHelper::getSlideUrl($slide->getDesktopImageName()),
      SlideFields::MobileImagePreview => FileHelper::getSlideUrl($slide->getMobileImageName()),
    ];
  }

  public function getData(): array
  {
    if (is_null($this->slideId))
      return [];

		$slide = $this->mkResponsiveSlideRepository->get($this->slideId);

		if ($slide) {
			return $this->formData($slide);
		}
		throw new PrestaShopObjectNotFoundException("Slide was not found.");
  }

  public function setData(array $data): array {
    $imagesToDelete = [];
    $slide = is_null($this->slideId)
      ? new MkResponsiveSlide()
      : $this->mkResponsiveSlideRepository->get($this->slideId);
    
    if (is_null($slide)) {
      throw new PrestaShopObjectNotFoundException("Slide was removed by someone else.");
    }

    $slide->setTitle($data[SlideFields::Title]);
    $slide->setSubTitle($data[SlideFields::SubTitle]);
    $slide->setOrderWeight($data[SlideFields::OrderValue]);

    $desktopImage = $data[SlideFields::DesktopImage];
    if (!is_null($desktopImage)) {
      if (!is_null($this->slideId)) {
        array_push($imagesToDelete, $slide->getDesktopImageName());
      }
      $slide->setDesktopImageName(FileHelper::randomizeName($desktopImage->getClientOriginalName()));
    }

    $mobileImage = $data[SlideFields::MobileImage];
    if (!is_null($mobileImage)) {
      if (!is_null($this->slideId)) {
        array_push($imagesToDelete, $slide->getDesktopImageName());
      }
      $slide->setMobileImageName(FileHelper::randomizeName($mobileImage->getClientOriginalName()));
    }

    if (!is_null($desktopImage)) {
      $this->uploader->upload($slide->getDesktopImageName(), $desktopImage);
    }
    if (!is_null($mobileImage)) {
      $this->uploader->upload($slide->getMobileImageName(), $mobileImage);
    }

    $this->mkResponsiveSlideRepository->set($slide);

    foreach ($imagesToDelete as $image) {
      $this->uploader->deleteImage($image);
    }

    $this->slideId = $slide->getId();

    return [];
  }

}
