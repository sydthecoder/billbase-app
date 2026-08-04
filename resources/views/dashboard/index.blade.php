<x-layouts.app title="Dashboard">

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-500">Revenue (This Month)</span>
                <x-lucide-trending-up class="w-5 h-5 text-green-500" />
            </div>
            <div class="text-2xl font-semibold text-gray-800">R 45,230</div>
            <div class="text-xs text-green-600 mt-1">+12.4% vs last month</div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-500">Outstanding</span>
                <x-lucide-clock class="w-5 h-5 text-orange-500" />
            </div>
            <div class="text-2xl font-semibold text-gray-800">R 12,450</div>
            <div class="text-xs text-gray-500 mt-1">8 unpaid invoices</div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-500">Active Customers</span>
                <x-lucide-users class="w-5 h-5 text-primary-500" />
            </div>
            <div class="text-2xl font-semibold text-gray-800">87</div>
            <div class="text-xs text-green-600 mt-1">+5 this month</div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-500">Quote Conversion</span>
                <x-lucide-file-signature class="w-5 h-5 text-purple-500" />
            </div>
            <div class="text-2xl font-semibold text-gray-800">68%</div>
            <div class="text-xs text-gray-500 mt-1">17 of 25 quotes</div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Revenue Trend</h3>
            <div id="revenueChart"></div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Invoice Status</h3>
            <div id="invoiceStatusChart"></div>
        </div>
    </div>

    {{-- Recent invoices --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="px-5 py-4 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-700">Recent Invoices</h3>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b border-gray-100">
                    <th class="px-5 py-3 font-medium">Invoice #</th>
                    <th class="px-5 py-3 font-medium">Customer</th>
                    <th class="px-5 py-3 font-medium">Amount</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ([
                    ['no' => 'INV-1042', 'customer' => 'Thabo Electrical', 'amount' => 'R 3,200', 'status' => 'Paid', 'date' => '02 Aug 2026'],
                    ['no' => 'INV-1041', 'customer' => 'Sibanye Plumbing', 'amount' => 'R 1,850', 'status' => 'Pending', 'date' => '01 Aug 2026'],
                    ['no' => 'INV-1040', 'customer' => 'Ndlovu Logistics', 'amount' => 'R 6,400', 'status' => 'Overdue', 'date' => '28 Jul 2026'],
                    ['no' => 'INV-1039', 'customer' => 'Botha Consulting', 'amount' => 'R 2,100', 'status' => 'Paid', 'date' => '27 Jul 2026'],
                    ['no' => 'INV-1038', 'customer' => 'Mokoena Design Studio', 'amount' => 'R 980', 'status' => 'Draft', 'date' => '25 Jul 2026'],
                ] as $invoice)
                    <tr class="border-b border-gray-50 last:border-0">
                        <td class="px-5 py-3 font-medium text-gray-700">{{ $invoice['no'] }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $invoice['customer'] }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ $invoice['amount'] }}</td>
                        <td class="px-5 py-3">
                            @php
                                $badgeClass = match ($invoice['status']) {
                                    'Paid' => 'bg-green-100 text-green-700',
                                    'Pending' => 'bg-orange-100 text-orange-700',
                                    'Overdue' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                {{ $invoice['status'] }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-500">{{ $invoice['date'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // FAKE DEMO DATA — replace with real controller data later
                new ApexCharts(document.querySelector("#revenueChart"), {
                    chart: { type: 'area', height: 280, toolbar: { show: false } },
                    series: [{
                        name: 'Revenue',
                        data: [12000, 15400, 11200, 18900, 22100, 19800, 24500, 21300, 27800, 25600, 30200, 45230]
                    }],
                    xaxis: {
                        categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
                    },
                    colors: ['#5727e7'],
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 2 },
                    fill: {
                        type: 'gradient',
                        gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05 }
                    },
                    yaxis: {
                        labels: { formatter: (val) => 'R ' + val.toLocaleString() }
                    }
                }).render();

                new ApexCharts(document.querySelector("#invoiceStatusChart"), {
                    chart: { type: 'donut', height: 280 },
                    series: [18, 8, 3, 2],
                    labels: ['Paid', 'Pending', 'Overdue', 'Draft'],
                    colors: ['#22c55e', '#f97316', '#ef4444', '#9ca3af'],
                    legend: { position: 'bottom' },
                    dataLabels: { enabled: false }
                }).render();
            });
        </script>
    @endpush

</x-layouts.app>