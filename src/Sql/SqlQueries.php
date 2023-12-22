<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Sql;

class SqlQueries
{
  private const SlideTableName = 'mk_responsive_slide';
  private const SlideLangTableName = 'mk_responsive_slide_language';

  public static function installQueries(): array
  {
    return [
      'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . static::SlideTableName . '` (
        `id_slide` int(11) NOT NULL AUTO_INCREMENT,
        `is_enabled` bit(1) not null default(1),
        `position` smallint NOT NULL,
        `title` varchar(128) NOT NULL,
        `description` varchar(128) NULL,
        `url` varchar(128) NULL,
        `desktop_image_name` varchar(64) NOT NULL,
        `mobile_image_name` varchar(64) NOT NULL,
        PRIMARY KEY (`id_slide`)
      ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
      'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . static::SlideLangTableName . '` (
        `id_slide` int(11) NOT NULL,
        `language_id` smallint NOT NULL,
        `is_enabled` bit(1) NULL,
        `title` varchar(128) NULL,
        `sub_title` varchar(128) NULL,
        `url` varchar(128) NULL,
        `desktop_image_name` varchar(64) NULL,
        `mobile_image_name` varchar(64) NULL,
        PRIMARY KEY (`id_slide`, `language_id`),
        FOREIGN KEY (`id_slide`) REFERENCES `' . _DB_PREFIX_ . static::SlideTableName . '` (`id_slide`) ON DELETE CASCADE
      ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;',
    ];
  }
  public static function uninstallQueries(): array
  {
    return [
      'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . static::SlideLangTableName . '`;',
      'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . static::SlideTableName . '`;',
    ];
  }
}
