<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('market')) {
            $query->byMarket($request->market);
        }

        if ($request->filled('sector')) {
            $query->bySector($request->sector);
        }

        $stocks = $query->select(['stock_id', 'company_name', 'market_type', 'sector'])
                      ->orderBy('company_name')
                      ->paginate(20);

        $sectors = Cache::remember('distinct_sectors', 300, function() {
            return Stock::whereNotNull('sector')
                       ->distinct()
                       ->orderBy('sector')
                       ->pluck('sector');
        });

        $markets = Cache::remember('distinct_markets', 300, function() {
            return Stock::whereNotNull('market_type')
                       ->distinct()
                       ->orderBy('market_type')
                       ->pluck('market_type');
        });

        return view('stocks.index', compact('stocks', 'sectors', 'markets'));
    }

    public function show(Stock $stock)
    {
        $recentDividends = $stock->dividends()
            ->orderBy('announce_date', 'desc')
            ->limit(5)
            ->get();

        $recentNews = $stock->news()
            ->orderBy('creation_date', 'desc')
            ->limit(5)
            ->get();

        $recentActions = $stock->actions()
            ->orderBy('announceDate', 'desc')
            ->limit(5)
            ->get();

        $recentMeetings = $stock->meetings()
            ->orderBy('modifiedDt', 'desc')
            ->limit(5)
            ->get();

        $recentSessions = $stock->sessions()
            ->orderBy('session_start_date', 'desc')
            ->limit(5)
            ->get();

        return view('stocks.show', compact('stock', 'recentDividends', 'recentNews', 'recentActions', 'recentMeetings', 'recentSessions'));
    }

    public function dividends(Request $request, Stock $stock)
    {
        $query = $stock->dividends();
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('distribution_way', 'like', '%' . $search . '%');
        }
        
        $dividends = $query->orderBy('announce_date', 'desc')->paginate(20);
        
        return view('stocks.dividends', compact('stock', 'dividends'));
    }

    public function news(Request $request, Stock $stock)
    {
        $query = $stock->news();
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        $news = $query->orderBy('creation_date', 'desc')->paginate(20);
        
        return view('stocks.news', compact('stock', 'news'));
    }

    public function showNews(Stock $stock, News $news)
    {
        if ($news->stock_id !== $stock->stock_id) {
            abort(404);
        }
        
        return view('stocks.news-detail', compact('stock', 'news'));
    }

    public function actions(Request $request, Stock $stock)
    {
        $query = $stock->actions();
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('issueTypeDesc', 'like', '%' . $search . '%');
        }
        
        $actions = $query->orderBy('announceDate', 'desc')->paginate(20);
        
        return view('stocks.actions', compact('stock', 'actions'));
    }

    public function meetings(Request $request, Stock $stock)
    {
        $query = $stock->meetings();
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('meetingReason', 'like', '%' . $search . '%')
                  ->orWhere('natureOfGenMetng', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%');
            });
        }
        
        $meetings = $query->orderBy('modifiedDt', 'desc')->paginate(20);
        
        return view('stocks.meetings', compact('stock', 'meetings'));
    }

    public function sessions(Request $request, Stock $stock)
    {
        $query = $stock->sessions();
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('session_type', 'like', '%' . $search . '%')
                  ->orWhere('requirement', 'like', '%' . $search . '%')
                  ->orWhere('submission_method', 'like', '%' . $search . '%');
            });
        }
        
        $sessions = $query->orderBy('session_start_date', 'desc')->paginate(20);
        
        return view('stocks.sessions', compact('stock', 'sessions'));
    }
}