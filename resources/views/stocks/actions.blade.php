@extends('layouts.app')

@section('title', 'إجراءات ' . $stock->company_name . ' - ' . $stock->stock_id)

@section('content')
    <!-- Stock Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">إجراءات {{ $stock->company_name }}</h1>
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
                <a href="{{ route('stocks.show', $stock) }}" class="text-green-600 hover:text-green-700 font-medium">
                    ← العودة للسهم
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <form method="GET" action="{{ route('stocks.actions', $stock) }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="البحث في الإجراءات..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                بحث
            </button>
            @if(request('search'))
                <a href="{{ route('stocks.actions', $stock) }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                    مسح
                </a>
            @endif
        </form>
    </div>

    <!-- Actions List -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                الإجراءات ({{ $actions->total() }})
            </h3>
        </div>

        @if($actions->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($actions as $action)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-gray-900 mb-3">
                                    {{ $action->issueTypeDesc }}
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                            <span class="text-sm text-green-600 font-medium">رأس المال الجديد</span>
                                            <span class="text-lg font-bold text-green-700">
                                                {{ number_format($action->newCApital, 0) }} ريال
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <span class="text-sm text-gray-600 font-medium">رأس المال السابق</span>
                                            <span class="text-lg font-bold text-gray-700">
                                                {{ number_format($action->prevCApital, 0) }} ريال
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        @if($action->newCApital != $action->prevCApital)
                                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                                <span class="text-sm text-blue-600 font-medium">نسبة التغيير</span>
                                                <span class="text-lg font-bold {{ $action->newCApital > $action->prevCApital ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $action->prevCApital > 0 ? number_format((($action->newCApital - $action->prevCApital) / $action->prevCApital) * 100, 1) . '%' : 'N/A' }}
                                                </span>
                                            </div>
                                        @endif
                                        
                                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                            <span class="text-sm text-yellow-600 font-medium">الفرق</span>
                                            <span class="text-lg font-bold {{ $action->newCApital > $action->prevCApital ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $action->newCApital > $action->prevCApital ? '+' : '' }}{{ number_format($action->newCApital - $action->prevCApital, 0) }} ريال
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center gap-4">
                                @if($action->announceDate)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        تاريخ الإعلان: {{ $action->announceDate->format('Y-m-d') }}
                                    </span>
                                @endif
                                
                                @if($action->dueDate)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        تاريخ الاستحقاق: {{ $action->dueDate->format('Y-m-d') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $actions->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">لا توجد إجراءات</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request('search'))
                        لا توجد إجراءات تطابق معايير البحث.
                    @else
                        لا توجد إجراءات مسجلة لهذا السهم.
                    @endif
                </p>
            </div>
        @endif
    </div>
@endsection