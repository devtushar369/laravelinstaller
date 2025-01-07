<?php


namespace Hashcode\laravelInstaller\Services;


class CheckRequirementService
{
    public function requirement()
    {
       return [
            ['title' => 'PHP version '.config('laravelinstaller.php_version').' (Current Version ' . phpversion() . ')', 'value' => version_compare(phpversion(), config('laravelinstaller.php_version'), '>=')],
            ['title' => 'Fileinfo PHP extension enabled', 'value' => extension_loaded('fileinfo')],
            ['title' => 'Ctype PHP extension enabled', 'value' => extension_loaded('ctype')],
            ['title' => 'OpenSSL PHP extension enabled', 'value' => extension_loaded('openssl')],
            ['title' => 'JSON PHP extension enabled', 'value' => extension_loaded('json')],
            ['title' => 'PDO is installed', 'value' => defined('PDO::ATTR_DRIVER_NAME')],
            ['title' => 'Mbstring PHP extension enabled', 'value' => extension_loaded('mbstring')],
            ['title' => 'Tokenizer PHP extension enabled', 'value' => extension_loaded('tokenizer')],
            ['title' => 'Zip archive PHP extension enabled', 'value' => extension_loaded('zip')],
            ['title' => 'CURL is installed', 'value' => extension_loaded('curl')],
        ];
    }
}
