<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    @livewireStyles

    <script>
        {{-- if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
       
        } --}}
            document.documentElement.classList.remove('dark')
    </script>

</head>

<body
    class="font-sans antialiased scroll-smooth overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700 dark:[&::-webkit-scrollbar-thumb]:bg-slate-500">

    <x-notifications />
    <x-dialog />

    <livewire:scripts />


    <script>
        window.setup = () => {
            return {
                toggleColorTheme() {

                    if (localStorage.getItem('color-theme')) {
                        if (localStorage.getItem('color-theme') === 'light') {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('color-theme', 'dark');
                            window.dispatchEvent(new CustomEvent("color-theme", { theme: 'dark' }))
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('color-theme', 'light');
                            window.dispatchEvent(new CustomEvent("color-theme", { theme: 'light' }))
                        }
                    } else {

                        if (document.documentElement.classList.contains('dark')) {
                            document.documentElement.classList.remove('dark');
                            localStorage.setItem('color-theme', 'light');
                            window.dispatchEvent(new CustomEvent("color-theme", { theme: 'light' }))

                        } else {
                            document.documentElement.classList.add('dark');
                            localStorage.setItem('color-theme', 'dark');
                            window.dispatchEvent(new CustomEvent("color-theme", { theme: 'dark' }))
                        }
                    }
                },
                loading: true,
                isSidebarOpen: true,
                toggleSidbarMenu() {

                    this.isSidebarOpen = !this.isSidebarOpen
                },
                isSettingsPanelOpen: false,
                isSearchBoxOpen: false,
            }
        }
    </script>
    {{ $js ?? null }}
    @if ($errors->has('general'))
        <script>
            window.$wireui.notify({
                title: '{{ $errors->get('general.title') }}',
                description: '{{ $errors->get('general.message') }}',
                icon: 'error'
            })
        </script>
    @endif

    <wireui:scripts />
    {{-- @livewireScripts --}}
    @stack('modals')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
        (function() {
            window.addEventListener('load', () => {
                const $clipboards = document.querySelectorAll('.js-clipboard');
                $clipboards.forEach((el) => {
                    const isToggleTooltip = HSStaticMethods.getClassProperty(el,
                        '--is-toggle-tooltip') === 'false' ? false : true;
                    const clipboard = new ClipboardJS(el, {
                        text: (trigger) => {
                            const clipboardText = trigger.dataset.clipboardText;

                            if (clipboardText) return clipboardText;

                            const clipboardTarget = trigger.dataset.clipboardTarget;
                            const $element = document.querySelector(clipboardTarget);

                            if (
                                $element.tagName === 'SELECT' ||
                                $element.tagName === 'INPUT' ||
                                $element.tagName === 'TEXTAREA'
                            ) return $element.value
                            else return $element.textContent;
                        }
                    });
                    clipboard.on('success', () => {
                        const $default = el.querySelector('.js-clipboard-default');
                        const $success = el.querySelector('.js-clipboard-success');
                        const $successText = el.querySelector('.js-clipboard-success-text');
                        const successText = el.dataset.clipboardSuccessText || '';
                        const tooltip = el.closest('.hs-tooltip');
                        const $tooltip = HSTooltip.getInstance(tooltip, true);
                        let oldSuccessText;

                        if ($successText) {
                            oldSuccessText = $successText.textContent
                            $successText.textContent = successText
                        }
                        if ($default && $success) {
                            $default.style.display = 'none'
                            $success.style.display = 'block'
                        }
                        if (tooltip && isToggleTooltip) HSTooltip.show(tooltip);
                        if (tooltip && !isToggleTooltip) $tooltip.element.popperInstance
                        .update();

                        setTimeout(function() {
                            if ($successText && oldSuccessText) $successText
                                .textContent = oldSuccessText;
                            if (tooltip && isToggleTooltip) HSTooltip.hide(tooltip);
                            if (tooltip && !isToggleTooltip) $tooltip.element
                                .popperInstance.update();
                            if ($default && $success) {
                                $success.style.display = '';
                                $default.style.display = '';
                            }
                        }, 800);
                    });
                });
            })
        })()
    </script>
    <main>
        {{ $slot }}
    </main>
    @stack('custom-scripts')
    {{--  @include('popper::assets') --}}
</body>

</html>
