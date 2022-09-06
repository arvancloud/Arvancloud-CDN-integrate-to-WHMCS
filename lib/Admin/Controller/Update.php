<?php

namespace WHMCS\Module\Addon\Arvancdn\Admin\Controller;

use WHMCS\Module\Addon\Arvancdn\Response;
use Unirest\Request\Body;
use Unirest\Request;
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
        if($check) {

        }

        $url = 'https://api.github.com/repos/joomla/joomla-cms/releases';

        $response = Request::get($url);

        if ($response->code == 200) {
            if(isset($response->body[0])) {
                if($vars['version'] < $response->body[0]->tag_name) {
                    $update['name'] = $response->body[0]->name;
                    $update['tag_name'] = $response->body[0]->tag_name;
                    $update['download_link'] = 'https://github.com/joomla/joomla-cms/archive/refs/tags/' . $response->body[0]->tag_name . '.zip';
                }
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
    public function upgrade(array $array): void
    {
        $array = func_get_args();
        $vars = $array[0];

        $json['ok'] = false;
        
        $check = $this->check($vars['version']);
        if($check) {
            $target = ADDON_ARVANCDN_DIR . DIRECTORY_SEPARATOR . 'download' . DIRECTORY_SEPARATOR . $check['github']['repository'] . '.zip';

            if(!file_exists($target)) {

            }
        } else {
            $json['error'] = 'no upgrade data';
        }

        Response::json($json);
    }

    /**
     * download update file
     *
     * @param array $check
     *
     * @return array|null
     */
    private function download(array $check)
    {
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
        } catch (Exception $e) {
            $json['error'] = 'fail download file "' . $e->getMessage() . '"';
        }
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
        $github_account = 'joomla';
        $github_repository = 'joomla-cms';

        $url = "https://api.github.com/repos/${github_account}/$github_repository/releases";

        $response = Request::get($url);

        $update = null;
        if ($response->code == 200) {
            if(isset($response->body[0])) {
                if($version < $response->body[0]->tag_name) {
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
