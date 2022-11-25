<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Candidate;

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes;
    use Notifiable;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public $table = 'users';

    protected $appends = [
        'photo',
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'birthday',
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'company_id',
        'name',
        'lastname',
        'email',
        'phone',
        'birthday',
        'government_number',
        'passport',
        'enable_challenge_card',
        'social_linkedin',
        'system_language_id',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function getIsConsultantAttribute()
    {
        return $this->roles()->where('id', 2)->exists();
    }

    public function getIsCandidateAttribute()
    {
        return $this->roles()->where('id', 3)->exists();
    }

    public function getIsClientAttribute()
    {
        return $this->roles()->where('id', 4)->exists();
    }

    public function getCandidateAttribute()
    {
        return Candidate::where('user_id', $this->id)->first();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function userSessionUsers()
    {
        return $this->hasMany(SessionUser::class, 'user_id', 'id');
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->lastname;
    }

    public function userJobOffers()
    {
        return $this->hasMany(JobOffer::class, 'user_id', 'id');
    }

    public function userPrograms()
    {
        return $this->hasMany(Program::class, 'user_id', 'id');
    }

    public function userSessions()
    {
        return $this->hasMany(Session::class, 'user_id', 'id');
    }

    public function userUserNotes()
    {
        return $this->hasMany(UserNote::class, 'user_id', 'id');
    }

    public function userUserAlerts()
    {
        return $this->belongsToMany(UserAlert::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getBirthdayAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getPhotoDefaultAttribute()
    {
        $file = $this->getMedia('photo')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }
        else
        {
            $file = new \stdClass();
            $file->url       = env('APP_URL') . '/photos/person-default.jpg';
            $file->thumbnail = env('APP_URL') . '/photos/person-default.jpg';
            $file->preview   = env('APP_URL') . '/photos/person-default.jpg';
        }

        return $file;
    }

    public function getPhotoDefinedAttribute()
    {
        return ($this->getMedia('photo')->last() != null);
    }

    public function system_language()
    {
        return $this->belongsTo(Language::class, 'system_language_id');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format_nosecs')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format_nosecs'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
