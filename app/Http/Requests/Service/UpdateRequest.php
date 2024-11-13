<?php

namespace App\Http\Requests\Service;

use App\Enums\Product\TypeEnum;
use App\Enums\Service\StatusEnum;
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
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|integer|in:' . implode(',', array_column(StatusEnum::cases(), 'value')),
            'special_group1_id' => 'nullable|exists:groups,id',
            'special_group2_id' => 'nullable|exists:groups,id',
            'special_group3_id' => 'nullable|exists:groups,id',
            'special_group4_id' => 'nullable|exists:groups,id',
            'special_group5_id' => 'nullable|exists:groups,id',
            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.unit_id' => 'required|numeric|exists:units,id',
            'items.*.vat_rate' => 'required|numeric|min:0',
            'items.*.product_id' => 'required|numeric|exists:products,id',
            'items.*.product_name' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Müşteri seçimi gerekli!',
            'description.required' => 'Açıklama girilmesi zorunludur!',
            'status.required' => 'Durum seçimi gerekli!',
            'start_date.required' => 'Başlangıç tarihi zorunludur!',
            'start_date.date' => 'Başlangıç tarihi geçerli bir tarih olmalı!',
            'start_date.after_or_equal' => 'Başlangıç tarihi bugünden önce olamaz!',
            'end_date.required' => 'Bitiş tarihi zorunludur!',
            'end_date.date' => 'Bitiş tarihi geçerli bir tarih olmalı!',
            'end_date.after' => 'Bitiş tarihi başlangıç tarihinden önce olamaz!',
            'items.required' => 'En az bir adet ürün/hizmet gerekli!',
            'items.array' => 'Items dizisi geçerli bir dizi olmalı!',
            'items.min' => 'Items dizisi en az 1 öğe içermeli!',
            'items.*.quantity.required' => 'Miktar zorunludur!',
            'items.*.quantity.numeric' => 'Miktar sayısal olmalı!',
            'items.*.quantity.min' => 'Miktar en az 1 olmalı!',
            'items.*.price.required' => 'Fiyat zorunludur!',
            'items.*.price.numeric' => 'Fiyat sayısal olmalı!',
            'items.*.price.min' => 'Fiyat 0 veya daha büyük olmalı!',
            'items.*.unit_id.required' => 'Birim ID zorunludur!',
            'items.*.unit_id.numeric' => 'Birim ID sayısal olmalı!',
            'items.*.vat_rate.required' => 'KDV oranı zorunludur!',
            'items.*.vat_rate.numeric' => 'KDV oranı sayısal olmalı!',
            'items.*.vat_rate.min' => 'KDV oranı 0 veya daha büyük olmalı!',
            'items.*.product_id.required' => 'Ürün ID zorunludur!',
            'items.*.product_id.numeric' => 'Ürün ID sayısal olmalı!',
            'items.*.product_title.required' => 'Ürün adı zorunludur!',
            'items.*.product_title.string' => 'Ürün adı geçerli bir metin olmalı!',
        ];
    }

    protected function passedValidation(): void
    {
        $items = $this->input('items');
        $subTotal = 0;
        $vatTotal = 0;
        $total = 0;
        $stockTotal = 0;
        $serviceTotal = 0;

        foreach ($items as $key => $item) {
            $product = Product::find($item['product_id']);
            $price = (float)$item['price'];
            $quantity = (float)$item['quantity'];
            $vatRate = (float)$item['vat_rate'];

            // Alt toplam ve KDV hesaplama
            $_subTotal = $price * $quantity;
            $_vatTotal = $_subTotal * $vatRate / 100;
            $_total = $_subTotal + $_vatTotal;

            // Ürün tipi kontrolü
            if ($product->getAttribute('type') == TypeEnum::PRODUCT->value) {
                $stockTotal += $_total;
            } else {
                $serviceTotal += $_total;
            }

            // Item bilgilerini güncelle
            $items[$key]['product_type'] = $product->getAttribute('type');
            $items[$key]['product_name'] = $item['product_name'] ?? $product->getAttribute('name');  // Eğer item'da 'name' varsa onu al, yoksa üründen al
            $items[$key]['sub_total'] = $_subTotal;
            $items[$key]['vat_total'] = $_vatTotal;
            $items[$key]['total'] = $_total;

            // Toplamları güncelle
            $subTotal += $_subTotal;
            $vatTotal += $_vatTotal;
            $total += $_total;
        }

        // Veriyi merge et
        $this->merge([
            'items' => $items,
            'sub_total' => $subTotal,
            'vat_total' => $vatTotal,
            'total' => $total,
            'stock_total' => $stockTotal,
            'service_total' => $serviceTotal,
        ]);
    }
}
