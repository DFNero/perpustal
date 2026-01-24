<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'activity_type',
        'resource_type',
        'resource_id',
        'description',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related book (if resource is Book)
     */
    public function book()
    {
        return $this->when($this->resource_type === 'Book', function ($query) {
            return Book::find($this->resource_id);
        });
    }

    /**
     * Get the related borrowing (if resource is Borrowing)
     */
    public function borrowing()
    {
        return $this->when($this->resource_type === 'Borrowing', function ($query) {
            return Borrowing::find($this->resource_id);
        });
    }

    /**
     * Get the related review (if resource is Review)
     */
    public function review()
    {
        return $this->when($this->resource_type === 'Review', function ($query) {
            return Review::find($this->resource_id);
        });
    }

    /**
     * Get the related user resource (if resource is User)
     */
    public function relatedUser()
    {
        return $this->when($this->resource_type === 'User', function ($query) {
            return User::find($this->resource_id);
        });
    }

    /**
     * Scope: Get logs by activity type
     */
    public function scopeByActivityType($query, $activityType)
    {
        return $query->where('activity_type', $activityType);
    }

    /**
     * Scope: Get logs by resource type
     */
    public function scopeByResourceType($query, $resourceType)
    {
        return $query->where('resource_type', $resourceType);
    }

    /**
     * Scope: Get logs by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Get logs by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope: Get recent logs first
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Static method to log an activity
     */
    public static function log(
        int $userId,
        string $activityType,
        string $resourceType,
        int $resourceId,
        ?string $description = null,
        ?array $metadata = null
    ): self {
        return self::create([
            'user_id' => $userId,
            'activity_type' => $activityType,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'description' => $description,
            'metadata' => $metadata,
        ]);
    }
}
