@extends('layouts.app')

@section('title', 'أخبار ' . $stock->company_name)

@section('content')
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('stocks.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    الأسهم
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('stocks.show', $stock) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                        {{ $stock->company_name }}
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('stocks.news', $stock) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                        الأخبار
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">تفاصيل الخبر</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Stock Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $stock->company_name }}</h1>
                <p class="text-md text-gray-600 mt-1">{{ $stock->stock_id }}</p>
                <div class="flex items-center gap-4 mt-3">
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $stock->market_type == 'TASI' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                        {{ $stock->market_type }}
                    </span>
                    <span class="text-sm text-gray-500">{{ $stock->sector }}</span>
                </div>
            </div>
            <div class="text-right">
                <a href="{{ route('stocks.news', $stock) }}" class="text-green-600 hover:text-green-700 font-medium">
                    ← العودة للأخبار
                </a>
            </div>
        </div>
    </div>

    <!-- News Content -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">تفاصيل الخبر</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        تاريخ النشر: {{ $news->creation_date?->format('Y-m-d H:i') ?? 'غير محدد' }}
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="window.print()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        طباعة
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6">
            <article class="prose prose-lg max-w-none">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ $news->title }}</h1>
                
                <div class="text-gray-700 leading-relaxed">
                    {!! nl2br(e($news->description)) !!}
                </div>
            </article>
        </div>

        <!-- News Meta Information -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex items-center justify-between text-sm text-gray-600">
                <div>
                    <span class="font-medium">الشركة:</span>
                    <a href="{{ route('stocks.show', $stock) }}" class="text-green-600 hover:text-green-700 font-medium">
                        {{ $stock->company_name }}
                    </a>
                </div>
                <div>
                    <span class="font-medium">رمز السهم:</span>
                    <span class="font-mono">{{ $stock->stock_id }}</span>
                </div>
                <div>
                    <span class="font-medium">السوق:</span>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $stock->market_type == 'TASI' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                        {{ $stock->market_type }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Related News -->
    @if($stock->news->where('id', '!=', $news->id)->count() > 0)
        <div class="bg-white rounded-lg shadow-sm mt-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">أخبار أخرى لنفس الشركة</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($stock->news->where('id', '!=', $news->id)->take(5) as $relatedNews)
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                            </div>
                            <div class="flex-1">
                                <a href="{{ route('stocks.news.show', [$stock, $relatedNews]) }}" 
                                   class="block text-gray-900 hover:text-green-600">
                                    <h4 class="font-medium">{{ Str::limit($relatedNews->description, 100) }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $relatedNews->creation_date?->format('Y-m-d') ?? 'غير محدد' }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection