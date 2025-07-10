<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::query();

        // Filter by market type
        if ($request->filled('market')) {
            $query->byMarket($request->market);
        }

        // Filter by sector
        if ($request->filled('sector')) {
            $query->bySector($request->sector);
        }

        // Search by company name or stock ID
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->search . '%')
                  ->orWhere('stock_id', 'like', '%' . $request->search . '%');
            });
        }

        $stocks = $query->orderBy('company_name')->paginate(20);
        
        // Get distinct sectors and markets for filters
        $sectors = Stock::distinct()->pluck('sector');
        $markets = Stock::distinct()->pluck('market_type');

        return view('stocks.index', compact('stocks', 'sectors', 'markets'));
    }

    public function show($id)
    {
        $stock = Stock::findOrFail($id);
        return view('stocks.show', compact('stock'));
    }
}