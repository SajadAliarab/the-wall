<?php

namespace App\Models;

use App\Models\States\Post\PostApprovedStatus;
use App\Models\States\Post\PostStatus;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property float $price
 * @property int $user_id
 * @property int $category_id
 * @property PostStatus|string $status
 * @property CarbonImmutable | null $boosted_at
 * @property CarbonImmutable | null $created_at
 * @property CarbonImmutable | null $updated_at
 * @property CarbonImmutable | null $deleted_at
 */
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'price' => 'decimal:2',
            'boosted_at' => 'datetime',
        ];
    }

    #[Scope]
    protected function approved(Builder $query): void
    {
        $query->where('status', PostApprovedStatus::getMorphClass());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function userBookmarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_post_bookmarks')
            ->withTimestamps();
    }

    public function attachments(): BelongsToMany
    {
        return $this->belongsToMany(Attachment::class, 'post_attachments')
            ->withTimestamps();
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'category_attributes')
            ->withPivot('value')
            ->withTimestamps();
    }

}
