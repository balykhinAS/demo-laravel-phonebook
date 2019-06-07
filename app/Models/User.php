<?php

namespace App\Models;

use DomainException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $api_token
 * @property string|array permissions
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param string $name
     * @param string $email
     * @param string|null $password
     * @param array|null $permission
     * @return User
     */
    public static function new(string $name, string $email, string $password = null, array $permission = null): self
    {
        $instance = new static([
            'name'  => $name,
            'email' => $email,
        ]);

        $instance
            ->setPassword($password ?? Str::random())
            ->setPermissions($permission ?? [])
            ->refreshToken()
            ->save();

        return $instance;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = Hash::make($password);

        return $this;
    }

    /**
     * @return User
     */
    public function refreshToken(): self
    {
        $this->api_token = hash('sha256', Str::random(60));

        return $this;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        if (is_string($this->permissions)) {
            $this->permissions = json_decode($this->permissions);
        }

        return $this->permissions ?? [];
    }

    /**
     * @param array $permissions
     * @return User
     */
    public function setPermissions(array $permissions): self
    {
        $this->permissions = json_encode($permissions);

        return $this;
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->getPermissions());
    }

    /**
     * @return BelongsToMany
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'contact_favorites', 'user_id', 'contact_id');
    }

    /**
     * @param int $id
     */
    public function addToFavorites(int $id)
    {
        if ($this->hasInFavorites($id)) {
            throw new DomainException('This contact is already added to favorites.');
        }

        $this->favorites()->attach($id);
    }

    /**
     * @param int $id
     */
    public function removeFromFavorites(int $id)
    {
        $this->favorites()->detach($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function hasInFavorites(int $id): bool
    {
        return $this->favorites()->where('id', $id)->exists();
    }
}
