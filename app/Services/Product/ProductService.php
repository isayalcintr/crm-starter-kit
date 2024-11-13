<?php

namespace App\Services\Product;

use App\Models\Product\Product;
use App\Objects\Product\ProductFilterObject;
use App\Objects\Product\ProductObject;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function list(ProductFilterObject $filter)
    {
        $builder = $this->productRepository->products();
        if (!empty(trim($filter->getSearch())))
            $builder->where(DB::raw("
                    CONCAT_WS(' ', products.code, products.name,
                        IFNULL(special_group1.name, ''),
                        IFNULL(special_group2.name, ''),
                        IFNULL(special_group3.name, ''),
                        IFNULL(special_group4.name, ''),
                        IFNULL(special_group5.name, '')
                    )
                "), 'LIKE', "%".trim($filter->getSearch())."%");
        if (!empty(trim($filter->getCode())))
            $builder->where('products.code', 'LIKE', "%".trim($filter->getCode())."%");
        if (!empty(trim($filter->getName())))
            $builder->where('products.name', 'LIKE', "%".trim($filter->getName())."%");
        if ($filter->getId() > 0)
            $builder->where('products.id', $filter->getId());
        return $builder;
    }

    public function store(ProductObject $object)
    {
        return DB::transaction(function () use ($object) {
            return $this->productRepository->create($object);
        });
    }

    public function update(ProductObject $object)
    {
        return DB::transaction(function () use ($object) {
            $product = $this->productRepository->update($object);
            return $product;
        });
    }

    public function destroy(ProductObject $object)
    {
        return DB::transaction(function () use ($object) {
            $this->productRepository->update($object->setTargetProperty("deleted_by"));
            return $this->productRepository->delete($object->getProduct());
        });
    }

    public function select(ProductFilterObject $filter): \Illuminate\Database\Eloquent\Builder
    {
        $builder = $this->productRepository->productsWithSelect();
        if(!empty(trim($filter->getSearch()))){
            $builder->where(DB::raw("CONCAT_WS(' ', products.code, products.name)"), 'LIKE', "%".trim($filter->getSearch())."%");
        }
        if ($filter->getLimit() > 0){
            $builder->limit($filter->getLimit());
        }
        return $builder;
    }
}
