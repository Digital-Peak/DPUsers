/**
 * @package   DPUsers
 * @copyright Copyright (C) 2022 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

document.addEventListener('DOMContentLoaded', () => {
    const search = document.querySelector('.com-dpusers-groups .dp-input-search');
    if (search) {
        search.addEventListener('change', (event) => search.form.submit());
    }

    const clear = document.querySelector('.com-dpusers-groups .dp-button-clear');
    if (clear && search) {
        clear.addEventListener('click', (event) => {
            search.value = '';
            search.form.submit();
        });
    }
});
