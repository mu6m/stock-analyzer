<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    public $timestamps = false; // Since your migration doesn't have timestamps
    
    protected $primaryKey = 'stock_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'stock_id',
        'company_name',
        'market_type',
        'sector',
        'current_price',
        'previous_price',
        'price_history'
    ];

    protected $casts = [
        'current_price' => 'decimal:2',
        'previous_price' => 'decimal:2',
        'price_history' => 'array'
    ];

    // Calculate percentage change
    public function getPriceChangePercentageAttribute()
    {
        if (!$this->current_price || !$this->previous_price || $this->previous_price == 0) {
            return null;
        }
        
        $change = $this->current_price - $this->previous_price;
        return round(($change / $this->previous_price) * 100, 2);
    }

    // Get price change amount
    public function getPriceChangeAttribute()
    {
        if (!$this->current_price || !$this->previous_price) {
            return null;
        }
        
        return $this->current_price - $this->previous_price;
    }

    // Check if price went up
    public function getIsPriceUpAttribute()
    {
        $change = $this->price_change;
        return $change ? $change > 0 : null;
    }

    // Scope for market filtering
    public function scopeByMarket(Builder $query, string $market): Builder
    {
        return $query->where('market_type', $market);
    }

    // Scope for sector filtering
    public function scopeBySector(Builder $query, string $sector): Builder
    {
        return $query->where('sector', $sector);
    }

    // Optimized search scope using full-text search if available
    public function scopeSearch(Builder $query, string $search): Builder
    {
        // If you have full-text index (MySQL), use this:
        // return $query->whereRaw("MATCH(company_name, stock_id) AGAINST(? IN NATURAL LANGUAGE MODE)", [$search]);
        
        // Otherwise, use regular LIKE with optimized structure
        return $query->where(function($q) use ($search) {
            $q->where('company_name', 'like', '%' . $search . '%')
              ->orWhere('stock_id', 'like', '%' . $search . '%');
        });
    }

    // Cache frequently accessed data
    public static function getCachedSectors()
    {
        return cache()->remember('stock_sectors', 3600, function () {
            return static::distinct()->pluck('sector')->sort()->values();
        });
    }

    public static function getCachedMarkets()
    {
        return cache()->remember('stock_markets', 3600, function () {
            return static::distinct()->pluck('market_type')->sort()->values();
        });
    }

    public function dividends()
    {
        return $this->hasMany(Dividend::class, 'stock_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'stock_id');
    }

    public function actions()
    {
        return $this->hasMany(Action::class, 'stock_id');
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'compSymbolCode');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'stock_id');
    }
}


// TODO: SEPARATE THEM


class Dividend extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'amount',
        'distribution_way',
        'announce_date',
        'due_date',
        'distribution_date',
        'stock_id',
    ];

    protected $casts = [
        'announce_date' => 'datetime',
        'due_date' => 'datetime',
        'distribution_date' => 'datetime',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}

class News extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'title',
        'description',
        'creation_date',
        'stock_id',
    ];

    protected $casts = [
        'creation_date' => 'datetime',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}

class Action extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'issueTypeDesc',
        'newCApital',
        'prevCApital',
        'dueDate',
        'announceDate',
        'stock_id',
    ];

    protected $casts = [
        'dueDate' => 'datetime',
        'announceDate' => 'datetime',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}

class Meeting extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'compSymbolCode',
        'holdingSite',
        'modifiedDt',
        'meetingReason',
        'natureOfGenMetng',
        'status',
    ];

    protected $casts = [
        'modifiedDt' => 'datetime',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'compSymbolCode');
    }
}

class Session extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'stock_id',
        'session_type',
        'requirement',
        'submission_method',
        'no_of_bod',
        'session_start_date',
        'session_end_date',
        'app_start_date',
        'app_end_date',
    ];

    protected $casts = [
        'session_start_date' => 'date',
        'session_end_date' => 'date',
        'app_start_date' => 'date',
        'app_end_date' => 'date',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}