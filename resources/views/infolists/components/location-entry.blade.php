<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div x-load x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('styles', 'damarev/filament-location-field'))]" x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('location-infolist-entry', 'damarev/filament-location-field') }}" wire:ignore x-data="locationInfolistEntry({
        location: @js($getState()),
        config: {{ $getMapConfig() }},
    })" x-ignore>
        <div x-ref="map" class="rounded-md border border-gray-300 overflow-hidden" style="height: {{ $getHeight() }}"></div>
    </div>
</x-dynamic-component>
