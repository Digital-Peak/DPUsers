<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace DigitalPeak\Component\DPUsers\Site\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\User\User;
use Joomla\CMS\User\UserFactoryInterface;

class UserModel extends ItemModel
{
	/**
	 * @return User
	 */
	public function getItem($pk = null)
	{
		$pk = $pk ?: (int)$this->getState('user.id');
		if (!$pk) {
			return new User();
		}

		return Factory::getContainer()->get(UserFactoryInterface::class)->loadUserById($pk);
	}
}
