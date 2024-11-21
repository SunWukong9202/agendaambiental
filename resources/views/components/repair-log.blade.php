<div>
    {{-- @livewire(RepairLog::class, ['movement' => $getRecord()]) --}}
    {{-- <livewire:repair-log :movement="$getRecord()"/> --}}
    @livewire('repair-log-list', ['movement' => $getRecord(), 'withBreadcrumb' => false])
</div>