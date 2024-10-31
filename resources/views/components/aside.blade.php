

  <aside 
    {{ $attributes }}

    class="fixed top-0 left-0 z-50 lg:z-40 bottom-0 transition-transform  lg:translate-x-0 w-full lg:w-80 flex " 
    x-data="{ open: false, from: null }"
    x-cloak
    x-ref="sidebar"
    x-bind:class="open || '-translate-x-full'"
    x-on:open-sidebar.window="open = true; from = $event.detail" 
    >
        <div 
        x-on:click.outside="from == 'sidebar-btn' ? from = null : open = false"
        class="w-80 flex flex-col bg-white lg:bg-transparent">
            <div class="overflow-x-clip">
                <header class="fi-sidebar-header flex h-16 lg:h-20 items-center px-6 ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div>
                            <div class="fi-logo flex">
                                <a :href="route('admin.dashboard')">
                                    <span
                                    class="text-wrap text-start font-black transition-all duration-200">
                                    UASLP <br>
                                        <span class="ml-4 heading-secondary">
                                            Agenda Ambiental
                                        </span>
                                    </span>
                                </a>
                            </div>
                        </a>
                    </div>
                </header>
            </div>
            <div class="px-6 py-8 overflow-y-auto flex-1" x-data custom-scrollbar x-transition>
                <ul class="-mx-2 flex flex-col gap-y-7 ">
                    {{ $slot }}
                </ul>
            </div>
        </div>
        <div class="flex-1 bg-black/85">
            
        </div>
  </aside>































{{-- 

  

  <aside 
    {{ $attributes }}

    class="fixed flex flex-col top-0 left-0 z-50 w-80 bottom-0 transition-transform bg-white lg:bg-transparent lg:translate-x-0" 
    x-data="{ open: false, from: null }"
    x-ref="sidebar"
    x-bind:class="open || '-translate-x-full'"
    x-on:click.outside="from == 'sidebar-btn' ? from = null : open = false"
    x-on:open-sidebar.window="open = true; from = $event.detail" 
    >
        
        <div class="overflow-x-clip">
            <header class="fi-sidebar-header flex h-16 lg:h-20 items-center px-6 ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div>
                        <div class="fi-logo flex">
                            <a :href="route('admin.dashboard')">
                                <span
                                class="text-wrap text-start font-black transition-all duration-200">
                                UASLP <br>
                                    <span class="ml-4 heading-secondary">
                                        Agenda Ambiental
                                    </span>
                                </span>
                            </a>
                        </div>
                    </a>
                </div>
            </header>
        </div>
        <div class="px-6 py-8 overflow-y-auto flex-1" x-data custom-scrollbar x-transition>
            <ul class="-mx-2 flex flex-col gap-y-7 ">
                {{ $slot }}
            </ul>
        </div>
  </aside> --}}