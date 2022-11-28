<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('stylesheet','com_dpusers/dpusers/views/user/grouped.min.css', ['relative' => true, 'version' => JDEBUG ? false : 'auto']);
?>
<div class="com-dpusers-user" itemscope itemtype="https://schema.org/Person">
    <?php echo $this->loadTemplate('heading'); ?>
    <?php echo $this->loadTemplate('actions'); ?>
    <?php echo $this->loadTemplate('title'); ?>
    <?php echo $this->loadTemplate('fields'); ?>
</div>
