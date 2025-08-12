 <nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
         <div class="flex justify-between h-16">
             <!-- Logo and Brand Name -->
             <div class="flex items-center">
                 <a href="/" class="flex-shrink-0 flex items-center space-x-2">
                     <span class="text-3xl caveat-brush text-indigo-600">
                         {{ config('app.name', 'DomiCert') }}
                     </span>
                 </a>
             </div>

             <!-- Desktop Navigation Links -->
             <div class="hidden sm:flex sm:items-center">
                 <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                     Accueil
                 </x-nav-link>

                 @auth
                     @can('viewAny', App\Models\Habitant::class)
                         <x-nav-link :href="route('habitants.index')" :active="request()->routeIs('habitants.*')">
                             Habitants
                         </x-nav-link>
                     @else
                         <x-nav-link :href="route('habitants.create')" :active="request()->routeIs('habitants.*')">
                             Habitants
                         </x-nav-link>
                     @endcan

                     <x-dropdown-nav-menu :active="request()->routeIs('certificats.*')">
                         Demandes
                         <x-slot name="dropdown">
                             @can('viewAny', App\Models\Certificat::class)
                                 <a href="{{ route('certificats.index') }}"
                                     class="block px-4 py-2 text-blue-700 font-medium hover:bg-gray-100">
                                     Demandes
                                 </a>
                             @endcan
                             @can('create', App\Models\Certificat::class)
                                 <a href="{{ route('certificats.create') }}"
                                     class="block px-4 py-2 text-blue-700 font-medium hover:bg-gray-100">Nouvelle demande</a>
                             @endcan
                         </x-slot>
                     </x-dropdown-nav-menu>

                     @if (Auth::user()->is_admin)
                         <x-nav-link :href="route('quartiers.index')" :active="request()->routeIs('quartiers.*')">
                             Quartiers
                         </x-nav-link>
                         <x-nav-link :href="route('maisons.index')" :active="request()->routeIs('maisons.*')">
                             Maisons
                         </x-nav-link>
                         <x-nav-link :href="route('proprietaires.index')" :active="request()->routeIs('proprietaires.*')">
                             Proprietaires
                         </x-nav-link>
                     @endif
                 @else
                     <x-nav-link :href="route('habitants.create')" :active="request()->routeIs('habitants.*')">
                         Habitants
                     </x-nav-link>
                     <x-nav-link :href="route('certificats.create')" :active="request()->routeIs('certificats.*')">
                         Demandes
                     </x-nav-link>

                 @endauth

             </div>

             <!-- Right side buttons (Login/User) -->
             @auth
                 <!-- Settings Dropdown -->
                 <div class="hidden sm:flex sm:items-center sm:ms-6">
                     <x-dropdown align="right" width="48">
                         <x-slot name="trigger">
                             <button
                                 class="inline-flex items-center px-4 py-3 border border-transparent text-sm leading-4 font-medium rounded-sm text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                 <div>{{ Auth::user()->name }}</div>

                                 <div class="ms-2">
                                     <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                         <path fill-rule="evenodd"
                                             d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                             clip-rule="evenodd" />
                                     </svg>
                                 </div>
                             </button>
                         </x-slot>

                         <x-slot name="content">
                             <x-dropdown-link :href="route('profile.edit')">
                                 {{ __('Profile') }}
                             </x-dropdown-link>

                             <!-- Authentication -->
                             <form method="POST" action="{{ route('logout') }}">
                                 @csrf

                                 <x-dropdown-link :href="route('logout')"
                                     onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                     {{ __('Log Out') }}
                                 </x-dropdown-link>
                             </form>
                         </x-slot>
                     </x-dropdown>
                 </div>
             @endauth
             @guest
                 <div class="hidden sm:flex sm:items-center">
                     <a href="{{ route('login') }}"
                         class="px-4 py-2 font-semibold text-sm text-indigo-600 bg-indigo-50 rounded-full hover:bg-indigo-100 transition-colors duration-200">
                         Se connecter
                     </a>
                 </div>
             @endguest

             <!-- Mobile Menu Button -->
             <div class="flex items-center sm:hidden">
                 <button @click="open = !open" type="button"
                     class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                     <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                         <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                             stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M4 6h16M4 12h16M4 18h16" />
                         <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                             stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                     </svg>
                 </button>
             </div>
         </div>
     </div>

     <!-- Mobile Menu -->
     <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
         <div class="pt-2 pb-3 space-y-1">
             <a :href="route('dashboard')"
                 class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 bg-gray-50 border-l-4 border-indigo-500">
                 Accueil
             </a>
             <a :href="route('certificats.create')"
                 class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 border-l-4 border-transparent hover:border-gray-300">
                 Demandes
             </a>
         </div>
         @guest
             <div class="pt-4 pb-3 border-t border-gray-200">
                 <div class="px-4">
                     <a href="{{ route('login') }}"
                         class="block text-base font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">
                         Se connecter
                     </a>
                 </div>
             </div>
         @endguest


     </div>
 </nav>
