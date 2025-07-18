<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'أسهم')</title>
    
    @vite('resources/css/app.css')
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'arabic': ['Tahoma', 'Arial', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Tahoma', Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('stocks.index') }}" class="text-2xl font-bold text-green-600">الأسهم</a>
                </div>
                <nav class="hidden md:flex gap-4">
                    <a href="{{ route('stocks.calculator') }}" class="text-gray-700 hover:text-green-600 font-medium">حاسبة التطهير</a>
                    <a href="{{ route('stocks.index', ['market' => 'TASI']) }}" class="text-gray-700 hover:text-green-600 font-medium">تاسي</a>
                    <a href="{{ route('stocks.index', ['market' => 'NOMU']) }}" class="text-gray-700 hover:text-green-600 font-medium">نمو</a>
                </nav>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-green-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white border-t">
            <div class="px-4 py-3 flex flex-col gap-4">
                <a href="{{ route('stocks.index') }}" class=" text-gray-700 hover:text-green-600">الرئيسية</a>
                <a href="{{ route('stocks.calculator') }}" class="text-gray-700 hover:text-green-600 font-medium">حاسبة التطهير</a>
                <a href="{{ route('stocks.index', ['market' => 'TASI']) }}" class=" text-gray-700 hover:text-green-600">تاسي</a>
                <a href="{{ route('stocks.index', ['market' => 'NOMU']) }}" class=" text-gray-700 hover:text-green-600">نمو</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-600">
                <p>&copy; {{ date('Y') }} الأسهم جميع الحقوق محفوظة.</p>
                <p class="mt-2 text-sm">البيانات لأغراض تعليمية فقط وليست نصائح استثمارية</p>
                <p class="mt-2 text-sm">للتواصل me@ledraa.com</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>