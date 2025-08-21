<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property float $price
 * @property int $user_id
 * @property int $category_id
 * @property CarbonImmutable | null $created_at
 * @property CarbonImmutable | null $updated_at
 * @property CarbonImmutable | null $deleted_at
 */
class Post extends Model
{
    use SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function category() :BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
