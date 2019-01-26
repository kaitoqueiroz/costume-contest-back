<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCostume extends Model
{
    protected $table = 'user_costume';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'photo',
    ];

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user that owns the phone.
     */
    public function getPhotoAttribute($photo)
    {
        $photoUrl = ($photo) ? url('api/photos/'.$photo) : null;
        return $photoUrl;
    }
}