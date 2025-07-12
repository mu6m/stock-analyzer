@extends('layouts.app')

@section('title', $news->title . ' - ' . $stock->company_name)

@section('content')
    <!-- Stock Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $stock->company_name }}</h1>
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
                <a href="{{ route('stocks.news', $stock) }}" class="text-green-600 hover:text-green-700 font-medium">
                    ← العودة للأخبار
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-lg shadow-sm mb-8">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <a href="{{ route('stocks.show', $stock) }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    نظرة عامة
                </a>
                <a href="{{ route('stocks.dividends', $stock) }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    الأرباح ({{ $stock->dividends->count() }})
                </a>
                <a href="{{ route('stocks.news', $stock) }}" class="border-b-2 border-green-500 py-4 px-1 text-sm font-medium text-green-600" aria-current="page">
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
        </div>
    </div>

    <!-- News Article -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-8">
            <!-- Article Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>
                <div class="flex items-center text-sm text-gray-500">
                    <span>{{ $news->creation_date?->format('Y-m-d H:i') ?? 'غير محدد' }}</span>
                </div>
            </div>

            <!-- Article Content -->
            <div class="prose prose-lg max-w-none">
                <div class="whitespace-pre-wrap text-gray-700 leading-relaxed">
                    {{ $news->description }}
                </div>
            </div>

            <!-- Article Footer -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">تاريخ النشر:</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $news->creation_date?->format('Y-m-d H:i') ?? 'غير محدد' }}
                        </span>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('stocks.news', $stock) }}" 
                           class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                            عرض جميع الأخبار
                        </a>
                        <a href="{{ route('stocks.show', $stock) }}" 
                           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 text-sm">
                            العودة للسهم
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related News -->
    @if($stock->news->where('id', '!=', $news->id)->count() > 0)
        <div class="bg-white rounded-lg shadow-sm mt-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">أخبار ذات صلة</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($stock->news->where('id', '!=', $news->id)->take(3) as $relatedNews)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">
                                <a href="{{ route('stocks.news.show', [$stock, $relatedNews]) }}" 
                                   class="hover:text-green-600">
                                    {{ Str::limit($relatedNews->title, 80) }}
                                </a>
                            </h4>
                            <p class="text-sm text-gray-600 mb-2">
                                {{ Str::limit($relatedNews->description, 120) }}
                            </p>
                            <div class="flex items-center justify-between">
                                <a href="{{ route('stocks.news.show', [$stock, $relatedNews]) }}" 
                                   class="text-green-600 hover:text-green-700 text-sm font-medium">
                                    قراءة المزيد
                                </a>
                                <span class="text-xs text-gray-500">
                                    {{ $relatedNews->creation_date?->format('Y-m-d') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection