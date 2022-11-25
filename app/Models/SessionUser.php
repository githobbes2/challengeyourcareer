<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Candidate;
use App\Models\CandidateProgram;

class SessionUser extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public $table = 'session_users';
    private $belongsToProgram = null;
    private $userItem = null;
    private $sessionItem = null;

    protected $appends = [
        'attachments',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'session_id',
        'attendance',
        'notes',
        'score',
        'score_feedback',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function sessionUserCandidateCommitments()
    {
        return $this->hasMany(CandidateCommitment::class, 'session_user_id', 'id');
    }

    public function sessionUserUserNotes()
    {
        return $this->hasMany(UserNote::class, 'session_user_id', 'id');
    }

    public function sessionUserCandidateServices()
    {
        return $this->hasMany(CandidateService::class, 'session_user_id', 'id');
    }

    public function user()
    {
        if(!$this->userItem) {
            $this->userItem = $this->belongsTo(User::class, 'user_id');
        }
        return $this->userItem;
    }

    public function session()
    {
        if(!$this->sessionItem) {
            $this->sessionItem = $this->belongsTo(Session::class, 'session_id');
        }
        return $this->sessionItem;
    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getBelongsToProgramAttribute() {
        if(!$this->belongsToProgram) {
            //Buscar si el usuario es un candidato del programa de la sesión
            if(!$this->session->program_id) {
                $this->belongsToProgram = false;
            } else {
                $candidate = Candidate::where('user_id', $this->user->id)->first();
                if(!$candidate) {
                    $this->belongsToProgram = false;
                } else {
                    $candidateProgram = CandidateProgram::where('candidate_id', $candidate->id)->where('program_id', $this->session->program_id)->first();
                    $this->belongsToProgram = ($candidateProgram != null);
                }
            }
        }

        return $this->belongsToProgram;
    }
}
