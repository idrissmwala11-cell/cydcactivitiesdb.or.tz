<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'phone',
        'password',
        'role',
        'center_id',
        'cluster_name',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // Role methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
    
    // Status methods
    public function isPending(): bool
    {
        return $this->status === 'pending' || $this->status === null;
    }
    
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
    
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
    
    // Relationship for approved by user
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    

    
    // Get display name using center_id
    public function getDisplayNameAttribute(): string
    {
        return $this->center_id ?? 'No Center ID';
    }
    
    public function getName(): string
    {
        return $this->center_id ?? 'No Center ID';
    }
    
    // Relationships
    public function skillsInformation(): HasMany
    {
        return $this->hasMany(SkillsInformation::class);
    }
    
    public function masomoYaMtaala(): HasMany
    {
        return $this->hasMany(MasomoYaMtaala::class);
    }
    
    public function baseLeaders(): HasMany
    {
        return $this->hasMany(BaseLeader::class);
    }
    
    public function vocationalTraining(): HasMany
    {
        return $this->hasMany(VocationalTraining::class);
    }
    
    public function specialPrograms(): HasMany
    {
        return $this->hasMany(SpecialProgram::class);
    }
    
    public function parentsInformation(): HasMany
    {
        return $this->hasMany(ParentsInformation::class);
    }
    
    public function savingGroups(): HasMany
    {
        return $this->hasMany(SavingGroup::class);
    }
    
    public function groupMembers(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }
    
    public function curriculumAttendance(): HasMany
    {
        return $this->hasMany(CurriculumAttendance::class);
    }
    
    public function talentAttendance(): HasMany
    {
        return $this->hasMany(TalentAttendance::class);
    }
    
    public function skillsAttendance(): HasMany
    {
        return $this->hasMany(SkillsAttendance::class);
    }
    
    public function absentParticipants(): HasMany
    {
        return $this->hasMany(AbsentParticipant::class);
    }
    

}
