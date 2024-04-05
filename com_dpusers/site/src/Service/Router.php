<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\Service;

use DigitalPeak\Component\DPUsers\Site\Service\Router\DPUsersMenuRules;
use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Categories\CategoryFactoryInterface;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Menu\AbstractMenu;
use Joomla\Database\DatabaseInterface;

class Router extends RouterView
{
	public function __construct(SiteApplication $app, AbstractMenu $menu)
	{
		$groups = new RouterViewConfiguration('groups');
		$groups->setKey('groups_ids');
		$this->registerView($groups);

		$user = new RouterViewConfiguration('user');
		$user->setKey('id')->setParent($groups, 'group_id');
		$this->registerView($user);

		$form = new RouterViewConfiguration('userform');
		$form->setKey('id');
		$this->registerView($form);

		parent::__construct($app, $menu);

		$this->attachRule(new DPUsersMenuRules($this));
		$this->attachRule(new StandardRules($this));
		$this->attachRule(new NomenuRules($this));
	}

	public function getGroupsSegment($id, $query): array
	{
		return [(int) $id => $id];
	}

	public function getUserSegment($id, $query): array
	{
		return [(int) $id => $id];
	}

	public function getFormSegment($id, $query): array
	{
		return $this->getUserSegment($id, $query);
	}

	public function getUserId($segment, $query): int
	{
		return (int) $segment;
	}
}
