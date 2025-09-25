<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div wire:ignore
        x-ignore
        x-load
        x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('location-infolist-entry', 'damarev/filament-location-field') }}"
        x-data="locationInfolistEntry({
            location: @js($getState()),
            config: {{ $getMapConfig() }},
        })">
        <div x-ref="map" class="rounded-md border border-gray-300 overflow-hidden" style="height: {{ $getHeight() }}"></div>
    </div>
</x-dynamic-component>
