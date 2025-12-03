<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoryExport implements FromCollection, WithHeadings, WithMapping
{
    private $key = 0;

    public function collection()
    {
        return Category::all();
    }

    public function headings(): array
    {
        return ['No', 'Category Name'];
    }

    public function map($category): array
    {
        return [
            ++$this->key,
            $category->name,
        ];
    }
}
