<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die();

class Pkg_DPCalendarInstallerScript extends \Joomla\CMS\Installer\InstallerScript
{
	protected $minimumPhp      = '7.4.0';
	protected $minimumJoomla   = '4.1.0';
	protected $allowDowngrades = true;

	public function preflight($type, $parent)
	{
		return parent::preflight($type, $parent);
	}

	public function postflight($type, $parent)
	{
	}
}
