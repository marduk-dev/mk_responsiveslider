<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Form;

use Marduk\Module\Mk_ResponsiveSlider\Helpers\FileHelper;
use Marduk\Module\Mk_ResponsiveSlider\Repository\MkResponsiveSlideRepository;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;
use PrestaShopObjectNotFoundException;

class SlideDataProvider implements FormDataProviderInterface
{
	private $mkResponsiveSlideRepository;

	public function __construct(MkResponsiveSlideRepository $mkResponsiveSlideRepository)
	{
		$this->mkResponsiveSlideRepository = $mkResponsiveSlideRepository;
	}

	/**
	 * Get form data for given object with given id.
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	public function getData($id): array
	{
		$slide = $this->mkResponsiveSlideRepository->get($id);

		if ($slide) {
			return [
				SlideFields::Title => $slide->getTitle(),
				SlideFields::SubTitle => $slide->getSubTitle(),
				SlideFields::OrderValue => $slide->getOrderWeight(),
				SlideFields::DesktopImagePreview => FileHelper::getSlidePath($slide),
				SlideFields::MobileImagePreview => FileHelper::getSlidePath($slide),
			];
		}
		throw new PrestaShopObjectNotFoundException('Object not found');
	}

	/**
	 * Get default form data.
	 *
	 * @return mixed
	 */
	public function getDefaultData(): array
	{
		return [];
	}
}
