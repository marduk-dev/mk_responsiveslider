<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Form;

use Marduk\Module\Mk_ResponsiveSlider\Entity\MkResponsiveSlide;
use Marduk\Module\Mk_ResponsiveSlider\Repository\MkResponsiveSlideRepository;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;

class SlideListProvider implements FormDataProviderInterface
{
	private $mkResponsiveSlideRepository;

	public function __construct(MkResponsiveSlideRepository $mkResponsiveSlideRepository)
	{
		$this->mkResponsiveSlideRepository = $mkResponsiveSlideRepository;
	}

    public function getData(): array
    {
        return $this->mkResponsiveSlideRepository->findAll();
    }

    public function setData(array $data): array {
        throw new UndefinedOptionsException();
    }
}
