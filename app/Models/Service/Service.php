<?php

namespace App\Models\Service;

use App\Models\Customer\Customer;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'services';

    protected $fillable = [
        'code',
        'customer_id',
        'description',
        'status',
        'start_date',
        'end_date',
        'stock_total',
        'service_total',
        'vat_total',
        'sub_total',
        'total',
        'created_by',
        'updated_by',
        'deleted_by',
        'special_group1_id',
        'special_group2_id',
        'special_group3_id',
        'special_group4_id',
        'special_group5_id',
    ];

    protected static function booted(): void
    {
        static::created(function ($service) {
            $service->code = 'S-' . $service->id;
            $service->save();
        });
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function specialGroup1(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'special_group1_id');
    }

    public function specialGroup2(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'special_group2_id');
    }

    public function specialGroup3(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'special_group3_id');
    }

    public function specialGroup4(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'special_group4_id');
    }

    public function specialGroup5(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class, 'special_group5_id');
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ServiceItem::class);
    }

    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function setStatusAttribute(string|int $value): void
    {
        $this->attributes['status'] = (string)$value;
    }
}
