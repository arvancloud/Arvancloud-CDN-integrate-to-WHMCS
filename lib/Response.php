<?php

namespace WHMCS\Module\Addon\Arvancdn;

use JetBrains\PhpStorm\NoReturn;

/**
 * Response Class
 */
class Response {
    /**
     * response json
     *
     * @param array $json
     *
     * @return void
     */
    public static function json(array $json): void
    {
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($json);
        die;
    }
}
