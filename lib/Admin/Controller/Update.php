<?php

namespace WHMCS\Module\Addon\Arvancdn\Admin\Controller;

use WHMCS\Module\Addon\Arvancdn\Response;
use Unirest\Request\Body;
use Unirest\Request;
use ZipArchive;
use Exception;

/**
 * Update Admin Area Controller
 */
class Update extends Controller
{
    /**
     * Index action.
     *
     * @param array $vars
     *
     * @return void
     */
    public function index(array $array): void
    {
        $array = func_get_args();

        // set argument class
        $vars = $array[0];
        $template = $array[1];

        $update = null;

        $check = $this->check($vars['version']);
        if ($check) {
            if ($vars['version'] < $check['tag_name']) {
                $update = $check;
            }
        }

        $template->assign('updates', $update);

        $template->display(ADDON_ARVANCDN_TEMPLATE . 'admin/update/index.tpl');
    }

    /**
     * Upgrade module
     *
     * @param array $array
     *
     * @return void
     */
    public function start(array $array): void
    {
        $array = func_get_args();

        // set argument class
        $vars = $array[0];
        $template = $array[1];

        $json['ok'] = false;

        $check = $this->check($vars['version']);
        if ($check) {
            if ($vars['version'] < $check['tag_name']) {
                $_SESSION['arvan_module_update'] = $check;
                
                $json['ok'] = true;
            }
        } else {
            $json['error'] = 'no upgrade data';
        }

        Response::json($json);
    }

    /**
     * download update file
     *
     * @param array $array
     *
     * @return void
     */
    public function download(array $array): void
    {
        $array = func_get_args();
        
        // set argument class
        $vars = $array[0];
        $template = $array[1];

        $json['ok'] = false;

        $check = $_SESSION['arvan_module_update'];

        if($check) {
            $target = ADDON_ARVANCDN_DIR . DIRECTORY_SEPARATOR . 'download' . DIRECTORY_SEPARATOR . $check['github']['repository'] . '.zip';

            if (!file_exists($target)) {
                try {
                    // download update file
                    $download = file_get_contents($check['download_link']);

                    try {
                        // save file
                        file_put_contents($target, $download);

                        $json['ok'] = true;
                    } catch (Exception $exception) {
                        $json['error'] = 'fail save file "' . $exception->getMessage() . '"';
                    }
                } catch (Exception $exception) {
                    $json['error'] = 'fail download file "' . $exception->getMessage() . '"';
                }
            } else {
                $json['ok'] = true;
            }

            if ($json['ok']) {
                $_SESSION['arvan_module_update']['file'] = $target;
            }
        } else {
            $json['error'] = 'Update file not found';
        }

        Response::json($json);
    }

    /**
     * extract file
     *
     * @param array $array
     *
     * @return void
     */
    public function extract(array $array): void
    {
        $array = func_get_args();

        // set argument class
        $vars = $array[0];
        $template = $array[1];

        $json['ok'] = false;

        $check = $_SESSION['arvan_module_update'];

        if(isset($check['file'])) {
            $file = $check['file'];

            if (file_exists($file)) {
                $zip = new ZipArchive;

                $zip_response = $zip->open($file);
                if ($zip_response === true) {
                    $zip->extractTo(ADDON_ARVANCDN_DIR . DIRECTORY_SEPARATOR);
                    $zip->close();

                    $_SESSION['arvan_module_update']['extract'] = true;

                    $json['ok'] = true;
                } else {
                    $json['error'] = 'can not extract file "' . $file . '"';
                }
            } else {
                $json['error'] = 'file not exists "' . $file . '"';;
            }
        } else {
            $json['error'] = 'download file not found';
        }

        Response::json($json);
    }

    /**
     * finish setup
     *
     * @param array $array
     *
     * @return void
     */
    public function finish(array $array): void
    {
        $array = func_get_args();

        // set argument class
        $vars = $array[0];
        $template = $array[1];

        $json['ok'] = false;

        $check = $_SESSION['arvan_module_update'];

        if(isset($check['extract'])) {
            $json['ok'] = true;
        } else {
            $json['error'] = 'extract file not complete.';
        }

        Response::json($json);
    }

    /**
     * check update function
     *
     * @param string $version
     *
     * @return array|null
     */
    private function check(string $version): ?array
    {
        $github_account = 'arvancloud';
        $github_repository = 'Arvancloud-CDN-integrate-to-WHMCS';

        $url = "https://api.github.com/repos/${github_account}/$github_repository/releases";

        $response = Request::get($url);

        $update = null;
        if ($response->code == 200) {
            if (isset($response->body[0])) {
                if ($version < $response->body[0]->tag_name) {
                    $update['name'] = $response->body[0]->name;
                    $update['tag_name'] = $response->body[0]->tag_name;
                    $update['download_link'] = 'https://github.com/joomla/joomla-cms/archive/refs/tags/' . $response->body[0]->tag_name . '.zip';
                    $update['github']['account'] = $github_account;
                    $update['github']['repository'] = $github_repository;
                }
            }
        }

        return $update;
    }
}
