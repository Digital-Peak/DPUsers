<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('stylesheet','com_dpusers/dpusers/views/groups/default.min.css', ['relative' => true, 'version' => JDEBUG ? false : 'auto']);
HTMLHelper::_('script','com_dpusers/dpusers/views/groups/default.min.js', ['relative' => true, 'version' => JDEBUG ? false : 'auto']);
?>
<div class="com-dpusers-groups">
    <?php echo $this->loadTemplate('heading'); ?>
    <?php echo $this->loadTemplate('form'); ?>
    <?php echo $this->loadTemplate('actions'); ?>
    <?php echo $this->loadTemplate('users'); ?>
    <?php echo $this->loadTemplate('pagination'); ?>
</div>
