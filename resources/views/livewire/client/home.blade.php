@php
    $Permission = \App\Enums\Permission::class;
    $Role = \App\Enums\Role::class;
    $CMUser = \App\Models\CMUser::find(auth()->user()->id);
@endphp

<div>
 
    @if (!isset($action))
        <x-carousel class="max-w-5xl mx-auto">
            <!-- Slide 1 -->
            <div class="duration-700 ease-in-out" x-show="current === 0" x-cloak>
                <img src="{{ asset('images/petitions.jpg') }}" class="absolute block w-full h-full object-cover" alt="Slide 1">
                <div class="absolute top-0 left-0 bottom-0 w-full bg-black bg-opacity-50 text-white px-14 md:px-24 flex flex-col items-center justify-center text-center gap-2 sm:gap-4 md:gap-8 text-base">
                    <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl">
                        {{ __('ui.cta.item-p-title') }}
                    </h3>
                    <p class="hidden lg:block text-lg">
                        {{ __('ui.cta.item-petition') }}
                    </p>

                    <x-filament::button
                        href="{{ route('home', ['action' => 'item-petition']) }}"
                        tag="a" wire:navigate
                    >
                        {{ __('ui.cta.Make petition') }}
                    </x-filament::button>
                </div>
            </div>
        
            <!-- Slide 2 -->
            <div class="duration-700 ease-in-out" x-show="current === 1" x-cloak>
                <img src="{{ asset('images/reactivos.jpg') }}" class="absolute block w-full h-full object-cover" alt="Slide 2">
                <div class="absolute top-0 left-0 bottom-0 w-full bg-black bg-opacity-50 text-white px-14 md:px-24 flex flex-col items-center justify-center text-center gap-2 sm:gap-4 md:gap-8 text-base">
                    <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl">
                        {{ __('ui.cta.reagent-title') }}
                    </h3>
                    <p class="hidden lg:block text-lg">
                        {{ __('ui.cta.reagent-donation') }}
                    </p>

                    <x-filament::button
                        href="{{ route('home', ['action' => 'reagent-donation']) }}"
                        tag="a" wire:navigate
                    >
                        {{ __('ui.cta.Make donation') }}
                    </x-filament::button>
                </div>
            </div>
        
            <div class="duration-700 ease-in-out" x-show="current === 2" x-cloak>
                <img src="{{ asset('images/reagent_petition.jpg') }}" class="absolute block w-full h-full object-cover" alt="Slide 2">
                <div class="absolute top-0 left-0 bottom-0 w-full bg-black bg-opacity-50 text-white px-14 md:px-24 flex flex-col items-center justify-center text-center gap-2 sm:gap-4 md:gap-8 text-base">
                    <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl">
                        {{ __('ui.cta.reagent-p-title') }}
                    </h3>
                    <p class="hidden lg:block text-lg">
                        {{ __('ui.cta.reagent-petition') }}
                    </p>

                    <x-filament::button
                        href="{{ route('home', ['action' => 'reagent-petition']) }}"
                        tag="a" wire:navigate
                    >
                        {{ __('ui.cta.Make petition') }}
                    </x-filament::button>
                </div>
            </div>
        
        </x-carousel>

        {{-- <div>
            <x-filament::tabs>
                <x-filament::tabs.item
                    class="shrink-0"
                    :active="$activeTab === 'tab1'"
                    wire:click="$set('activeTab', 'tab1')"
                >
                    Reagent petitions
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    class="shrink-0"
                    :active="$activeTab === 'tab2'"
                    wire:click="$set('activeTab', 'tab2')"
                >
                    Reagent donations
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    class="shrink-0"
                    :active="$activeTab === 'tab3'"
                    wire:click="$set('activeTab', 'tab3')"
                >
                    Item petitions
                </x-filament::tabs.item>
            </x-filament::tabs>

            <div class="mt-2">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore expedita sapiente amet eligendi, doloremque est a dicta quisquam tempore velit atque perferendis quibusdam corporis natus. Similique mollitia placeat explicabo neque.
            </div>
        </div> --}}
    @else
        
        <div class="max-w-5xl mx-auto">
            <div class="flex mb-4">
                <x-filament::breadcrumbs :breadcrumbs="[
                    route('home') => __('ui.pages.Home'),
                    '' => __('ui.pages.' . ucfirst(str_replace('-', ' ', $action))),
                    ]"
                    wire:navigate
                />
                
            </div>
        @if ($action == 'item-petition')
            <form wire:submit="itemPetition" class="flex flex-col gap-4">
                {{ $this->form }}

                <x-filament::button icon="heroicon-m-paper-airplane" 
                    icon-position="after"
                    class="flex self-end"
                    type="submit"
                >
                    <x-filament::loading-indicator wire:loading
                    wire:target="itemPetition"
                    class="inset-y-1/2 inline-block mr-2 h-5 w-5" />
                    {{ __('Send') }}
                </x-filament::button>
            </form>
        @endif
        
        @if ($action == 'reagent-petition')
            <form wire:submit="reagentPetition" class="flex flex-col gap-4">
                {{ $this->petitionForm }}

                <x-filament::button icon="heroicon-m-paper-airplane" 
                    icon-position="after"
                    class="flex self-end"
                    type="submit"
                >
                    <x-filament::loading-indicator wire:loading
                    wire:target="reagentPetition"
                    class="inset-y-1/2 inline-block mr-2 h-5 w-5" />
                    {{ __('Send') }}
                </x-filament::button>
            </form>
        @endif

        @if ($action == 'reagent-donation')
            <form wire:submit="reagentDonation" class="flex flex-col gap-4">
                {{ $this->donationForm }}
            </form>
        @endif
        </div>
    @endif
</div>
