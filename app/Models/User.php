<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, Notifiable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded= [''
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('storage/' .$value);
        }
    }

    public function deviceTokens()
{
    return $this->hasMany(DeviceToken::class);
}

    public function notifications(){

        return $this->hasMany(Notification::class);
    }
    public function visitHistories(){

        return $this->hasMany(VisitHistory::class);
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

    public function subscription(){
        return $this->belongsTo(Subscription::class,"current_subscription");
    }


}
