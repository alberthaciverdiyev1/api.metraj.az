<?php

namespace Modules\Media\Http\Services;

use Modules\Media\Http\Entities\Media;
use Illuminate\Support\Facades\Validator;

class MediaService
{
    /**
     * Store media from URL
     *
     * @param string $type
     * @param string $url
     * @param string $imageableType
     * @param int $imageableId
     * @return Media
     */
    public static function storeFromUrl(string $type, string $url, string $imageableType, int $imageableId): Media
    {
        $validator = Validator::make([
            'type' => $type,
            'url' => $url,
            'imageable_type' => $imageableType,
            'imageable_id' => $imageableId,
        ], [
            'type' => 'required|string|in:image,video,document',
            'url' => 'required|url|max:500',
            'imageable_type' => 'required|string',
            'imageable_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException('Invalid media data: ' . implode(', ', $validator->errors()->all()));
        }

        return Media::create([
            'type' => $type,
            'path' => $url,
            'imageable_type' => $imageableType,
            'imageable_id' => $imageableId,
        ]);
    }

    /**
     * Store multiple media from URLs
     *
     * @param array $mediaData
     * @param string $imageableType
     * @param int $imageableId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function storeMultipleFromUrls(array $mediaData, string $imageableType, int $imageableId)
    {
        $media = collect();

        foreach ($mediaData as $item) {
            $media->push(self::storeFromUrl(
                $item['type'],
                $item['path'],
                $imageableType,
                $imageableId
            ));
        }

        return $media;
    }

    /**
     * Validate media URL
     *
     * @param string $url
     * @return bool
     */
    public static function isValidMediaUrl(string $url): bool
    {
        $validator = Validator::make(['url' => $url], [
            'url' => 'required|url|max:500'
        ]);

        return !$validator->fails();
    }

    /**
     * Get media type from URL (basic detection)
     *
     * @param string $url
     * @return string
     */
    public static function detectMediaType(string $url): string
    {
        $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'];
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
        $documentExtensions = ['pdf', 'doc', 'docx', 'txt', 'rtf', 'odt'];

        if (in_array($extension, $imageExtensions)) {
            return 'image';
        } elseif (in_array($extension, $videoExtensions)) {
            return 'video';
        } elseif (in_array($extension, $documentExtensions)) {
            return 'document';
        }

        // Default to image if extension is not recognized
        return 'image';
    }
}
