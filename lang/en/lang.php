<?php

return [
    'plugin' => [
        'name' => 'TheaterNews',
        'description' => 'No description provided yet...',
    ],
    'components' => [
        'archive' => [
            'name' => 'Archive Component',
            'description' => 'No description provided yet...',
        ],
        'feed' => [
            'name' => 'Feed Component',
            'description' => 'No description provided yet...',
        ],
        'news' => [
            'name' => 'News Component',
            'description' => 'No description provided yet...',
        ],
    ],
    'news' => [
        'label' => 'News',
        'create_title' => 'Create News',
        'update_title' => 'Edit News',
        'preview_title' => 'Preview News',
        'list_title' => 'Manage News',
        'menu_label' => 'News',
        'return_to_list' => 'Return to News',
        'delete_confirm' => 'Do you really want to delete this news?',
        'new' => 'New News',
        'delete_selected_confirm' => 'Delete the selected news?',
        'delete_selected_success' => 'Successfully deleted the selected news.',
        'delete_selected_empty' => 'There are no selected :name to delete.',
    ],
    'category' => [
        'label' => 'Category',
        'create_title' => 'Create Category',
        'update_title' => 'Edit Category',
        'preview_title' => 'Preview Category',
        'list_title' => 'Manage Categories',
        'new' => 'New Category',
    ],
    'categories' => [
        'menu_label' => 'Categories',
        'return_to_list' => 'Return to Categories',
        'delete_confirm' => 'Do you really want to delete this category?',
        'delete_selected_confirm' => 'Delete the selected categories?',
        'delete_selected_success' => 'Successfully deleted the selected categories.',
        'delete_selected_empty' => 'There are no selected :name to delete.',
    ],
];