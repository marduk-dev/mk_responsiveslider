<?php

declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
  exit;
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
  require_once $autoloadPath;
}

use Marduk\Module\Mk_ResponsiveSlider\Install\Installer;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class Mk_ResponsiveSlider extends Module implements WidgetInterface
{
  const templateFile = 'module:mk_responsiveslider/views/templates/hook/slider.tpl';

  public function __construct()
  {
    $this->name = 'mk_responsiveslider';
    $this->tab = 'front_office_features';
    $this->version = '1.1.0';
    $this->author = 'Marduk';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = [
      'min' => '1.8.1.0',
      'max' => '8.99.99',
    ];
    $this->bootstrap = true;

    parent::__construct();

    $this->displayName = $this->trans('Marduk ResponsiveSlider', [], 'Modules.Mkresponsiveslider.Admin');
    $this->description = $this->trans('A slider with support for both a desktop and a mobile views.', [], 'Modules.Mkresponsiveslider.Admin');

    $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], 'Modules.Mkresponsiveslider.Admin');
  }

  public function install()
  {
    $installer = new Installer();

    return parent::install()
      && $installer->install($this);
  }

  public function uninstall()
  {
    $installer = new Installer();

    return $installer->uninstall()
      && parent::uninstall();
  }

  public function getContent()
  {
    $route = $this->get('router')->generate('mk_responsiveslider_index');
    Tools::redirectAdmin($route);
  }

  public function renderWidget($hookName, array $configuration)
  {
    if ($this->shouldClearCache()) {
      $this->clearCache();
    }
    if (!$this->isCached(static::templateFile, $this->getCacheId())) {
      $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
    }

    return $this->fetch(static::templateFile, $this->getCacheId());
  }

  private function shouldClearCache(): bool {
    return true;
  }

  public function getWidgetVariables($hookName, array $configuration)
  {
    $slideView = $this->get('marduk.module.mk_responsiveslider.presentation.slide');

    return [
      'mk_slider' => [
        'slider_id' => 'mk_slider',
        'slides' => $slideView != null ? $slideView->allEnabled() : [],
        'speed' => 3000,
        'pause' => 'hover',
        'wrap' => 'true',
      ],
    ];
  }

  public function isUsingNewTranslationSystem()
  {
    return true;
  }

  public function hookActionFrontControllerSetMedia()
  {
    if (true) {
      $this->context->controller->registerStylesheet(
        $this->name . '-style', 
        'modules/' . $this->name . '/views/css/mk_responsiveslider.css',
        [
          'media' => 'all', 
          'priority' => 150
        ]
      );
    }
  }

  public function clearCache()
  {
      $this->_clearCache(static::templateFile);
  }

}
