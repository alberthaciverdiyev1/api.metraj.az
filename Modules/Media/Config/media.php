<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Media Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for the Media module.
    | The system now uses URL-based media storage instead of file uploads.
    |
    */

    'storage_type' => 'url', // 'url' for URL-based storage, 'file' for file-based storage

    /*
    |--------------------------------------------------------------------------
    | Media Types
    |--------------------------------------------------------------------------
    |
    | Supported media types in the system.
    |
    */
    'supported_types' => [
        'image' => [
            'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'],
            'max_url_length' => 500,
        ],
        'video' => [
            'extensions' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'],
            'max_url_length' => 500,
        ],
        'document' => [
            'extensions' => ['pdf', 'doc', 'docx', 'txt', 'rtf', 'odt'],
            'max_url_length' => 500,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Media Settings
    |--------------------------------------------------------------------------
    |
    | Default settings for media handling.
    |
    */
    'defaults' => [
        'type' => 'image',
        'max_url_length' => 500,
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    |
    | Validation rules for media URLs.
    |
    */
    'validation' => [
        'url' => 'required|url|max:500',
        'type' => 'required|string|in:image,video,document',
    ],
];
