<?php
/**
 * WHMCS SDK Arvan CDN Addon Module
 *
 * Arvan CDN Addon module for WHMCS
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule;
use WHMCS\Module\Addon\Arvancdn\Admin\AdminDispatcher;
use WHMCS\Module\Addon\Arvancdn\Client\ClientDispatcher;
use Exception;

/**
 * Require any libraries needed for the module to function.
 * require_once __DIR__ . '/path/to/library/loader.php';
 *
 * Also, perform any initialization required by the service's library.
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

const ADDON_ARVANCDN_DIR = __DIR__;
const ADDON_ARVANCDN_TEMPLATE = __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;

/**
 * Define addon module configuration parameters.
 *
 * @return array
 */
function arvancdn_config()
{
    return [
        'name' => 'Arvan CDN',
        'description' => 'Arvan CDN Addon module for WHMCS',
        'author' => 'majid mohammadian',
        'language' => 'english',
        'version' => '1.0',
        'fields' => [
            'token' => [
                'FriendlyName' => 'Token',
                'Type' => 'text',
                'Size' => '150',
                'Default' => '',
                'Description' => 'Arvan Cloud API Token',
            ],
        ]
    ];
}

/**
 * Activate.
 *
 * @return array Optional success/failure message
 */
function arvancdn_activate()
{
    try {
        /*Capsule::schema()->create('mod_addonexample', function (Blueprint $table) {
            $table->increments('id');
            $table->text('demo');
        });*/

        return [
            'status' => 'success',
            'description' => 'This is a demo module only. In a real module you might report a success or instruct a user how to get started with it here.',
        ];
    } catch (Exception $e) {
        return [
            'status' => "error",
            'description' => 'Unable to create mod_addonexample: ' . $e->getMessage(),
        ];
    }
}

/**
 * Deactivate.
 *
 * @return array Optional success/failure message
 */
function arvancdn_deactivate()
{
    try {
        Capsule::schema()->dropIfExists('mod_addonexample');

        return [
            'status' => 'success',
            'description' => 'This is a demo module only. In a real module you might report a success here.',
        ];
    } catch (Exception $e) {
        return [
            "status" => "error",
            "description" => "Unable to drop mod_addonexample: {$e->getMessage()}",
        ];
    }
}

/**
 * Upgrade.
 *
 * @return void
 */
function arvancdn_upgrade($vars)
{
    $currentlyInstalledVersion = $vars['version'];

    /*if ($currentlyInstalledVersion < 1.1) {
        Capsule::schema()->table('mod_addonexample', function($table) {
            $table->text('demo2');
        });
    }

    if ($currentlyInstalledVersion < 1.2) {
        Capsule::schema()->table('mod_addonexample', function($table) {
            $table->text('demo3');
        });
    }*/
}

/**
 * Admin Area Output.
 *
 * @return string
 */
function arvancdn_output($vars)
{
    $action = $_REQUEST['action'] ?? '';

    $dispatcher = new AdminDispatcher();
    $response = $dispatcher->dispatch($action, $vars);
    echo $response;
}

/**
 * Admin Area Sidebar Output.
 *
 * Used to render output in the admin area sidebar.
 * This function is optional.
 *
 * @param array $vars
 *
 * @return string
 */
function arvancdn_sidebar($vars)
{
    // Get common module parameters
    $modulelink = $vars['modulelink'];
    $_lang = $vars['_lang'];

    // Get module configuration parameters
    $token = $vars['token'];

    $sidebar = '<p>Sidebar output HTML goes here</p>';
    return $sidebar;
}

/**
 * Client Area Output.
 *
 * Called when the addon module is accessed via the client area.
 * Should return an array of output parameters.
 *
 * This function is optional.
 *
 * @see Arvancdn\Client\Controller::index()
 *
 * @return array
 */
function arvancdn_clientarea($vars)
{
    // Get common module parameters
    $modulelink = $vars['modulelink']; // eg. index.php?m=arvancdn
    $version = $vars['version']; // eg. 1.0
    $_lang = $vars['_lang']; // an array of the currently loaded language variables

    // Get module configuration parameters
    $configTextField = $vars['Text Field Name'];
    $configPasswordField = $vars['Password Field Name'];
    $configCheckboxField = $vars['Checkbox Field Name'];
    $configDropdownField = $vars['Dropdown Field Name'];
    $configRadioField = $vars['Radio Field Name'];
    $configTextareaField = $vars['Textarea Field Name'];

    /**
     * Dispatch and handle request here. What follows is a demonstration of one
     * possible way of handling this using a very basic dispatcher implementation.
     */

//    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

//    $dispatcher = new ClientDispatcher();
//    return $dispatcher->dispatch($action, $vars);
}
