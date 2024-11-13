<?php

namespace App\Repositories\Product;

use App\Models\Product\Product;
use App\Objects\Product\ProductObject;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function products(): \Illuminate\Database\Eloquent\Builder
    {
        return Product::with([
            'unit',
            'specialGroup1',
            'specialGroup2',
            'specialGroup3',
            'specialGroup4',
            'specialGroup5',
            'creator',
            'updater',
            'deleter'
        ]);
    }

    public function getProducts(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->products()->get();
    }


    public function create(ProductObject $object): Product
    {
        return Product::create($object->toArrayForSnakeCase());
    }

    public function update(ProductObject $object): Product
    {
        return $this->updateWithArray($object->getProduct(), $object->toArrayForSnakeCase());
    }

    public function updateWithArray(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product): ?bool
    {
        return $product->delete();
    }

    public function productsWithSelect(): \Illuminate\Database\Eloquent\Builder
    {
        return Product
//            ::join('units', 'products.unit_id', '=', 'units.id')
            ::select(
                DB::raw("CONCAT(products.code, '-', products.name) as text"),
                'products.id as id',
                'products.code as code',
                'products.name as name',
                'products.type as type',
                'products.unit_id as unit_id',
                'products.sell_vat_rate as sell_vat_rate',
                'products.sell_price as sell_price',
                'products.purchase_vat_rate as purchase_vat_rate',
                'products.purchase_price as purchase_price',
//                'units.name as unit_name',
//                'units.code as unit_code',
//                'units.global_code as unit_global_code',
            );
    }
}
