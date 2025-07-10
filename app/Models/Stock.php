<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'stock_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'stock_id',
        'company_name',
        'market_type',
        'sector'
    ];

    protected $casts = [
        'market_type' => 'string',
    ];

    public function scopeByMarket($query, $market)
    {
        return $query->where('market_type', $market);
    }

    public function scopeBySector($query, $sector)
    {
        return $query->where('sector', $sector);
    }
}