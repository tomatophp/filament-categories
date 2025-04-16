<?php

return [
    'category' => [
        'title' => 'Categories',
        'single' => 'Category',
        'sections' => [
            'details' => [
                'title' => 'Category Details',
                'description' => 'Create a new category',
                'columns' => [
                    'name' => 'Name',
                    'slug' => 'Slug',
                    'description' => 'Description',
                    'icon' => 'Icon',
                    'color' => 'Color',
                ],
            ],
            'status' => [
                'title' => 'Status',
                'description' => 'Status settings',
                'columns' => [
                    'parent_id' => 'Parent',
                    'type' => 'Type',
                    'for' => 'For',
                    'is_active' => 'Is Active',
                    'show_in_menu' => 'Show In Menu',
                ],
            ],
            'images' => [
                'title' => 'Images',
                'description' => 'Images settings',
                'columns' => [
                    'feature_image' => 'Feature Image',
                    'cover_image' => 'Cover Image',
                ],
            ],
        ],
    ],
];
