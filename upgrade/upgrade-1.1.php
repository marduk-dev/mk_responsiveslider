<?php
/**
 * File: /upgrade/upgrade-1.1.php
 */
declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
  exit;
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
  require_once $autoloadPath;
}

use Marduk\Module\Mk_ResponsiveSlider\Install\Installer;

function upgrade_module_1_1($module) {
    // Process Module upgrade to 1.1
    $installer = new Installer();

    return $installer->upgrade_1_1();
}