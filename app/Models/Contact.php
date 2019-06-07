<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $phone
 * @property int $created_at
 * @property int $updated_at
 *
 * @method favoredByUser(User $user)
 */
class Contact extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'phone',
    ];

    /**
     * @return BelongsToMany
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'contact_favorites', 'contact_id', 'user_id');
    }

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeFavoredByUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('favorites', function(Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }
}
