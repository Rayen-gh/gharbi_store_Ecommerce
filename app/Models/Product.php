<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'title',
        'description',
        'price',
        'quantity', // Add this if missing
        'category_id',
        'category_name',
        'images',
        'image', // Add single image field for backward compatibility
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
    ];

    // Accessor to get the first image (for compatibility with your current view)
    public function getFirstImageAttribute()
    {
        // If single image field exists, use it
        if ($this->image) {
            return $this->image;
        }
        
        // Otherwise, get first from images array
        if (!$this->images || empty($this->images)) {
            return null;
        }
        
        if (is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }
        
        return null;
    }

    // Get all valid image URLs
    public function getImageUrlsAttribute()
    {
        $allImages = [];
        
        // Add single image if exists
        if ($this->image) {
            $allImages[] = $this->image;
        }
        
        // Add images from array
        if ($this->images && is_array($this->images)) {
            $allImages = array_merge($allImages, $this->images);
        }
        
        // Filter out invalid URLs and duplicates
        $validImages = array_filter(array_unique($allImages), function($image) {
            return is_string($image) && (
                filter_var($image, FILTER_VALIDATE_URL) || 
                !empty($image) // Allow relative paths
            );
        });
        
        return array_values($validImages);
    }

    // Get display image with fallback
    public function getDisplayImageAttribute()
    {
        // Try single image field first
        if ($this->image) {
            return $this->isValidImagePath($this->image) ? $this->image : $this->getPlaceholderImage();
        }
        
        // Try first image from array
        $firstImage = $this->first_image;
        if ($firstImage) {
            return $this->isValidImagePath($firstImage) ? $firstImage : $this->getPlaceholderImage();
        }
        
        return $this->getPlaceholderImage();
    }

    // Helper method to validate image path
    private function isValidImagePath($path)
    {
        if (empty($path)) {
            return false;
        }
        
        // Check if it's a valid URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return true;
        }
        
        // Check if it's a relative path that exists
        if (file_exists(public_path('uploads/products/' . $path))) {
            return true;
        }
        
        return false;
    }

    // Get placeholder image
    private function getPlaceholderImage()
    {
        return 'https://placehold.co/60x60?text=No+Image';
    }

    // Check if product is from external API
    public function isFromApi()
    {
        return !is_null($this->external_id);
    }

    // Relationship with Category (if you have a Category model)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}