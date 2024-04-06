<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

$class = '';
if (is_numeric($this->currentField)) {
	$class = ' ' . $this->currentUser->jcfields[$this->currentField]->params->get('value_render_class', '');
}
?>
<span class="dp-field__value<?php echo $class ?>">
	<?php if (!is_numeric($this->currentField)) { ?>
		<?php echo $this->currentUser->{$this->currentField}; ?>
	<?php } else { ?>
		<?php echo  $this->currentUser->jcfields[$this->currentField]->value; ?>
	<?php } ?>
</span>
