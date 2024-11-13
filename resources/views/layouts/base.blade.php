<!--
Product: Metronic is a toolkit of UI components built with Tailwind CSS for developing scalable web applications quickly and efficiently
Version: v9.0.0
Author: Keenthemes
Contact: support@keenthemes.com
Website: https://www.keenthemes.com
Support: https://devs.keenthemes.com
Follow: https://www.twitter.com/keenthemes
License: https://keenthemes.com/metronic/tailwind/docs/getting-started/license
-->
<!doctype html>
<html class="h-full" data-theme="true" data-theme-mode="light" lang="tr">
<head>
    <meta charset="utf-8">
    <title> {{ getPageTitle() }} - Antalya CRM</title>
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    @vite('resources/css/app.scss')
    <script>
        const _systemConfig = {!! json_encode($_config ?? []) !!};
        const _systemData   = {!! json_encode($_data ?? [])  !!};
        const _pageData     = {!! json_encode($_pageData ?? [])  !!};
    </script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css">
</head>

<body class="flex h-full demo1 sidebar-fixed header-fixed bg-[#fefefe] dark:bg-coal-500" style="height: 100% !important;">
    <!--begin::Theme mode setup on page load-->
    <script>
        const defaultThemeMode = 'light'; // light|dark|system
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('theme')) {
                themeMode = localStorage.getItem('theme');
            } else if (document.documentElement.hasAttribute('data-theme-mode')) {
                themeMode = document.documentElement.getAttribute('data-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->


    @yield('main')

    @vite('resources/js/app.js')
    @yield("customJs")


    @include('partials.modals.customer.modal-create')
    @include('partials.modals.customer.modal-edit')

    @include('partials.modals.interview.modal-create')

    @include('partials.modals.task.modal-create')
    @include('partials.search-modal')
</body>

</html>
