<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Form;

use PrestaShopBundle\Form\Admin\Type\ImagePreviewType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class SlideFormType extends TranslatorAwareType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add(SlideFields::Title, TextType::class, [
        'label' => $this->trans('Slide title', 'Modules.Mk_ResponsiveSlider.Admin'),
        'help' => $this->trans('This will be visible as a title on the slide', 'Modules.Mk_ResponsiveSlider.Admin'),
        'required' => true,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::SubTitle, TextType::class, [
        'label' => $this->trans('Slide sub title', 'Modules.Mk_ResponsiveSlider.Admin'),
        'help' => $this->trans('This will be visible next to a title on the slide, a bit smaller', 'Modules.Mk_ResponsiveSlider.Admin'),
        'required' => false,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::OrderValue, IntegerType::class, [
        'label' => $this->trans('Priority on a slider', 'Modules.Mk_ResponsiveSlider.Admin'),
        'help' => $this->trans('This is used to order slides on a slider', 'Modules.Mk_ResponsiveSlider.Admin'),
        'required' => true,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::DesktopImage, FileType::class, [
        'label' => $this->trans('Slide title', 'Modules.Mk_ResponsiveSlider.Admin'),
        'help' => $this->trans('This will be visible as a title on the slide', 'Modules.Mk_ResponsiveSlider.Admin'),
        'required' => true,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::DesktopImagePreview, ImagePreviewType::class, [
        'required' => false,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::MobileImage, FileType::class, [
        'label' => $this->trans('Slide title', 'Modules.Mk_ResponsiveSlider.Admin'),
        'help' => $this->trans('This will be visible as a title on the slide', 'Modules.Mk_ResponsiveSlider.Admin'),
        'required' => true,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::MobileImagePreview, ImagePreviewType::class, [
        'required' => false,
        'attr' => [
          'material_design' => true,
        ],
      ]);
  }
}
