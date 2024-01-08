<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Form;

use PrestaShopBundle\Form\Admin\Type\ImagePreviewType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use PrestaShopBundle\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
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
      ->add(SlideFields::TextVisible, SwitchType::class, [
        'label' => $this->trans('Should slide contain text on it?', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('If disabled both Title and Description will not be shown on a slide', 'Modules.Mkresponsiveslider.Admin'),
        'required' => false,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::LinkUrl, UrlType::class, [
        'label' => $this->trans('Slide url', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('If the slide should be a link - this will be the url', 'Modules.Mkresponsiveslider.Admin'),
        'required' => false,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::DesktopImageUrl, UrlType::class, [
        'label' => $this->trans('Url to the desktop version slide image', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('Used on desktop screens', 'Modules.Mkresponsiveslider.Admin'),
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::DesktopImageUpload, FileType::class, [
        'label' => $this->trans('Upload desktop slide image', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('It will override the desktop image url, advised size: 3840x1620', 'Modules.Mkresponsiveslider.Admin'),
        'required' => false,
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::DesktopImagePreview, ImagePreviewType::class, [
        'label' => false,
        'form_theme' => '@Modules/mk_responsiveslider/views/templates/admin/preview.html.twig',
      ])
      ->add(SlideFields::MobileImageUrl, UrlType::class, [
        'label' => $this->trans('Url to the mobile version slide image', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('Used on mobile screens', 'Modules.Mkresponsiveslider.Admin'),
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::MobileImageUpload, FileType::class, [
        'label' => $this->trans('Mobile view image', 'Modules.Mkresponsiveslider.Admin'),
        'help' => $this->trans('Used on mobile screens, advised size 768x960', 'Modules.Mkresponsiveslider.Admin'),
        'required' => false,
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
