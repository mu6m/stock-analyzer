@extends('layouts.app')

@section('title', $stock->company_name . ' - ' . $stock->stock_id)

@section('content')
    <!-- Stock Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $stock->company_name }}</h1>
                <p class="text-lg text-gray-600 mt-1">{{ $stock->stock_id }}</p>
                <div class="flex items-center gap-4 mt-3">
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $stock->market_type == 'TASI' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                        {{ $stock->market_type }}
                    </span>
                    <span class="text-sm text-gray-500">{{ $stock->sector }}</span>
                </div>
            </div>
            <div class="text-right">
                <a href="{{ route('stocks.index') }}" class="text-green-600 hover:text-green-700 font-medium">
                    ← العودة للقائمة
                </a>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">الرسم البياني للسعر</h3>
        <div id="stock-chart-container" style="height: 400px; min-width: 310px"></div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-lg shadow-sm mb-8">
        <div class="border-b border-gray-200">
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-8 px-6" aria-label="Tabs">
                <a href="#overview" class="border-b-2 border-green-500 py-4 px-1 text-sm font-medium text-green-600" aria-current="page">
                    نظرة عامة
                </a>
                <a href="{{ route('stocks.dividends', $stock) }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    توزيعات الأرباح ({{ $stock->dividends->count() }})
                </a>
                <a href="{{ route('stocks.news', $stock) }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    الأخبار ({{ $stock->news->count() }})
                </a>
                <a href="{{ route('stocks.actions', $stock) }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    الإجراءات ({{ $stock->actions->count() }})
                </a>
                <a href="{{ route('stocks.meetings', $stock) }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    الاجتماعات ({{ $stock->meetings->count() }})
                </a>
                <a href="{{ route('stocks.sessions', $stock) }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    الجلسات ({{ $stock->sessions->count() }})
                </a>
            </nav>
            
            <!-- Mobile Navigation -->
            <nav class="md:hidden px-4 py-2" aria-label="Tabs">
                <div class="flex overflow-x-auto space-x-4 scrollbar-hide">
                    <a href="#overview" class="border-b-2 border-green-500 py-2 px-3 text-sm font-medium text-green-600 whitespace-nowrap flex-shrink-0" aria-current="page">
                        نظرة عامة
                    </a>
                    <a href="{{ route('stocks.dividends', $stock) }}" class="border-b-2 border-transparent py-2 px-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap flex-shrink-0">
                        توزيعات الأرباح ({{ $stock->dividends->count() }})
                    </a>
                    <a href="{{ route('stocks.news', $stock) }}" class="border-b-2 border-transparent py-2 px-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap flex-shrink-0">
                        الأخبار ({{ $stock->news->count() }})
                    </a>
                    <a href="{{ route('stocks.actions', $stock) }}" class="border-b-2 border-transparent py-2 px-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap flex-shrink-0">
                        الإجراءات ({{ $stock->actions->count() }})
                    </a>
                    <a href="{{ route('stocks.meetings', $stock) }}" class="border-b-2 border-transparent py-2 px-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap flex-shrink-0">
                        الاجتماعات ({{ $stock->meetings->count() }})
                    </a>
                    <a href="{{ route('stocks.sessions', $stock) }}" class="border-b-2 border-transparent py-2 px-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap flex-shrink-0">
                        الجلسات ({{ $stock->sessions->count() }})
                    </a>
                </div>
            </nav>
        </div>
    </div>

    <!-- Overview Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Dividends -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">توزيعات الأرباح الأخيرة</h3>
                <a href="{{ route('stocks.dividends', $stock) }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    عرض الكل
                </a>
            </div>
            <div class="p-6">
                @if($recentDividends->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentDividends as $dividend)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ number_format($dividend->amount, 2) }} ريال</p>
                                    <p class="text-sm text-gray-500">{{ $dividend->distribution_way ?? 'غير محدد' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">{{ $dividend->announce_date?->format('Y-m-d') ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">لا توجد توزيعات أرباح مسجلة</p>
                @endif
            </div>
        </div>

        <!-- Recent News -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">الأخبار الأخيرة</h3>
                <a href="{{ route('stocks.news', $stock) }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    عرض الكل
                </a>
            </div>
            <div class="p-6">
                @if($recentNews->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentNews as $news)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">{{ Str::limit($news->title, 80) }}</h4>
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($news->description, 120) }}</p>
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('stocks.news.show', [$stock, $news]) }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                        قراءة المزيد
                                    </a>
                                    <span class="text-xs text-gray-500">{{ $news->creation_date?->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">لا توجد أخبار</p>
                @endif
            </div>
        </div>

        <!-- Recent Actions -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">الإجراءات الأخيرة</h3>
                <a href="{{ route('stocks.actions', $stock) }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    عرض الكل
                </a>
            </div>
            <div class="p-6">
                @if($recentActions->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentActions as $action)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">{{ $action->issueTypeDesc }}</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-500">رأس المال الجديد:</span>
                                        <span class="font-medium">{{ number_format($action->newCApital, 2) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">رأس المال السابق:</span>
                                        <span class="font-medium">{{ number_format($action->prevCApital, 2) }}</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">{{ $action->announceDate?->format('Y-m-d') }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">لا توجد إجراءات</p>
                @endif
            </div>
        </div>

        <!-- Recent Meetings -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">الاجتماعات الأخيرة</h3>
                <a href="{{ route('stocks.meetings', $stock) }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    عرض الكل
                </a>
            </div>
            <div class="p-6">
                @if($recentMeetings->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentMeetings as $meeting)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">{{ $meeting->meetingReason ?? 'اجتماع' }}</h4>
                                <p class="text-sm text-gray-600 mb-2">{{ $meeting->holdingSite ?? 'غير محدد' }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $meeting->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $meeting->status ?? 'غير محدد' }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $meeting->modifiedDt?->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">لا توجد اجتماعات</p>
                @endif
            </div>
        </div>

        <!-- Recent Sessions -->
                <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">الجلسات الأخيرة</h3>
                <a href="{{ route('stocks.sessions', $stock) }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    عرض الكل
                </a>
            </div>
            <div class="p-6">
                @if($recentSessions->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentSessions as $session)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $session->session_type }}</h4>
                                    <span class="text-xs text-gray-500">{{ $session->session_start_date?->format('Y-m-d') }}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-500">تاريخ نهاية الجلسة</span>
                                        <span class="font-medium">{{ $session->session_end_date?->format('Y-m-d') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">الحجم:</span>
                                        <span class="font-medium">{{ number_format($session->no_of_bod ?? 0) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">لا توجد جلسات</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Custom CSS for mobile scrolling -->
    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
@endsection

@push('scripts')
{{-- Make sure you have @stack('scripts') in your main app.blade.php layout file before the closing </body> tag --}}
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
<script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the price history from the Blade template
        const priceHistory = @json($stock->price_history ?? []);
        // Check if there is data to display
        if (priceHistory && priceHistory.length > 0) {
            // Format the data for Highcharts: array of [timestamp, price]
            // The data must be sorted by date in ascending order for Highstock
            const chartData = priceHistory
                .map(item => [new Date(item.dateTime).getTime(), item.indexPrice])
                .sort((a, b) => a[0] - b[0]); // Sort by timestamp

            // Create the stock chart
            Highcharts.stockChart('stock-chart-container', {
                
                chart: {
                    style: {
                        fontFamily: 'inherit' // Use the same font as the page for consistency
                    },
                    alignTicks: false
                },

                // Disable credits
                credits: {
                    enabled: false
                },

                // Configure the range selector with Arabic labels
                rangeSelector: {
                    inputEnabled: false, // Disable date input boxes for a cleaner look
                    buttons: [{
                        type: 'day',
                        count: 5,
                        text: '5 أيام'
                    }, {
                        type: 'week',
                        count: 1,
                        text: 'أسبوع'
                    }, {
                        type: 'month',
                        count: 1,
                        text: 'شهر'
                    }, {
                        type: 'month',
                        count: 3,
                        text: '3 أشهر'
                    }, {
                        type: 'all',
                        text: 'الكل'
                    }],
                    selected: 4, // Set 'All' as the default selected range
                    buttonTheme: {
                        width: 50
                    },
                },

                // Set the chart title
                title: {
                    text: `تاريخ سعر سهم {{ $stock->company_name }}`
                },

                // Configure the Y-axis (price)
                yAxis: {
                    title: {
                        text: 'السعر (ريال)'
                    },
                    opposite: true, // Move Y-axis to the right for RTL layout
                },

                // Configure the X-axis (date)
                xAxis: {
                    reversed: false // Time should always flow left-to-right
                },

                // Configure the tooltip
                tooltip: {
                    valueDecimals: 2,
                    valueSuffix: ' ريال'
                },

                // Define the data series
                series: [{
                    name: 'سعر الإغلاق',
                    data: chartData,
                    type: 'area', // Use an area chart for better visualization
                    threshold: null,
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    }
                }]
            });
        } else {
            // Display a message if no historical data is available
            document.getElementById('stock-chart-container').innerHTML = '<p class="text-gray-500 text-center py-8">لا توجد بيانات تاريخية للأسعار لعرض الرسم البياني.</p>';
        }
    });
</script>
@endpush
