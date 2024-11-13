<?php

namespace App\Models\Offer;

use App\Models\Product\Product;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferItem extends Model
{
    use HasFactory;

    protected $table = 'offer_items'; // Tablo adı belirtmek için

    protected $fillable = [
        'offer_id',
        'product_id',
        'product_name',
        'product_type',
        'unit_id',
        'order',
        'quantity',
        'price',
        'discount1',
        'discount2',
        'discount3',
        'discount4',
        'discount5',
        'discount1_price',
        'discount2_price',
        'discount3_price',
        'discount4_price',
        'discount5_price',
        'vat_rate',
        'discount_total',
        'sub_total',
        'vat_total',
        'total',
    ];

    public function offer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function unit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
