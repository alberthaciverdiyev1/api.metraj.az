# Media Storage Migration: File-based to URL-based

## Overview
This document describes the migration from file-based media storage to URL-based media storage in the Laravel API.

## Changes Made

### 1. UserController Updates
- **File**: `Modules/User/Http/Controllers/UserController.php`
- **Changes**:
  - `profile_image` validation changed from `image|mimes:jpeg,png,jpg,webp|max:2048` to `url|max:500`
  - `background_image` validation changed from `image|mimes:jpeg,png,jpg,webp|max:2048` to `url|max:500`
  - Removed file upload logic (`file->move()`, `unlink()`, `file_exists()`)
  - Now accepts URLs directly for profile and banner images

### 2. MediaController Updates
- **File**: `Modules/Media/Http/Controllers/MediaController.php`
- **Changes**:
  - Implemented `store()` method for URL-based media creation
  - Added `uploadUrl()` method for URL-based media uploads
  - Added proper validation for URLs instead of file uploads
  - Uses MediaService for consistent media handling

### 3. PropertyController Updates
- **File**: `Modules/Property/Http/Controllers/PropertyController.php`
- **Changes**:
  - Updated to use MediaService for storing property media
  - Property media is now stored as URLs instead of files

### 4. New MediaService
- **File**: `Modules/Media/Http/Services/MediaService.php`
- **Features**:
  - `storeFromUrl()` - Store single media from URL
  - `storeMultipleFromUrls()` - Store multiple media from URLs
  - `isValidMediaUrl()` - Validate media URLs
  - `detectMediaType()` - Auto-detect media type from URL

### 5. Validation Updates
- **File**: `Modules/Property/Http/Requests/StoreProperty.php`
- **Changes**:
  - Added validation for media array items
  - Media paths must be valid URLs
  - Media types must be one of: image, video, document

### 6. Routes Updates
- **File**: `Modules/Media/Routes/api.php`
- **Added**: `POST /media/upload-url` endpoint for URL-based uploads

### 7. Configuration
- **File**: `Modules/Media/Config/media.php`
- **Features**:
  - Media configuration for URL-based storage
  - Supported media types and extensions
  - Validation rules

## API Usage Examples

### User Profile Image Update
```bash
PUT /api/user/update
Content-Type: application/json
Authorization: Bearer {token}

{
    "profile_image": "https://example.com/images/profile.jpg"
}
```

### User Banner Update
```bash
PUT /api/user/update-banner
Content-Type: application/json
Authorization: Bearer {token}

{
    "background_image": "https://example.com/images/banner.jpg"
}
```

### Media Upload via URL
```bash
POST /api/media/upload-url
Content-Type: application/json
Authorization: Bearer {token}

{
    "type": "image",
    "url": "https://example.com/images/property1.jpg",
    "imageable_type": "Modules\\Property\\Http\\Entities\\Property",
    "imageable_id": 1
}
```

### Property Creation with Media
```bash
POST /api/property/add
Content-Type: application/json
Authorization: Bearer {token}

{
    "property_condition": "new",
    "add_type": "sale",
    "building_type": "apartment",
    "phone_1": "+994501234567",
    "mail": "test@example.com",
    "description": "Beautiful apartment",
    "price": 50000,
    "media": [
        {
            "type": "image",
            "path": "https://example.com/images/property1.jpg"
        },
        {
            "type": "image", 
            "path": "https://example.com/images/property2.jpg"
        }
    ]
}
```

## Migration Notes

### What Changed
1. **No more file uploads**: All media must now be provided as URLs
2. **No local storage**: Files are no longer stored in `public/uploads/` directories
3. **URL validation**: All media URLs are validated for proper format
4. **Consistent API**: All media operations now use URLs consistently

### What Stays the Same
1. **Database structure**: Media table structure remains unchanged
2. **API endpoints**: Most endpoints remain the same, just accept URLs instead of files
3. **Relationships**: Media relationships work the same way
4. **Response format**: API responses maintain the same structure

### Benefits
1. **Scalability**: No server storage needed for media files
2. **Performance**: Reduced server load and storage requirements
3. **Flexibility**: Media can be hosted on any CDN or external service
4. **Consistency**: All media handling is now URL-based

## Testing
To test the migration:
1. Use the API examples above with valid image URLs
2. Verify that media URLs are stored correctly in the database
3. Check that media relationships work properly
4. Ensure validation works for invalid URLs

## Rollback
If rollback is needed:
1. Revert the controller changes
2. Restore file upload logic
3. Update validation rules back to file-based
4. Remove URL-based endpoints
