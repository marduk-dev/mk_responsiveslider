<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Form;

use PrestaShopBundle\Form\Admin\Type\ImagePreviewType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use PrestaShopBundle\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

// block_name, disabled, label, label_format, label_translation_parameters, attr_translation_parameters, translation_domain, auto_initialize, trim, required, property_path, mapped,
// by_reference, inherit_data, compound, method, action, post_max_size_message, allow_file_upload, help_translation_parameters, error_mapping, invalid_message, invalid_message_parameters,
// allow_extra_fields, extra_fields_message, csrf_protection, csrf_field_name, csrf_message, csrf_token_manager, csrf_token_id, multistore_dropdown, multistore_configuration_key, modify_all_shops,
// block_prefix, row_attr, attr, data_class, empty_data, error_bubbling, label_attr, upload_max_size_message, help, help_attr, help_html, validation_groups, constraints, hint, default_empty_data, empty_view_data,
// external_link, alert_message, alert_type, alert_position, alert_title, label_tag_name, label_subtitle, label_help_box, label_tab, form_theme, use_default_themes, columns_number, column_breaker, disabling_switch,
// disabled_value, disabling_switch_event, switch_state_on_disable

class SlideFormType extends TranslatorAwareType
{
  private SlideDataProvider $dataProvider;

  public function __construct(TranslatorInterface $translator, array $locales, SlideDataProvider $dataProvider) {
    parent::__construct($translator, $locales);
    $this->dataProvider = $dataProvider;
  }

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
        'required' => is_null($this->dataProvider->slideId),
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::DesktopImagePreview, ImagePreviewType::class, [
        'label' => false,
      ])
      ->add(SlideFields::MobileImage, FileType::class, [
        'label' => $this->trans('Slide title', 'Modules.Mk_ResponsiveSlider.Admin'),
        'help' => $this->trans('This will be visible as a title on the slide', 'Modules.Mk_ResponsiveSlider.Admin'),
        'required' => is_null($this->dataProvider->slideId),
        'attr' => [
          'material_design' => true,
        ],
      ])
      ->add(SlideFields::MobileImagePreview, ImagePreviewType::class, [
        'label' => false,
      ]);
  }
}
