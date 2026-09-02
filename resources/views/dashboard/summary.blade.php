<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Summary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @php
                $statusStyles = [
                    'pending' => 'bg-yellow-500',
                    'referred' => 'bg-blue-500',
                    'completed' => 'bg-emerald-600',
                ];
            @endphp

            {{-- Stat cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-emerald-700 shadow-md rounded-xl p-6">
                    <p class="text-sm font-medium text-emerald-100">Total Screenings</p>
                    <p class="mt-2 text-4xl font-bold text-white">{{ $totalScreenings }}</p>
                    <p class="mt-1 text-xs text-emerald-200">{{ $todaysScreenings }} today</p>
                </div>

                <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6">
                    <p class="text-sm font-medium text-gray-500">High Priority</p>
                    <p class="mt-2 text-4xl font-bold text-red-600">{{ $highCount }}</p>
                </div>

                <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6">
                    <p class="text-sm font-medium text-gray-500">Moderate Priority</p>
                    <p class="mt-2 text-4xl font-bold text-yellow-500">{{ $moderateCount }}</p>
                </div>

                <div class="bg-white shadow-md rounded-xl border border-gray-100 p-6">
                    <p class="text-sm font-medium text-gray-500">Low Priority</p>
                    <p class="mt-2 text-4xl font-bold text-emerald-600">{{ $lowCount }}</p>
                </div>
            </div>

            {{-- Recent high-priority cases --}}
            <div class="bg-white shadow-md rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-700">Most Recent High-Priority Cases</h3>
                </div>

                @if ($highPriorityCases->isEmpty())
                    <div class="px-6 py-12 text-center">
                        <p class="text-sm text-gray-500">No high-priority cases yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-50">
                                <tr class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    <th class="px-6 py-3">Patient</th>
                                    <th class="px-6 py-3">Date</th>
                                    <th class="px-6 py-3">Reasons</th>
                                    <th class="px-6 py-3">Referral Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($highPriorityCases as $case)
                                    @php
                                        $referral = $case->referrals->sortByDesc('created_at')->first();
                                    @endphp
                                    <tr class="hover:bg-emerald-50/50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-800">
                                            <a href="{{ route('patients.show', $case->screening->patient) }}" class="hover:text-emerald-700">
                                                {{ $case->screening->patient->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 whitespace-nowrap">{{ $case->screening->created_at->format('M j, Y, g:i A') }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $case->reasons }}</td>
                                        <td class="px-6 py-4">
                                            @if ($referral)
                                                <span class="inline-block {{ $statusStyles[$referral->status] ?? 'bg-gray-400' }} text-white text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full">
                                                    {{ ucfirst($referral->status) }}
                                                </span>
                                            @else
                                                <span class="text-xs font-medium text-gray-400">No referral</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
