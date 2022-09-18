<?php

namespace WHMCS\Module\Addon\Arvancdn\Admin\Controller;

/**
 * Sample Admin Area Controller
 */
class Dashboard {

    /**
     * Dashboard action.
     *
     * @param array $array
     *
     * @return void
     */
    public function index(array $array): void
    {
        $array = func_get_args();

        // set argument class
        $vars = $array[0];
        $template = $array[1];

        $template->display(ADDON_ARVANCDN_TEMPLATE . 'admin/dashboard/index.tpl');
    }
}
