<?php

namespace Modules\Media\Tests;

use Tests\TestCase;
use Modules\Media\Http\Services\MediaService;
use Modules\Media\Http\Entities\Media;

class MediaUrlTest extends TestCase
{
    /**
     * Test URL-based media storage
     */
    public function test_can_store_media_from_url()
    {
        $testUrl = 'https://example.com/test-image.jpg';
        $testType = 'image';
        $imageableType = 'Modules\\Property\\Http\\Entities\\Property';
        $imageableId = 1;

        // Test the service method
        $media = MediaService::storeFromUrl($testType, $testUrl, $imageableType, $imageableId);

        $this->assertInstanceOf(Media::class, $media);
        $this->assertEquals($testType, $media->type);
        $this->assertEquals($testUrl, $media->path);
        $this->assertEquals($imageableType, $media->imageable_type);
        $this->assertEquals($imageableId, $media->imageable_id);
    }

    /**
     * Test URL validation
     */
    public function test_validates_media_url()
    {
        $validUrl = 'https://example.com/image.jpg';
        $invalidUrl = 'not-a-valid-url';

        $this->assertTrue(MediaService::isValidMediaUrl($validUrl));
        $this->assertFalse(MediaService::isValidMediaUrl($invalidUrl));
    }

    /**
     * Test media type detection
     */
    public function test_detects_media_type_from_url()
    {
        $imageUrl = 'https://example.com/image.jpg';
        $videoUrl = 'https://example.com/video.mp4';
        $documentUrl = 'https://example.com/document.pdf';
        $unknownUrl = 'https://example.com/unknown.xyz';

        $this->assertEquals('image', MediaService::detectMediaType($imageUrl));
        $this->assertEquals('video', MediaService::detectMediaType($videoUrl));
        $this->assertEquals('document', MediaService::detectMediaType($documentUrl));
        $this->assertEquals('image', MediaService::detectMediaType($unknownUrl)); // Default to image
    }

    /**
     * Test multiple media storage
     */
    public function test_can_store_multiple_media_from_urls()
    {
        $mediaData = [
            [
                'type' => 'image',
                'path' => 'https://example.com/image1.jpg'
            ],
            [
                'type' => 'image',
                'path' => 'https://example.com/image2.jpg'
            ]
        ];

        $imageableType = 'Modules\\Property\\Http\\Entities\\Property';
        $imageableId = 1;

        $media = MediaService::storeMultipleFromUrls($mediaData, $imageableType, $imageableId);

        $this->assertCount(2, $media);
        $this->assertEquals('https://example.com/image1.jpg', $media->first()->path);
        $this->assertEquals('https://example.com/image2.jpg', $media->last()->path);
    }
}
