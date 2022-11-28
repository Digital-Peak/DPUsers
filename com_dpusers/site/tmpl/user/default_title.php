<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

$htag = $this->params->get('show_page_heading') ? 'h2' : 'h1';
?>
<div class="com-dpusers-user__title">
    <<?php echo $htag; ?> itemprop="headline">
		<?php echo $this->escape($this->user->name); ?>
	</<?php echo $htag; ?>>
</div>
