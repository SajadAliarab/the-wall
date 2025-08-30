<?php

namespace App\Models;

use App\Enums\AttributeTypeEnum;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 */
class Attribute extends Model
{
    use HasFactory;

    public function casts():array
    {
        return [
            'type'=> AttributeTypeEnum::class,
            'is_require'=>'boolean',
        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_attributes');
    }
}
