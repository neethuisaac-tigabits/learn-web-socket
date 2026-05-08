<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The user who created this room.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Members of this room (many-to-many through the pivot table).
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_room_user')
            ->withPivot('joined_at');
    }

    /**
     * All messages in this room.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Helper: is the given user authorized to read/write this room?
     * Public rooms are open; private rooms require membership or ownership.
     */
    public function isAccessibleBy(User $user): bool
    {
        if ($this->type === 'public') {
            return true;
        }

        if ($this->created_by === $user->id) {
            return true;
        }

        return $this->members()->where('users.id', $user->id)->exists();
    }
}
