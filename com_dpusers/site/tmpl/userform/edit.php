<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');
?>
<div class="com-dpusers-userform">
	<?php echo $this->loadTemplate('heading'); ?>

	<form action="<?php echo Route::_('index.php?option=com_dpusers&id=' . (int) $this->form->getValue('id')); ?>" method="post"
		name="adminForm" id="adminForm" class="form-validate form-vertical">
	    <?php echo $this->loadTemplate('fields'); ?>
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="return" value="<?php echo $this->returnPage; ?>"/>
		<?php echo HTMLHelper::_('form.token'); ?>

	    <?php echo $this->loadTemplate('actions'); ?>
	</form>
</div>
