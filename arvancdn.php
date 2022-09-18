<?php
/**
 * WHMCS SDK Arvan CDN Addon Module
 *
 * Arvan CDN Addon module for WHMCS
 */

use Illuminate\Database\Capsule\Manager as Capsule;
use WHMCS\Module\Addon\Arvancdn\Admin\AdminDispatcher;

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
        'version' => '1.1',
        'fields' => [
            'token' => [
                'FriendlyName' => 'Token',
                'Type' => 'text',
                'Size' => '150',
                'Default' => '',
                'Description' => 'Arvan Cloud API Token',
            ],
            'ns1' => [
                'FriendlyName' => 'NS1',
                'Type' => 'text',
                'Size' => '150',
                'Default' => '',
                'Description' => 'Arvan NS1',
            ],
            'ns2' => [
                'FriendlyName' => 'NS2',
                'Type' => 'text',
                'Size' => '150',
                'Default' => '',
                'Description' => 'Arvan NS2',
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

    if ($currentlyInstalledVersion < 1.1) {
        if (!Capsule::schema()->hasTable('arvancdn_domains')) {
            Capsule::schema()->create('arvancdn_domains', function ($table) {
                $table->bigIncrements('id');

                $table->unsignedBigInteger('user_id')->index();
                $table->string('domain')->index();

                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
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
 * @throws SmartyException
 */
function arvancdn_sidebar($vars)
{
    $template = new Smarty();

    $template->assign('resource_link', '/modules/addons/arvancdn/resources/');
    $template->assign('module_link', $vars['modulelink']);

    // set language
    $template->assign('__', $vars['_lang']);

    return $template->fetch(ADDON_ARVANCDN_TEMPLATE . 'admin/common/sidebar.tpl');
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
