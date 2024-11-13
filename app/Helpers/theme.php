<?php
if (!function_exists('setPageTitle')) {
    function setPageTitle($title): void
    {
        app()->instance('pageTitle', $title);
    }
}

if (!function_exists('getPageTitle')) {
    function getPageTitle(): string
    {
        return app()->has('pageTitle') ? app('pageTitle') : 'CRM';
    }
}
