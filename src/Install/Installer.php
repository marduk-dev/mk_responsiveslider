<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Install;

use Db;
use Module;
use Shop;
use PrestaShopLogger;
use Marduk\Module\Mk_ResponsiveSlider\Sql\SqlQueries;

class Installer
{
	public function install(Module $module): bool
	{
		if (Shop::isFeatureActive()) {
			Shop::setContext(Shop::CONTEXT_ALL);
		}

		if (!$this->registerHooks($module)) {
			return false;
		}

		if (!$this->installDatabase()) {
			return false;
		}

		return true;
	}

	public function uninstall(): bool
	{
		$this->uninstallDatabase();
    return true;
	}

	private function installDatabase(): bool
	{
		return $this->executeQueries(SqlQueries::installQueries());
	}

	private function uninstallDatabase(): bool
	{
		return $this->executeQueries(SqlQueries::uninstallQueries());
	}

	private function registerHooks(Module $module): bool
	{
		$hooks = [
			'actionFrontControllerSetMedia',
      'displayWrapperTopOnMainPage',
			//'displayHome',
		];

		return (bool) $module->registerHook($hooks);
	}

	private function executeQueries(array $queries): bool
	{
		foreach ($queries as $query) {
			if (!Db::getInstance()->execute($query)) {
        PrestaShopLogger::addLog('Installing Modules.Mkresponsiveslider....query failed: ' . $query);
				return false;
			}
		}

		return true;
	}
}
