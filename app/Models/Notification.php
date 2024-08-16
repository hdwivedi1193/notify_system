<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';

    protected $fillable = [
        'type', 'short_text', 'expiration', 'destination',
    ];

    /**
     * The users that belong to the notification.
     */


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_notifications')
                    ->withPivot('is_read')
                    ->withTimestamps();
    }
}
