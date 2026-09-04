@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'text-sm font-medium text-health-700 bg-health-50 border border-health-200 rounded-lg px-3 py-2']) }}>
        {{ $status }}
    </div>
@endif
