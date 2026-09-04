@php
    // Build the breadcrumb trail from the current route.
    // Models come from route-model binding (the layout has no access to page data).
    $trail = [];

    $patient = request()->route('patient');
    $patient = $patient instanceof \App\Models\Patient ? $patient : null;

    $screening = request()->route('screening');
    $screening = $screening instanceof \App\Models\Screening ? $screening : null;

    if (request()->routeIs('dashboard', 'dashboard.summary')) {
        $trail[] = ['label' => __('Dashboard')];
    } elseif (request()->routeIs('patients.index')) {
        $trail[] = ['label' => __('Dashboard'), 'url' => route('dashboard')];
        $trail[] = ['label' => __('Patients')];
    } elseif (request()->routeIs('patients.create')) {
        $trail[] = ['label' => __('Dashboard'), 'url' => route('dashboard')];
        $trail[] = ['label' => __('Patients'), 'url' => route('patients.index')];
        $trail[] = ['label' => __('New Patient')];
    } elseif (request()->routeIs('patients.show') && $patient) {
        $trail[] = ['label' => __('Dashboard'), 'url' => route('dashboard')];
        $trail[] = ['label' => __('Patients'), 'url' => route('patients.index')];
        $trail[] = ['label' => $patient->name];
    } elseif (request()->routeIs('screenings.create') && $patient) {
        $trail[] = ['label' => __('Dashboard'), 'url' => route('dashboard')];
        $trail[] = ['label' => __('Patients'), 'url' => route('patients.index')];
        $trail[] = ['label' => $patient->name, 'url' => route('patients.show', $patient)];
        $trail[] = ['label' => __('New Screening')];
    } elseif (request()->routeIs('screenings.result') && $screening) {
        $resultPatient = $screening->patient;
        $trail[] = ['label' => __('Dashboard'), 'url' => route('dashboard')];
        $trail[] = ['label' => __('Patients'), 'url' => route('patients.index')];
        if ($resultPatient) {
            $trail[] = ['label' => $resultPatient->name, 'url' => route('patients.show', $resultPatient)];
        }
        $trail[] = ['label' => __('Screening Result')];
    } elseif (request()->routeIs('referrals.create') && $patient) {
        $trail[] = ['label' => __('Dashboard'), 'url' => route('dashboard')];
        $trail[] = ['label' => __('Patients'), 'url' => route('patients.index')];
        $trail[] = ['label' => $patient->name, 'url' => route('patients.show', $patient)];
        $trail[] = ['label' => __('Referral')];
    } elseif (request()->routeIs('profile.edit')) {
        $trail[] = ['label' => __('Dashboard'), 'url' => route('dashboard')];
        $trail[] = ['label' => __('My Profile')];
    }
@endphp

@if (! empty($trail))
    <nav aria-label="{{ __('Breadcrumb') }}" class="border-b border-gray-100 bg-white/70">
        <div class="mx-auto flex max-w-7xl items-center gap-1.5 overflow-x-auto px-4 py-2 sm:px-6 lg:px-8">
            @foreach ($trail as $i => $crumb)
                @if ($i > 0)
                    <x-icon name="chevron-right" class="h-3.5 w-3.5 shrink-0 text-brand-600 rtl:rotate-180"/>
                @endif
                @if (! empty($crumb['url']))
                    <a href="{{ $crumb['url'] }}"
                       class="max-w-[12rem] truncate whitespace-nowrap text-xs font-medium text-gray-500 transition-colors duration-150 hover:text-brand-700">
                        {{ $crumb['label'] }}
                    </a>
                @else
                    <span class="max-w-[12rem] truncate whitespace-nowrap text-xs font-semibold text-gray-700" aria-current="page">
                        {{ $crumb['label'] }}
                    </span>
                @endif
            @endforeach
        </div>
    </nav>
@endif
