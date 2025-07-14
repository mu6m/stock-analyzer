@extends('layouts.app')

@section('title', 'حاسبة التطهير')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h3 class="text-sm font-medium text-yellow-800">تنويه هام</h3>
        <div class="mt-2 text-sm text-yellow-700">
            <p>جميع قيم التطهير للأسهم في الموقع هي وفقا لقائمة الدراسات الشرعية للدكتور محمد بن سعود العصيمي</p>
        </div>
    </div>

    <!-- Add Stock Form -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-lg font-medium text-gray-900 mb-4">إضافة سهم جديد</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Stock ID Input -->
            <div class="suggestions-container">
                <label for="stock_id" class="block text-sm font-medium text-gray-700 mb-2">رمز السهم</label>
                <input type="text" 
                        id="stock_id" 
                        placeholder="مثال: 2222"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-lg">
                <div id="stock-suggestions" class="suggestions-dropdown hidden"></div>
            </div>

            <!-- Number of Stocks Input -->
            <div>
                <label for="stock_count" class="block text-sm font-medium text-gray-700 mb-2">عدد الأسهم</label>
                <input type="number" 
                        id="stock_count" 
                        min="1"
                        placeholder="أدخل عدد الأسهم"
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-lg">
            </div>

            <!-- Add Button -->
            <div class="flex items-end">
                <button id="add-stock-btn" 
                        class="w-full px-4 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors font-medium">
                    إضافة السهم
                </button>
            </div>
        </div>
    </div>

    <!-- Selected Stocks -->
    <div id="selected-stocks-section" class="bg-white rounded-lg shadow-sm p-6 mb-8 hidden">
        <h2 class="text-lg font-medium text-gray-900 mb-4">الأسهم المختارة</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-right py-3 px-4 font-medium text-gray-700">رمز السهم</th>
                        <th class="text-right py-3 px-4 font-medium text-gray-700">عدد الأسهم</th>
                        <th class="text-right py-3 px-4 font-medium text-gray-700">المعامل</th>
                        <th class="text-right py-3 px-4 font-medium text-gray-700">القيمة</th>
                        <th class="text-right py-3 px-4 font-medium text-gray-700">إجراء</th>
                    </tr>
                </thead>
                <tbody id="selected-stocks-tbody">
                    <!-- Selected stocks will be populated here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Total Results -->
    <div id="total-results-section" class="bg-white rounded-lg shadow-sm p-6 mb-8 hidden">
        <div class="text-center">
            <h2 class="text-lg font-medium text-gray-900 mb-4">الإجمالي</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-blue-600 font-medium">عدد الأسهم الإجمالي</p>
                    <p id="total-stocks-count" class="text-2xl font-bold text-blue-900">0</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm text-green-600 font-medium">عدد الشركات</p>
                    <p id="total-companies-count" class="text-2xl font-bold text-green-900">0</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4">
                    <p class="text-sm text-purple-600 font-medium">القيمة الإجمالية</p>
                    <p id="total-value" class="text-2xl font-bold text-purple-900">0.0000</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Stocks Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">الأسهم المتاحة</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">رمز السهم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المعامل</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">إجراء</th>
                    </tr>
                </thead>
                <tbody id="stocks-table-body" class="bg-white divide-y divide-gray-200">
                    <!-- Table rows will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Stock data
    const stockData = {
        "2222": 0.1083,
        "2030": 0.1188,
        "4030": 0.0345,
        "4200": 0.0624,
        "1202": 0.0167,
        "1301": 0.0271,
        "1304": 0.0092,
        "1320": 0.1296,
        "2001": 0.0089,
        "2020": 0.0342,
        "2090": 0.0142,
        "2150": 0.0526,
        "2170": 0.0778,
        "2180": 0.0259,
        "2210": 0.0123,
        "2220": 0.0169,
        "2223": 0.0647,
        "2250": 0.041,
        "2290": 0.0028,
        "2310": 0.0378,
        "2330": 0.0203,
        "2350": 0.001,
        "3001": 0.006,
        "3002": 0.0019,
        "3003": 0.0086,
        "3004": 0.0063,
        "3005": 0.0052,
        "3007": 0.0082,
        "3020": 0.0225,
        "3030": 0.0153,
        "3040": 0.0221,
        "3060": 0.0094,
        "3080": 0.0413,
        "3090": 0.014,
        "3091": 0.0023,
        "1214": 0.0316,
        "1302": 0.0106,
        "1303": 0.0013,
        "2040": 0.0164,
        "2110": 0.16,
        "2160": 0.1909,
        "2320": 0.0652,
        "2370": 0.0104,
        "4110": 0.0127,
        "4140": 0.0854,
        "4143": 0.0384,
        "1831": 0.074,
        "1832": 0.0088,
        "1834": 0.018,
        "6004": 0.0825,
        "1833": 0.1192,
        "4031": 0.006,
        "4040": 0.0538,
        "4260": 0.009,
        "2130": 0.008,
        "2340": 0.0188,
        "4011": 0.0111,
        "4012": 0.0065,
        "4180": 0.0034,
        "1810": 0.0537,
        "1820": 0.0029,
        "4170": 0.0002,
        "4290": 0.0145,
        "4291": 0.0343,
        "4292": 0.0186,
        "6002": 0.0092,
        "6012": 0.0139,
        "6013": 0.0158,
        "6014": 0.0416,
        "6015": 0.0007,
        "4003": 0.0356,
        "4008": 0.0083,
        "4050": 0.0725,
        "4051": 0.0387,
        "4190": 0.0008,
        "4191": 0.0087,
        "4192": 0.0012,
        "4001": 0.0033,
        "4061": 0.0013,
        "4161": 0.0055,
        "4162": 0.0457,
        "4163": 0.0161,
        "2100": 0.01,
        "2270": 0.0584,
        "2280": 0.013,
        "2281": 0.1175,
        "2282": 0.0113,
        "2283": 0.0692,
        "6010": 0.0227,
        "6020": 0.0181,
        "6040": 0.0052,
        "2230": 0.0025,
        "4002": 0.0052,
        "4004": 0.0847,
        "4007": 0.0176,
        "4013": 0.0312,
        "4014": 0.0103,
        "4015": 0.0827,
        "4016": 0.0146,
        "1182": 0.0063,
        "1183": 0.0153,
        "2120": 0.038,
        "4081": 0.0103,
        "4130": 0.0,
        "4082": 0.0257,
        "7201": 0.0007,
        "7202": 0.0506,
        "7203": 0.0884,
        "7204": 0.0067,
        "7010": 0.0129,
        "7020": 0.0202,
        "7030": 0.0941,
        "7040": 0.2559,
        "2080": 0.0689,
        "2081": 0.0882,
        "2084": 0.0445,
        "4330": 0.0159,
        "4331": 0.0022,
        "4333": 0.0025,
        "4334": 0.0131,
        "4335": 0.0019,
        "4336": 0.0013,
        "4337": 0.0012,
        "4339": 0.001,
        "4340": 0.0008,
        "4342": 0.004,
        "4344": 0.0007,
        "4345": 0.0024,
        "4347": 0.0069,
        "4349": 0.0032,
        "4090": 0.0322,
        "4100": 0.0695,
        "4150": 0.0085,
        "4230": 0.1024,
        "4300": 0.1038,
        "4310": 0.0041,
        "4320": 0.0651,
        "4321": 0.0056,
        "4322": 0.0292,
        "4323": 0.0826,
        "9513": 0.0105,
        "9514": 0.0025,
        "9539": 0.0352,
        "9548": 0.0072,
        "9552": 0.0122,
        "9553": 0.0071,
        "9575": 0.0047,
        "9576": 0.1031,
        "9580": 0.0385,
        "9583": 0.0324,
        "9588": 0.0073,
        "9599": 0.0009,
        "9601": 0.033,
        "9605": 0.0569,
        "9525": 0.0012,
        "9528": 0.0132,
        "9529": 0.0952,
        "9531": 0.0333,
        "9533": 0.006,
        "9542": 0.0002,
        "9547": 0.0385,
        "9569": 0.157,
        "9578": 0.0956,
        "9540": 0.0033,
        "9545": 0.0034,
        "9570": 0.1993,
        "9581": 0.1191,
        "9577": 0.0367,
        "9520": 0.007,
        "9541": 0.0014,
        "9562": 0.0465,
        "9567": 0.0611,
        "9522": 0.1004,
        "9551": 0.0021,
        "9549": 0.0688,
        "9592": 0.026,
        "9515": 0.0414,
        "9532": 0.0184,
        "9536": 0.0837,
        "9556": 0.0081,
        "9559": 0.2607,
        "9564": 0.0172,
        "9517": 0.0897,
        "9518": 0.0022,
        "9527": 0.1239,
        "9574": 0.006,
        "9594": 0.0035,
        "9600": 0.0758,
        "9604": 0.2544,
        "9586": 0.1779,
        "9596": 0.0285,
        "9602": 0.0366,
        "9524": 0.021,
        "9534": 0.0101,
        "9538": 0.0884,
        "9550": 0.1743,
        "9557": 0.141,
        "9558": 0.0125,
        "9561": 0.0206,
        "9595": 0.1415,
        "9300": 0.0038,
        "9519": 0.0015,
        "9521": 0.0023,
        "9535": 0.0036,
        "2380": 0.0165,
        "2381": 0.2137,
        "2382": 0.0077,
        "1210": 0.0733,
        "1211": 0.2772,
        "1321": 0.0728,
        "1322": 0.0139,
        "2010": 0.8947,
        "2060": 0.2231,
        "2240": 0.1613,
        "2300": 0.0011,
        "2360": 0.1365,
        "3008": 0.0196,
        "3010": 0.022,
        "3050": 0.0204,
        "3092": 0.033,
        "1212": 0.0117,
        "4141": 0.072,
        "4142": 0.0208,
        "4270": 0.0145,
        "2190": 0.1449,
        "4263": 0.0556,
        "1213": 0.0101,
        "1830": 0.0695,
        "4071": 0.0843,
        "4240": 0.0407,
        "4006": 0.0072,
        "4160": 0.0472,
        "4164": 0.1596,
        "2050": 0.3506,
        "2284": 0.0681,
        "4080": 0.035,
        "6001": 0.1657,
        "6050": 0.0817,
        "6070": 0.0125,
        "6090": 0.0113,
        "2140": 0.0081,
        "4005": 0.6649,
        "4009": 0.0094,
        "4017": 0.2068,
        "2070": 0.0316,
        "1111": 0.476,
        "7200": 0.222,
        "2082": 0.3283,
        "2083": 0.4117,
        "5110": 0.0825,
        "4020": 0.1394,
        "4220": 0.0094,
        "4250": 0.0106,
        "9563": 0.0019,
        "9565": 0.0449,
        "9566": 0.1124,
        "9510": 0.0257,
        "9560": 0.0006,
        "9571": 0.1762,
        "9584": 0.0141,
        "9526": 0.2992,
        "9590": 0.0406,
        "9589": 0.1224,
        "9555": 0.0053,
        "9579": 0.0133,
        "9530": 0.2059,
        "9544": 0.5231,
        "9546": 0.0118,
        "9572": 0.0081,
        "9587": 0.1042,
        "9585": 0.0437,
        "9543": 0.1363,
        "9516": 0.2058,
        "9591": 0.2064,
        "1201": 0.0064,
        "2200": 0.1882,
        "4261": 0.0239,
        "4262": 0.0155,
        "6060": 0.2724,
        "9523": 0.0295,
        "9568": 0.0014,
        "9593": 0.0411,
        "9537": 0.0938
    };

    // Selected stocks array
    let selectedStocks = [];

    // DOM elements
    const stockIdInput = document.getElementById('stock_id');
    const stockCountInput = document.getElementById('stock_count');
    const addStockBtn = document.getElementById('add-stock-btn');
    const suggestionsDiv = document.getElementById('stock-suggestions');
    const selectedStocksSection = document.getElementById('selected-stocks-section');
    const selectedStocksTbody = document.getElementById('selected-stocks-tbody');
    const totalResultsSection = document.getElementById('total-results-section');

    // Populate available stocks table
    function populateTable() {
        const tableBody = document.getElementById('stocks-table-body');
        const sortedStocks = Object.entries(stockData).sort((a, b) => b[1] - a[1]);
        
        sortedStocks.forEach(([stockId, coefficient]) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${stockId}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${coefficient.toFixed(4)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <button onclick="selectStock('${stockId}')" class="text-green-600 hover:text-green-900 font-medium">
                        اختيار
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Select stock function
    function selectStock(stockId) {
        stockIdInput.value = stockId;
        stockCountInput.focus();
        suggestionsDiv.classList.add('hidden');
    }

    // Auto-complete functionality
    stockIdInput.addEventListener('input', function(e) {
        const value = e.target.value.trim();
        
        if (value.length > 0) {
            const matches = Object.keys(stockData).filter(stock => 
                stock.includes(value)
            ).slice(0, 8);
            
            if (matches.length > 0) {
                suggestionsDiv.innerHTML = matches.map(stock => 
                    `<div class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectStock('${stock}')">${stock} (${stockData[stock].toFixed(4)})</div>`
                ).join('');
                suggestionsDiv.classList.remove('hidden');
            } else {
                suggestionsDiv.classList.add('hidden');
            }
        } else {
            suggestionsDiv.classList.add('hidden');
        }
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.suggestions-container')) {
            suggestionsDiv.classList.add('hidden');
        }
    });

    // Add stock function
    function addStock() {
        const stockId = stockIdInput.value.trim();
        const stockCount = parseInt(stockCountInput.value);
        
        if (!stockId || !stockCount || stockCount <= 0) {
            alert('يرجى إدخال رمز السهم وعدد الأسهم بشكل صحيح');
            return;
        }
        
        if (!stockData[stockId]) {
            alert('رمز السهم غير موجود في القائمة');
            return;
        }

        // Check if stock already exists
        const existingIndex = selectedStocks.findIndex(stock => stock.id === stockId);
        if (existingIndex !== -1) {
            // Update existing stock
            selectedStocks[existingIndex].count = stockCount;
            selectedStocks[existingIndex].value = stockData[stockId] * stockCount;
        } else {
            // Add new stock
            selectedStocks.push({
                id: stockId,
                count: stockCount,
                coefficient: stockData[stockId],
                value: stockData[stockId] * stockCount
            });
        }

        // Clear inputs
        stockIdInput.value = '';
        stockCountInput.value = '';
        suggestionsDiv.classList.add('hidden');
        
        // Update display
        updateSelectedStocksDisplay();
        updateTotalResults();
    }

    // Update selected stocks display
    function updateSelectedStocksDisplay() {
        if (selectedStocks.length === 0) {
            selectedStocksSection.classList.add('hidden');
            return;
        }

        selectedStocksSection.classList.remove('hidden');
        selectedStocksTbody.innerHTML = '';

        selectedStocks.forEach((stock, index) => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-100';
            row.innerHTML = `
                <td class="py-3 px-4 font-medium text-gray-900">${stock.id}</td>
                <td class="py-3 px-4 text-gray-700">${stock.count.toLocaleString()}</td>
                <td class="py-3 px-4 text-gray-700">${stock.coefficient.toFixed(4)}</td>
                <td class="py-3 px-4 font-medium text-green-600">${stock.value.toFixed(4)}</td>
                <td class="py-3 px-4">
                    <button onclick="removeStock(${index})" class="remove-btn px-3 py-1 text-red-600 hover:text-red-800 rounded-md transition-colors">
                        حذف
                    </button>
                </td>
            `;
            selectedStocksTbody.appendChild(row);
        });
    }

    // Remove stock function
    function removeStock(index) {
        selectedStocks.splice(index, 1);
        updateSelectedStocksDisplay();
        updateTotalResults();
    }

    // Update total results
    function updateTotalResults() {
        if (selectedStocks.length === 0) {
            totalResultsSection.classList.add('hidden');
            return;
        }

        totalResultsSection.classList.remove('hidden');

        const totalStocksCount = selectedStocks.reduce((sum, stock) => sum + stock.count, 0);
        const totalCompaniesCount = selectedStocks.length;
        const totalValue = selectedStocks.reduce((sum, stock) => sum + stock.value, 0);

        document.getElementById('total-stocks-count').textContent = totalStocksCount.toLocaleString();
        document.getElementById('total-companies-count').textContent = totalCompaniesCount;
        document.getElementById('total-value').textContent = totalValue.toFixed(4);
    }

    // Event listeners
    addStockBtn.addEventListener('click', addStock);

    // Allow adding stock by pressing Enter
    stockCountInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            addStock();
        }
    });

    stockIdInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            stockCountInput.focus();
        }
    });

    // Initialize table on page load
    document.addEventListener('DOMContentLoaded', populateTable);
</script>
@endsection