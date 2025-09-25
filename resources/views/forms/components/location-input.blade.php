<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div wire:ignore
        x-ignore
        x-load
        x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('location-form-field', 'damarev/filament-location-field') }}"
        x-data="locationFormField({
            location: $wire.$entangle('{{ $getStatePath() }}'),
            config: {{ $getMapConfig() }}
        })">

        <div x-ref="mapTools" class="mb-2 flex gap-2 items-center">
            <div class="fi-input-wrp grow">
                <input x-ref="searchInput" x-on:keydown.enter="handleSearchSubmit" type="text" class="fi-input" placeholder="@lang('filament-location-field::location-field.search_address')">
            </div>
            <x-filament::button x-show="config.sourceAddress" x-on:click="handleGeoAddress" size="sm" color="gray" icon="heroicon-o-map-pin" title="{{ $getSourceAddress() }}"></x-filament::button>
        </div>

        <div x-ref="map" class="fi-input-wrp" style="min-height: 30vh; height: {{ $getHeight() }}; z-index: 1;"></div>
    </div>
</x-dynamic-component>
