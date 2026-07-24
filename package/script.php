<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

\defined('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\Database\DatabaseAwareInterface;
use Joomla\Database\DatabaseAwareTrait;

return new class () implements InstallerScriptInterface, DatabaseAwareInterface {
	use DatabaseAwareTrait;

	private string $minimumPhp = '8.1.0';

	private string $minimumJoomla = '4.4.0';

	public function install(InstallerAdapter $adapter): bool
	{
		return true;
	}

	public function update(InstallerAdapter $adapter): bool
	{
		$file = $adapter->getParent()->getPath('source') . '/deleted.php';
		if (file_exists($file)) {
			require $file;
		}

		return true;
	}

	public function uninstall(InstallerAdapter $adapter): bool
	{
		return true;
	}

	public function preflight(string $type, InstallerAdapter $adapter): bool
	{
		if (version_compare(PHP_VERSION, $this->minimumPhp, '<')) {
			Log::add(\sprintf(Text::_('JLIB_INSTALLER_MINIMUM_PHP'), $this->minimumPhp), Log::WARNING, 'jerror');

			return false;
		}

		if (version_compare(JVERSION, $this->minimumJoomla, '<')) {
			Log::add(\sprintf(Text::_('JLIB_INSTALLER_MINIMUM_JOOMLA'), $this->minimumJoomla), Log::WARNING, 'jerror');

			return false;
		}

		return true;
	}

	public function postflight(string $type, InstallerAdapter $adapter): bool
	{
		// Make sure the installer plugin is enabled
		$this->run("update `#__extensions` set enabled = 1 where name = 'plg_installer_dpusers'");
		// Ensure DPMedia update sites are enabled
		$this->run("update `#__update_sites` set enabled = 1 where name like '%DPUsers%'");

		return true;
	}

	private function run(string $query): void
	{
		try {
			$db = $this->getDatabase();
			$db->setQuery($query);
			$db->execute();
		} catch (Exception $exception) {
			Factory::getApplication()->enqueueMessage($exception->getMessage(), 'error');
		}
	}
};
