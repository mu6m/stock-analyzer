@extends('layouts.app')

@section('title', $stock->company_name . ' - الجلسات')

@section('content')
    <!-- Stock Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $stock->company_name }}</h1>
                <p class="text-lg text-gray-600 mt-1">{{ $stock->stock_id }} - الجلسات</p>
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
        <form method="GET" action="{{ route('stocks.sessions', $stock) }}" class="flex items-center gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="البحث في الجلسات..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                بحث
            </button>
            @if(request('search'))
                <a href="{{ route('stocks.sessions', $stock) }}" class="text-gray-600 hover:text-gray-700 px-4 py-2 border border-gray-300 rounded-lg">
                    مسح
                </a>
            @endif
        </form>
    </div>

    <!-- Sessions List -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">
                الجلسات ({{ $sessions->total() }})
            </h2>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($sessions as $session)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ $session->session_type }}
                                </h3>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $session->no_of_bod }} أعضاء
                                </span>
                            </div>
                            
                            @if($session->requirement)
                                <div class="mb-3">
                                    <span class="font-medium text-gray-700">المتطلبات:</span>
                                    <p class="text-gray-600 mt-1">{{ $session->requirement }}</p>
                                </div>
                            @endif
                            
                            @if($session->submission_method)
                                <div class="mb-3">
                                    <span class="font-medium text-gray-700">طريقة التقديم:</span>
                                    <p class="text-gray-600 mt-1">{{ $session->submission_method }}</p>
                                </div>
                            @endif
                            
                            <!-- Session Dates -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                @if($session->session_start_date || $session->session_end_date)
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <h4 class="font-medium text-gray-700 mb-2">فترة الجلسة</h4>
                                        @if($session->session_start_date)
                                            <p class="text-sm text-gray-600">من: {{ $session->session_start_date->format('Y-m-d') }}</p>
                                        @endif
                                        @if($session->session_end_date)
                                            <p class="text-sm text-gray-600">إلى: {{ $session->session_end_date->format('Y-m-d') }}</p>
                                        @endif
                                    </div>
                                @endif
                                
                                @if($session->app_start_date || $session->app_end_date)
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <h4 class="font-medium text-gray-700 mb-2">فترة التقديم</h4>
                                        @if($session->app_start_date)
                                            <p class="text-sm text-gray-600">من: {{ $session->app_start_date->format('Y-m-d') }}</p>
                                        @endif
                                        @if($session->app_end_date)
                                            <p class="text-sm text-gray-600">إلى: {{ $session->app_end_date->format('Y-m-d') }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>معرف الجلسة: {{ $session->id }}</span>
                                @if($session->created_at)
                                    <span>تم الإنشاء: {{ $session->created_at->format('Y-m-d') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد جلسات</h3>
                    <p class="text-gray-500">لم يتم العثور على جلسات لهذه الشركة.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($sessions->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>
@endsection