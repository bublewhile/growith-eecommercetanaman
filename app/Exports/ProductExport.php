<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{
    private $rowNumber = 0;

    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return ['No', 'Nama Produk', 'Kategori', 'Harga', 'Stok', 'Merek', 'Gambar', 'Deskripsi'];
    }

    public function map($product): array
    {
        return [
            ++$this->rowNumber,
            $product->name,
            $product->category->name,
            'Rp' . number_format($product->price, 0, ',', '.'),
            $product->stock,
            $product->brand,
            asset('storage/' . $product->image),
            $product->description
        ];
    }
}
