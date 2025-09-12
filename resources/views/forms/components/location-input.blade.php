<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-load x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('styles', 'damarev/filament-location-field'))]" x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('location-form-field', 'damarev/filament-location-field') }}" wire:ignore x-data="locationFormField({
        location: $wire.$entangle('{{ $getStatePath() }}'),
        config: {{ $getMapConfig() }},
    })" x-ignore>

        <div x-ref="mapTools" class="mb-2 flex gap-2 items-center">
            <div class="fi-input-wrp">
                <input x-ref="inputSearch" type="text" class="fi-input min-w-80" placeholder="@lang('filament-location-field::location-field.search_by_address')...">
            </div>
            <button x-ref="btnGeoaddress" type="button" class="btn-geoaddress" title="@lang('filament-location-field::location-field.geolocate_address'): {{ $getSourceAddress() }}">
                <span class="sr-only">@lang('filament-location-field::location-field.geolocate_address'): {{ $getSourceAddress() }}</span>
            </button>
        </div>

        <div x-ref="map" class="fi-input-wrp" style="min-height: 30vh; height: {{ $getHeight() }}; z-index: 1;"></div>
    </div>
</x-dynamic-component>
