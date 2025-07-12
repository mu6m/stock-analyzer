@extends('layouts.app')

@section('title', 'أرباح ' . $stock->company_name)

@section('content')
    <!-- Stock Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">أرباح {{ $stock->company_name }}</h1>
                <p class="text-gray-600 mt-1">{{ $stock->stock_id }}</p>
            </div>
            <div class="text-right">
                <a href="{{ route('stocks.show', $stock) }}" class="text-green-600 hover:text-green-700 font-medium">
                    ← العودة لصفحة السهم
                </a>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <form method="GET" action="{{ route('stocks.dividends', $stock) }}">
            <div class="flex gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="البحث في طريقة التوزيع..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    البحث
                </button>
                @if(request('search'))
                    <a href="{{ route('stocks.dividends', $stock) }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        إلغاء
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Dividends Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">
                الأرباح ({{ $dividends->total() }})
                @if(request('search'))
                    - نتائج البحث عن "{{ request('search') }}"
                @endif
            </h2>
        </div>
        
        @if($dividends->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المبلغ</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">طريقة التوزيع</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الإعلان</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الاستحقاق</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ التوزيع</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($dividends as $dividend)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ number_format($dividend->amount, 2) }} ريال
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $dividend->distribution_way ?? 'غير محدد' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $dividend->announce_date?->format('Y-m-d') ?? 'غير محدد' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $dividend->due_date?->format('Y-m-d') ?? 'غير محدد' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $dividend->distribution_date?->format('Y-m-d') ?? 'غير محدد' }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $dividends->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="mt-2 text-gray-500">
                    @if(request('search'))
                        لا توجد أرباح تطابق البحث
                    @else
                        لا توجد أرباح مسجلة لهذا السهم
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- Summary Statistics -->
    @if($dividends->count() > 0)
        <div class="bg-white rounded-lg shadow-sm mt-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">إحصائيات الأرباح</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $dividends->total() }}</div>
                        <div class="text-sm text-gray-500">إجمالي التوزيعات</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">
                            {{ number_format($stock->dividends->sum('amount'), 2) }}
                        </div>
                        <div class="text-sm text-gray-500">إجمالي المبلغ (ريال)</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">
                            {{ number_format($stock->dividends->avg('amount'), 2) }}
                        </div>
                        <div class="text-sm text-gray-500">متوسط الربح (ريال)</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection