<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;
?>
<div class="com-dpusers-user" itemscope itemtype="https://schema.org/Person">
    <?php echo $this->loadTemplate('heading'); ?>
    <?php echo $this->loadTemplate('actions'); ?>
    <?php echo $this->loadTemplate('title'); ?>
    <div class="com-dpusers-user__event-text">
		<?php echo $this->displayEvent->afterDisplayTitle; ?>
	</div>
    <div class="com-dpusers-user__event-text">
		<?php echo $this->displayEvent->beforeDisplayContent; ?>
	</div>
    <div class="com-dpusers-user__event-text">
		<?php echo $this->displayEvent->afterDisplayContent; ?>
	</div>
</div>
