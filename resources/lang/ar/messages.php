<?php

return [
    'category' => [
        'title' => 'التصنيفات',
        'single' => 'التصنيف',
        'sections' => [
            'details' => [
                'title' => 'تفاصيل التصنيف',
                'description' => 'إنشاء تصنيف جديد',
                'columns' => [
                    'name' => 'الاسم',
                    'slug' => 'الرابط المختصر',
                    'description' => 'الوصف',
                    'icon' => 'الأيقونة',
                    'color' => 'اللون',
                ],
            ],
            'status' => [
                'title' => 'الحالة',
                'description' => 'إعدادات الحالة',
                'columns' => [
                    'parent_id' => 'الأب',
                    'type' => 'النوع',
                    'for' => 'لـ',
                    'is_active' => 'نشط',
                    'show_in_menu' => 'إظهار في القائمة',
                ],
            ],
            "images" => [
                "title" => "الصور",
                "description" => "إعدادات الصور",
                "columns" => [
                    "feature_image" => "صورة مميزة",
                    "cover_image" => "صورة الغلاف",
                ]
            ],
        ],
    ],
];
