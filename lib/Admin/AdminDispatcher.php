<?php

namespace WHMCS\Module\Addon\Arvancdn\Admin;

use Smarty;

/**
 * Admin Area Dispatch Handler
 */
class AdminDispatcher
{

    /**
     * Dispatch request.
     *
     * @param string $method
     * @param array $vars
     *
     * @return string
     */
    public function dispatch(string $method, array $vars)
    {
        $namespace = "WHMCS\\Module\\Addon\\Arvancdn\\Admin\\Controller\\";

        $action = 'index';
        if ($method) {
            $methods = explode('.', $method);

            $class_name = $namespace . ucfirst($methods[0]);
            if(isset($methods[1])) {
                $action = $methods[1];
            }
        } else {
            $class_name = $namespace . 'Dashboard';
        }

        if (class_exists($class_name)) {
            $template = new Smarty();

            $template->assign('resource_link', '/modules/addons/arvancdn/resources/');
            $template->assign('module_link', $vars['modulelink']);
            $template->assign('token', $vars['token']);

            // set language
            $template->assign('__', $vars['_lang']);

            $controller = new $class_name();

            // Verify requested action is valid and callable
            if (is_callable(array($controller, $action))) {
                return $controller->$action($vars, $template);
            } else {
                return '<p>Invalid action requested. Please go back and try again.</p>';
            }
        } else {
            return '<p>Invalid class requested. Please go back and try again.</p>';
        }
    }
}
