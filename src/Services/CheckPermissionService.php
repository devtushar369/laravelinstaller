<?php


namespace Hashcode\laravelInstaller\Services;


class CheckPermissionService
{
    public function permissions()
    {
        return [
            ['title' => 'File .env is writable', 'value' => is_writable(base_path('.env'))],
            ['title' => 'Folder /public is writable', 'value' => is_writable(public_path())],
            ['title' => 'Folder /lang is writable', 'value' => is_writable(base_path('lang'))],
            ['title' => 'Folder /storage/framework/ is writable', 'value' => is_writable(storage_path('framework'))],
            ['title' => 'Folder /storage/logs/ is writable', 'value' => is_writable(storage_path('logs'))],
            ['title' => 'Folder /bootstrap/cache/ is writable', 'value' => is_writable(base_path('bootstrap/cache'))],
        ];
    }
}
