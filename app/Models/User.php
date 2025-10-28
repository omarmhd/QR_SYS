<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Resources\SubscriptionResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, Notifiable, HasFactory;
//    protected $appends = ['subscription_data'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded= [''];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'subscription'
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
        return $this->belongsTo(Subscription::class,"current_subscription","id");
    }
    public function subscriptions(){
        return $this->hasOne(Subscription::class);
    }
    public function getSubscriptionDataAttribute()
    {
        if (!$this->relationLoaded('subscription')) {
            $this->load('subscription');
        }

        return $this->subscription
            ? (new SubscriptionResource($this->subscription))->toArray(request())
            : null;
    }




}
