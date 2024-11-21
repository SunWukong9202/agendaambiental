<div>
    @if ($withBreadcrumb)
    <div class="flex mb-4">
        <x-filament::breadcrumbs :breadcrumbs="[
            route('admin.events.repairments') => __('ui.pages.Repairment Managment'),
            '' => __('ui.log'),
            ]"
        />
        <x-filament::loading-indicator wire:loading class="inset-y-1/2 text-primary-600 inline-block ml-2 h-5 w-5" />
    </div>
    @endif
        
    {{ $this->repairLogInfoList }}
    
    @if (!$this->hasBeenUnassigned())
        
    @endif
</div>
