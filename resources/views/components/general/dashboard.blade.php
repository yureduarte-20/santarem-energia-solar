<div>
    <div class="flex h-screen overflow-y-hidden bg-white dark:bg-gray-800" x-data="setup()"
         x-init="$refs.loading.classList.add('hidden')">
        <!-- Loading screen -->
        <div x-ref="loading"
             class="fixed inset-0 z-50 flex items-center justify-center text-white bg-black bg-opacity-50"
             style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)">
            Carregando.....
        </div>

        <!-- Sidebar backdrop -->
        <div x-show.in.out.opacity="isSidebarOpen" class="fixed inset-0 z-10 bg-black bg-opacity-20 lg:hidden"
             style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)"></div>

        <!-- Sidebar -->
        <aside x-transition:enter="transition transform duration-300"
               x-transition:enter-start="-translate-x-full opacity-30 ease-in"
               x-transition:enter-end="translate-x-0 opacity-100 ease-out"
               x-transition:leave="transition transform duration-300"
               x-transition:leave-start="translate-x-0 opacity-100 ease-out"
               x-transition:leave-end="-translate-x-full opacity-0 ease-in"
               class="fixed inset-y-0 z-10 flex flex-col flex-shrink-0 w-64 max-h-screen overflow-hidden transition-all transform border-r shadow-lg bg-primary dark:bg-primary-900 dark:border-r-gray-700 lg:z-auto lg:static lg:shadow-none"
               :class="{ '-translate-x-full lg:translate-x-0 lg:w-20': !isSidebarOpen }">
            <!-- sidebar header -->
            <div class="flex items-center justify-between flex-shrink-0 p-2"
                 :class="{ 'lg:justify-center': !isSidebarOpen }">
                <span class="p-2 text-xl font-semibold leading-8 tracking-wider uppercase whitespace-nowrap">
                    <img :class="{ 'hidden': isSidebarOpen }" src="{{ asset('assets/logo.png') }}">
                    <img :class="{ 'hidden': !isSidebarOpen }" src="{{ asset('assets/logo_letrado.png') }}">
                </span>
                <button @click="toggleSidbarMenu()"
                        class="p-2 rounded-md lg:hidden dark:text-gray-200 dark:hover:bg-gray-700">
                    <x-icon name="x" class="w-6 h-6"/>
                </button>
            </div>
            <!-- Sidebar links -->
            <nav class="flex-1 overflow-hidden hover:overflow-y-auto">
                <ul class="p-2 overflow-hidden">
                    <li>
                        <a href="{{ route('dashboard') }}"
                           wire:navigate
                           class="flex items-center p-2 space-x-2 text-white rounded-md hover:bg-primary-700 hover:font-bold"
                           :class="{'justify-center': !isSidebarOpen}">
                            <div class="p-2 text-white rounded-full bg-primary-700">
                                <x-icon.dashboard class="w-4 h-4"/>
                            </div>
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cliente.index') }}"
                           wire:navigate
                           class="flex items-center p-2 space-x-2 text-white rounded-md hover:bg-primary-700 hover:font-bold"
                           :class="{'justify-center': !isSidebarOpen}">
                            <div class="p-2 text-white rounded-full bg-primary-700">
                                <x-icon name="user" class="w-4 h-4"/>
                            </div>
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">{{ __('Customers') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('engenheiro.index') }}"
                           wire:navigate
                           class="flex items-center p-2 space-x-2 text-white rounded-md hover:bg-primary-700 hover:font-bold"
                           :class="{'justify-center': !isSidebarOpen}">
                            <div class="p-2 text-white rounded-full bg-primary-700">
                                <x-icon.eng class="w-4 h-4"/>
                            </div>
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">{{ __('Engineers') }}</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Sidebar footer -->
            <div class="flex-shrink-0 p-2 max-h-14">
                <a class="flex items-center justify-center w-full px-4 py-2 space-x-1 font-medium tracking-wider text-red-500 uppercase bg-gray-100 border rounded-md dark:bg-gray-900 dark:border-gray-700 hover:text-red-600 focus:outline-none focus:ring"
                   wire:navigate
                   href="{{ route('logout') }}" title="Sair"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span>
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </span>
                    <span :class="{ 'lg:hidden': !isSidebarOpen }">Sair</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>

        </aside>

        <div class="flex flex-col flex-1 h-full overflow-hidden">
            <!-- Navbar -->
            <header class="flex-shrink-0 border-b dark:border-b-gray-700">
                <div class="flex items-center justify-between p-2">
                    <!-- Navbar left -->
                    <div class="flex items-center space-x-3">

                        <!-- Toggle sidebar button -->
                        <button @popper(ocultar
                        /mostrar menu) @click="toggleSidbarMenu()"
                        class="p-2 transition border border-gray-200 rounded-md dark:hover:bg-gray-500
                        dark:border-gray-500 hover:bg-gray-200 focus:outline-none">
                        <svg class="w-4 h-4 text-gray-600 "
                             :class="{ 'transform transition-transform -rotate-180': isSidebarOpen }"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                        </svg>
                        </button>

                        <strong class="hidden sm:block dark:text-gray-400">


                        </strong>
                    </div>

                    <div class="flex items-center">
                        <div class="block md:hidden">
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <x-button flat icon="menu"/>
                                </x-slot>

                                <x-dropdown.header label="Gerenciar conta">
                                    <x-dropdown.item icon="user" label="Meu perfil"
                                                     href="{{ route('profile.show') }}"/>


                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf
                                        <x-dropdown.item icon="logout" href="{{ route('logout') }}"
                                                         @click.prevent="$root.submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown.item>
                                    </form>
                                </x-dropdown.header>
                            </x-dropdown>
                        </div>

                        <div class="hidden md:flex sm:items-center sm:ms-6">
                            <div class="relative ms-3">
                                <x-dropdown-jetstream align="right" width="48">
                                    <x-slot name="trigger">
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                            <button
                                                class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                                <img class="object-cover w-8 h-8 rounded-full"
                                                     src="{{ Auth::user()->profile_photo_url }}"
                                                     alt="{{ Auth::user()->name }}"/>
                                            </button>
                                        @else
                                            <span class="inline-flex rounded-md">
                                            <button type="button"
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700">


                                                {{ explode(" ",Auth::user()->name)[0] }}


                                                <x-icon name="chevron-down" class="w-4 h-4"/>
                                            </button>
                                        </span>
                                        @endif
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Account') }}
                                        </div>

                                        <x-dropdown-link class="flex" href="{{ route('profile.show') }}">
                                            <x-icon name="user" class="h-4 mr-2"/> {{ __('Profile') }}
                                        </x-dropdown-link>

                                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                            <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                                {{ __('API Tokens') }}
                                            </x-dropdown-link>
                                        @endif

                                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                        <form method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf

                                            <x-dropdown-link class="flex" href="{{ route('logout') }}"
                                                             @click.prevent="$root.submit();">
                                                <x-icon name="logout" class="h-4 mr-2"/> {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown-jetstream>
                            </div>

                        </div>
                    </div>
                    <!-- Navbar right -->
                </div>
            </header>
            <!-- Main content -->
            <main
                class="flex-1 max-h-full p-5 overflow-hidden bg-gray-100 dark:bg-gray-900 antialiased scroll-smooth overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700 dark:[&::-webkit-scrollbar-thumb]:bg-slate-500">
                <!-- Main content header -->
                <div
                    class="flex flex-col items-start justify-between pb-4 space-y-4 border-b dark:border-b-gray-700 lg:items-center lg:space-y-0 lg:flex-row">
                    <div class="flex items-center gap-6">
                        {{-- @if ($back)
                        @endif --}}
                        <a href="{{ url()->previous() }}"
                           class="flex items-center gap-1 p-2 text-sm transition bg-white rounded-md shadow-sm dark:hover:bg-gray-700 dark:text-gray-500 dark:bg-gray-800 hover:bg-gray-100">
                            <x-icon name="arrow-left" class="w-4 h-4"/>
                            Voltar
                        </a>

                        <div class="flex items-center gap-2">
                            {{ $icon ?? null }}
                            <h1 class="text-xl font-semibold md:text-2xl sm:whitespace-nowrap dark:text-gray-400">
                                {{ $title ?? '' }}</h1>
                        </div>
                    </div>
                    {{-- <div class="flex flex-col w-full gap-2 md:w-fit md:flex-row">
                        {{ $buttons ?? null }}
                    </div> --}}
                </div>

                <!-- Start Content -->
                <div class="py-4 ">
                    @if (session()->has('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                             id="dismiss-alert"
                             class="p-4 mb-4 transition duration-300 border border-teal-200 rounded-md hs-removing:translate-x-5 hs-removing:opacity-0 bg-teal-50"
                             role="alert">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-4 w-4 text-teal-400 mt-0.5" xmlns="http://www.w3.org/2000/svg"
                                         width="16"
                                         height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-teal-800">
                                        {{ session('success') }}
                                    </div>
                                </div>
                                <div class="pl-3 ml-auto">
                                    <div class="-mx-1.5 -my-1.5">
                                        <button type="button"
                                                class="inline-flex bg-teal-50 rounded-md p-1.5 text-teal-500 hover:bg-teal-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-teal-50 focus:ring-teal-600"
                                                data-hs-remove-element="#dismiss-alert">
                                            <span class="sr-only">Dismiss</span>
                                            <svg class="w-3 h-3" width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path
                                                    d="M0.92524 0.687069C1.126 0.486219 1.39823 0.373377 1.68209 0.373377C1.96597 0.373377 2.2382 0.486219 2.43894 0.687069L8.10514 6.35813L13.7714 0.687069C13.8701 0.584748 13.9882 0.503105 14.1188 0.446962C14.2494 0.39082 14.3899 0.361248 14.5321 0.360026C14.6742 0.358783 14.8151 0.38589 14.9468 0.439762C15.0782 0.493633 15.1977 0.573197 15.2983 0.673783C15.3987 0.774389 15.4784 0.894026 15.5321 1.02568C15.5859 1.15736 15.6131 1.29845 15.6118 1.44071C15.6105 1.58297 15.5809 1.72357 15.5248 1.85428C15.4688 1.98499 15.3872 2.10324 15.2851 2.20206L9.61883 7.87312L15.2851 13.5441C15.4801 13.7462 15.588 14.0168 15.5854 14.2977C15.5831 14.5787 15.4705 14.8474 15.272 15.046C15.0735 15.2449 14.805 15.3574 14.5244 15.3599C14.2437 15.3623 13.9733 15.2543 13.7714 15.0591L8.10514 9.38812L2.43894 15.0591C2.23704 15.2543 1.96663 15.3623 1.68594 15.3599C1.40526 15.3574 1.13677 15.2449 0.938279 15.046C0.739807 14.8474 0.627232 14.5787 0.624791 14.2977C0.62235 14.0168 0.730236 13.7462 0.92524 13.5441L6.59144 7.87312L0.92524 2.20206C0.724562 2.00115 0.611816 1.72867 0.611816 1.44457C0.611816 1.16047 0.724562 0.887983 0.92524 0.687069Z"
                                                    fill="currentColor"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>

            <!-- Main footer -->
            <footer
                class="flex items-center justify-between flex-shrink-0 p-4 border-t dark:border-t-gray-700 max-h-14">
                <div class="text-xs tracking-tight text-gray-500">
                    Desenvolvido por Yure Samarone
                </div>
                <div>
                    <a href="https://santarem.pa.gov.br/" target="_blank" class="flex items-center">
                        <span class="px-3 text-xs tracking-tight text-gray-500">© {{ now()->format('Y') }} Yure Samarone</span>
                        <img class="hidden object-contain h-10 dark:block"
                             src="{{ asset('assets/logo.png') }}">
                        <img class="block object-contain h-10 dark:hidden" src="{{ asset('assets/logo.png') }}">
                    </a>
                </div>

            </footer>
        </div>
    </div>
</div>
