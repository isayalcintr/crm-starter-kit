<?php

namespace App\Models\Product;

use App\Models\Group;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'code',
        'name',
        'unit_id',
        'purchase_vat_rate',
        'purchase_price',
        'sell_vat_rate',
        'sell_price',
        'quantity',
        'special_group1_id',
        'special_group2_id',
        'special_group3_id',
        'special_group4_id',
        'special_group5_id',
        'type',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * Birim (unit) ile olan ilişki.
     */
    public function unit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    /**
     * Grup 1 ile olan ilişki.
     */
    public function specialGroup1(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'special_group1_id');
    }

    /**
     * Grup 2 ile olan ilişki.
     */
    public function specialGroup2(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'special_group2_id');
    }

    /**
     * Grup 3 ile olan ilişki.
     */
    public function specialGroup3(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'special_group3_id');
    }

    /**
     * Grup 4 ile olan ilişki.
     */
    public function specialGroup4(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'special_group4_id');
    }

    /**
     * Grup 5 ile olan ilişki.
     */
    public function specialGroup5(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'special_group5_id');
    }

    /**
     * Ürünü oluşturan kullanıcı ile olan ilişki.
     */
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Ürünü güncelleyen kullanıcı ile olan ilişki.
     */
    public function updater(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Ürünü silen kullanıcı ile olan ilişki.
     */
    public function deleter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
