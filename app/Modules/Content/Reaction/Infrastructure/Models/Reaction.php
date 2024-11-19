<?php

namespace App\Modules\Content\Reaction\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use Database\Factories\ReactionFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reaction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'reactable_id',
        'reactable_type',
        'user_id',
        'type',
    ];

    public function reactable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return new ReactionFactory();
    }
}
