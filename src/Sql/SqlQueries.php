<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Sql;

class SqlQueries
{
  private const SlideTableName = 'mk_responsive_slide';

  public static function installQueries(): array
  {
    return [
      'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . static::SlideTableName . '` (
        `id_slide` int(11) NOT NULL AUTO_INCREMENT,
        `order_weight` int(11) NOT NULL,
        `desktop_image_name` varchar(64) NOT NULL,
        `mobile_image_name` varchar(64) NOT NULL,
        `title` varchar(128) NOT NULL,
        `sub_title` varchar(128) NULL,
        PRIMARY KEY (`id_slide`)
      ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
    ];
  }
  public static function uninstallQueries(): array
  {
    return [
      'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . static::SlideTableName . '`;',
    ];
  }
}
