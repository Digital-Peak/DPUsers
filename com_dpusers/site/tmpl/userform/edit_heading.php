<?php
/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

defined('_JEXEC') or die;

if (!$this->params->get('show_page_heading')) {
    return;
}
?>
<div class="com-dpusers-userform__heading">
    <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
</div>
