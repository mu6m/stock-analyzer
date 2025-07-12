@extends('layouts.app')

@section('title', $stock->company_name . ' - الاجتماعات')

@section('content')
    <!-- Stock Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $stock->company_name }}</h1>
                <p class="text-lg text-gray-600 mt-1">{{ $stock->stock_id }} - الاجتماعات</p>
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
                    ← العودة لصفحة الشركة
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <form method="GET" action="{{ route('stocks.meetings', $stock) }}" class="flex items-center gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="البحث في الاجتماعات..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                بحث
            </button>
            @if(request('search'))
                <a href="{{ route('stocks.meetings', $stock) }}" class="text-gray-600 hover:text-gray-700 px-4 py-2 border border-gray-300 rounded-lg">
                    مسح
                </a>
            @endif
        </form>
    </div>

    <!-- Meetings List -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">
                الاجتماعات ({{ $meetings->total() }})
            </h2>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($meetings as $meeting)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ $meeting->meetingReason ?? 'اجتماع عام' }}
                                </h3>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $meeting->status == 'active' ? 'bg-green-100 text-green-800' : 
                                       ($meeting->status == 'completed' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $meeting->status ?? 'غير محدد' }}
                                </span>
                            </div>
                            
                            @if($meeting->natureOfGenMetng)
                                <p class="text-gray-600 mb-3">
                                    <span class="font-medium">طبيعة الاجتماع:</span> {{ $meeting->natureOfGenMetng }}
                                </p>
                            @endif
                            
                            @if($meeting->holdingSite)
                                <p class="text-gray-600 mb-3">
                                    <span class="font-medium">مكان الانعقاد:</span> {{ $meeting->holdingSite }}
                                </p>
                            @endif
                            
                            <div class="flex items-center gap-6 text-sm text-gray-500">
                                @if($meeting->modifiedDt)
                                    <span>تاريخ التحديث: {{ $meeting->modifiedDt->format('Y-m-d H:i') }}</span>
                                @endif
                                <span>رمز الشركة: {{ $meeting->compSymbolCode }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد اجتماعات</h3>
                    <p class="text-gray-500">لم يتم العثور على اجتماعات لهذه الشركة.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($meetings->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $meetings->links() }}
            </div>
        @endif
    </div>
@endsection