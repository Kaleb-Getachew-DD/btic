@props([
    'name' => 'icon',
    'value' => 'fa-rocket',
    'label' => 'Icon',
])

@php
    $icons = config('icons', []);
    $selected = old($name, $value) ?: 'fa-rocket';
    $selected = preg_replace('/^(fas|far|fab)\s+/', '', trim($selected));
    if ($selected && ! str_starts_with($selected, 'fa-')) {
        $selected = 'fa-' . ltrim($selected, 'fa-');
    }
@endphp

<div class="icon-picker" data-icon-picker>
    <label class="form-label" for="{{ $name }}_display">{{ $label }}</label>

    <div class="icon-picker-toolbar">
        <div class="icon-picker-preview" data-icon-preview>
            <i class="fas {{ $selected }}"></i>
        </div>
        <div class="icon-picker-toolbar-fields">
            <input
                type="text"
                id="{{ $name }}_display"
                name="{{ $name }}"
                class="form-control icon-picker-input"
                value="{{ $selected }}"
                placeholder="fa-rocket"
                autocomplete="off"
                data-icon-input
            >
            <button type="button" class="btn btn-secondary btn-sm icon-picker-toggle" data-icon-picker-toggle>
                <i class="fas fa-icons"></i> Browse icons
            </button>
        </div>
    </div>

    <div class="icon-picker-panel" data-icon-picker-panel hidden>
        <input
            type="search"
            class="form-control icon-picker-search"
            placeholder="Search icons (e.g. rocket, money, team)..."
            data-icon-search
            autocomplete="off"
        >
        <div class="icon-picker-grid" data-icon-grid>
            @foreach($icons as [$icon, $iconLabel])
                <button
                    type="button"
                    class="icon-picker-option {{ $selected === $icon ? 'is-selected' : '' }}"
                    data-icon="{{ $icon }}"
                    data-label="{{ strtolower($iconLabel) }} {{ str_replace('fa-', '', $icon) }}"
                    title="{{ $iconLabel }}"
                >
                    <i class="fas {{ $icon }}"></i>
                    <span>{{ $iconLabel }}</span>
                </button>
            @endforeach
        </div>
        <p class="icon-picker-hint">
            Click an icon to select it. You can also type any
            <a href="https://fontawesome.com/search?o=r&m=free&f=classic&s=solid" target="_blank" rel="noopener">Font Awesome</a>
            class (e.g. <code>fa-rocket</code>).
        </p>
    </div>
</div>
