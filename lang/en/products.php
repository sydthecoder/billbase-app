<?php

return [
    'attributes' => [
        'product_category_id' => 'category',
        'name' => 'product name',
        'description' => 'description',
        'price' => 'price',
        'unit' => 'unit',
        'is_taxable' => 'tax status',
        'sku' => 'SKU',
        'status' => 'status',
    ],
    'messages' => [
        'name_required' => 'Please enter a product name.',
        'price_required' => 'Product price is required.',
        'price_numeric' => 'Price must be a number.',
        'price_min' => 'Price cannot be negative.',
        'category_exists' => 'Selected category does not exist.',
        'sku_unique' => 'A product with this SKU already exists.',
    ],
];