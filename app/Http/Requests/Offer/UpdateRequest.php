<?php

namespace App\Http\Requests\Offer;

use App\Enums\Offer\StageEnum;
use App\Enums\Offer\StatusEnum;
use App\Enums\Product\TypeEnum;
use App\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'validity_date' => 'required|date|after:start_date',
//            'status' => 'required|integer|in:' . implode(',', array_column(StatusEnum::cases(), 'value')),
//            'stage' => 'required|integer|in:' . implode(',', array_column(StageEnum::cases(), 'value')),
            'special_group1_id' => 'nullable|exists:groups,id',
            'special_group2_id' => 'nullable|exists:groups,id',
            'special_group3_id' => 'nullable|exists:groups,id',
            'special_group4_id' => 'nullable|exists:groups,id',
            'special_group5_id' => 'nullable|exists:groups,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|numeric|exists:products,id',
            'items.*.product_name' => 'required|string',
            'items.*.unit_id' => 'required|numeric|exists:units,id',
            'items.*.order' => 'required|numeric|min:1',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount1' => 'required|numeric|min:0',
            'items.*.discount2' => 'required|numeric|min:0',
            'items.*.discount3' => 'required|numeric|min:0',
            'items.*.discount4' => 'required|numeric|min:0',
            'items.*.discount5' => 'required|numeric|min:0',
            'items.*.discount1_price' => 'required|numeric|min:0',
            'items.*.discount2_price' => 'required|numeric|min:0',
            'items.*.discount3_price' => 'required|numeric|min:0',
            'items.*.discount4_price' => 'required|numeric|min:0',
            'items.*.discount5_price' => 'required|numeric|min:0',
            'items.*.vat_rate' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Müşteri seçimi zorunludur.',
            'customer_id.exists' => 'Seçilen müşteri geçerli değil.',
            'description.required' => 'Açıklama alanı zorunludur.',
            'description.string' => 'Açıklama metin formatında olmalıdır.',
            'date.required' => 'Tarih alanı zorunludur.',
            'date.date' => 'Tarih formatı geçerli değil.',
            'validity_date.required' => 'Geçerlilik tarihi zorunludur.',
            'validity_date.date' => 'Geçerlilik tarihi geçerli bir tarih olmalıdır.',
            'validity_date.after' => 'Geçerlilik tarihi başlangıç tarihinden sonra olmalıdır.',
            'status.required' => 'Durum alanı zorunludur.',
            'status.integer' => 'Durum geçerli bir sayı olmalıdır.',
            'status.in' => 'Seçilen durum geçerli değil.',
            'stage.required' => 'Aşama alanı zorunludur.',
            'stage.integer' => 'Aşama geçerli bir sayı olmalıdır.',
            'stage.in' => 'Seçilen aşama geçerli değil.',
            'special_group1_id.exists' => 'Özel grup 1 geçerli değil.',
            'special_group2_id.exists' => 'Özel grup 2 geçerli değil.',
            'special_group3_id.exists' => 'Özel grup 3 geçerli değil.',
            'special_group4_id.exists' => 'Özel grup 4 geçerli değil.',
            'special_group5_id.exists' => 'Özel grup 5 geçerli değil.',
            'items.required' => 'En az bir ürün eklenmelidir.',
            'items.array' => 'Ürünler dizi formatında olmalıdır.',
            'items.min' => 'En az bir ürün eklenmelidir.',
            'items.*.product_id.required' => 'Ürün seçimi zorunludur.',
            'items.*.product_id.exists' => 'Seçilen ürün geçerli değil.',
            'items.*.product_name.required' => 'Ürün adı zorunludur.',
            'items.*.product_name.string' => 'Ürün adı metin formatında olmalıdır.',
            'items.*.unit_id.required' => 'Birim seçimi zorunludur.',
            'items.*.unit_id.exists' => 'Seçilen birim geçerli değil.',
            'items.*.order.required' => 'Sipariş sırası zorunludur.',
            'items.*.quantity.required' => 'Miktar alanı zorunludur.',
            'items.*.price.required' => 'Fiyat alanı zorunludur.',
            'items.*.discount1.required' => 'İndirim 1 alanı zorunludur.',
            'items.*.discount2.required' => 'İndirim 2 alanı zorunludur.',
            'items.*.discount3.required' => 'İndirim 3 alanı zorunludur.',
            'items.*.discount4.required' => 'İndirim 4 alanı zorunludur.',
            'items.*.discount5.required' => 'İndirim 5 alanı zorunludur.',
            'items.*.discount1_price.required' => 'İndirim 1 fiyatı zorunludur.',
            'items.*.discount2_price.required' => 'İndirim 2 fiyatı zorunludur.',
            'items.*.discount3_price.required' => 'İndirim 3 fiyatı zorunludur.',
            'items.*.discount4_price.required' => 'İndirim 4 fiyatı zorunludur.',
            'items.*.discount5_price.required' => 'İndirim 5 fiyatı zorunludur.',
            'items.*.vat_rate.required' => 'KDV oranı zorunludur.',
        ];
    }

    protected function passedValidation(): void
    {
        $items = $this->input('items');
        $stockTotal = 0;
        $serviceTotal = 0;
        $discountTotal = 0;
        $subTotal = 0;
        $vatTotal = 0;
        $total = 0;

        foreach ($items as $key => $item) {
            $product = Product::find($item['product_id']);

            $price = (float)$item['price'];
            $quantity = (float)$item['quantity'];
            $vatRate = (float)$item['vat_rate'];

            $discount1 = (float)$item['discount1'];
            $discount2 = (float)$item['discount2'];
            $discount3 = (float)$item['discount3'];
            $discount4 = (float)$item['discount4'];
            $discount5 = (float)$item['discount5'];
            $discount1Price = (float)$item['discount1_price'];
            $discount2Price = (float)$item['discount2_price'];
            $discount3Price = (float)$item['discount3_price'];
            $discount4Price = (float)$item['discount4_price'];
            $discount5Price = (float)$item['discount5_price'];

            $unitPrice = $price;
            $_discountTotal = 0;

            for ($i = 1; $i <= 5; $i++) {
                if (${"discount" . $i} > 0){
                    ${"discount".$i."Price"} = 0;
                    $discount = $unitPrice / 100 * ${"discount" . $i};
                    $_discountTotal += $discount;
                    $unitPrice -= $discount;
                }
                else if(${"discount".$i."Price"} > 0) {
                    $_discountTotal += ${"discount".$i."Price"};
                    $unitPrice -= ${"discount".$i."Price"};
                }
            }

            $_subTotal = $unitPrice * $quantity;
            $_vatTotal = $_subTotal / 100 * $vatRate;
            $_total = $_subTotal + $_vatTotal;

            if ($product->getAttribute('type') == TypeEnum::PRODUCT->value) {
                $stockTotal += $_total;
            }
            else {
                $serviceTotal += $_total;
            }

            $items[$key]["discount1_price"] = $discount1Price;
            $items[$key]["discount2_price"] = $discount2Price;
            $items[$key]["discount3_price"] = $discount3Price;
            $items[$key]["discount4_price"] = $discount4Price;
            $items[$key]["discount5_price"] = $discount5Price;
            $items[$key]["discount_total"] = $_discountTotal;
            $items[$key]["sub_total"] = $_subTotal;
            $items[$key]["vat_total"] = $_vatTotal;
            $items[$key]["total"] = $_total;
            $items[$key]['product_type'] = $product->getAttribute('type');
            $items[$key]['product_name'] = $item['product_name'] ?? $product->getAttribute('name');
            $discountTotal += $_discountTotal;
            $subTotal += $_subTotal;
            $vatTotal += $_vatTotal;
            $total += $_total;
        }

        $this->merge([
            'items' => $items,
            'stock_total' => $stockTotal,
            'service_total' => $serviceTotal,
            'discount_total' => $discountTotal,
            'sub_total' => $subTotal,
            'vat_total' => $vatTotal,
            'total' => $total
        ]);

    }
}
