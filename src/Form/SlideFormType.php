<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Form;

use PrestaShopBundle\Form\Admin\Type\ImagePreviewType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use PrestaShopBundle\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;

class SlideFormType extends TranslatorAwareType
{
  private SlideDataProvider $dataProvider;
  private TranslatorInterface $translator;

  public function __construct(TranslatorInterface $translator, array $locales, SlideDataProvider $dataProvider)
  {
    parent::__construct($translator, $locales);
    $this->dataProvider = $dataProvider;
    $this->translator = $translator;
  }

  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add(SlideFields::Enabled, SwitchType::class, [
        'label' => $this->trans('Slide enabled', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('If disabled it will not be visible at all', 'Modules.Mkresponsiveslider.Admin'),
        'required' => true,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::Title, TextType::class, [
        'label' => $this->trans('Slide title', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('This will be visible as a title on the slide', 'Modules.Mkresponsiveslider.Admin'),
        'required' => true,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::Description, TextType::class, [
        'label' => $this->trans('Slide description', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('This will be visible next to a title on the slide, a bit smaller', 'Modules.Mkresponsiveslider.Admin'),
        'required' => false,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::DesktopImage, EnumType::class, [
        'class' => SlideImage::class,
        'choice_label' => fn (SlideImage $slideImage): string => $slideImage->getReadable($this->translator),
        'label' => $this->trans('Slide url', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('If the slide should be a link - this is the url', 'Modules.Mkresponsiveslider.Admin'),
        'required' => false,
        'attr' => [
          'material_design' => true,
        ],
      ])
      //->add(SlideFields::Position, HiddenType::class, [])
      ->add(SlideFields::Url, TextType::class, [
        'label' => $this->trans('Slide url', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('If the slide should be a link - this is the url', 'Modules.Mkresponsiveslider.Admin'),
        'required' => false,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::DesktopImage, FileType::class, [
        'label' => $this->trans('Desktop view image', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('Used on desktop screens, advised size: 3840x1620', 'Modules.Mkresponsiveslider.Admin'),
        'required' => is_null($this->dataProvider->slideId),
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::DesktopImagePreview, ImagePreviewType::class, [
        'label' => false,
        'form_theme' => '@Modules/mk_responsiveslider/views/templates/admin/preview.html.twig',
      ])
      ->add(SlideFields::MobileImage, FileType::class, [
        'label' => $this->trans('Mobile view image', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('Used on mobile screens, advised size 768x960', 'Modules.Mkresponsiveslider.Admin'),
        'required' => is_null($this->dataProvider->slideId),
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::MobileImagePreview, ImagePreviewType::class, [
        'label' => false,
        'form_theme' => '@Modules/mk_responsiveslider/views/templates/admin/preview.html.twig',
      ]);
  }
}
