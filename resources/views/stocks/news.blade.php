@extends('layouts.app')

@section('title', 'أخبار ' . $stock->company_name)

@section('content')
    <!-- Stock Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">أخبار {{ $stock->company_name }}</h1>
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
        <form method="GET" action="{{ route('stocks.news', $stock) }}">
            <div class="flex gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="البحث في الأخبار..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    البحث
                </button>
                @if(request('search'))
                    <a href="{{ route('stocks.news', $stock) }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        إلغاء
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- News List -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">
                الأخبار ({{ $news->total() }})
                @if(request('search'))
                    - نتائج البحث عن "{{ request('search') }}"
                @endif
            </h2>
        </div>
        
        @if($news->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($news as $item)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">
                                    <a href="{{ route('stocks.news.show', [$stock, $item]) }}" class="hover:text-green-600">
                                        {{ $item->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-3 line-clamp-3">
                                    {{ Str::limit($item->description, 200) }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('stocks.news.show', [$stock, $item]) }}" class="text-green-600 hover:text-green-700 font-medium">
                                        قراءة المزيد ←
                                    </a>
                                    <span class="text-sm text-gray-500">
                                        {{ $item->creation_date?->format('Y-m-d H:i') ?? 'غير محدد' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $news->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <p class="mt-2 text-gray-500">
                    @if(request('search'))
                        لا توجد أخبار تطابق البحث
                    @else
                        لا توجد أخبار لهذا السهم
                    @endif
                </p>
            </div>
        @endif
    </div>
@endsection