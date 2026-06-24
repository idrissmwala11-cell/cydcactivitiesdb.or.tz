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
        'approved_at',
        'approved_by',
        'profile_photo',
        'last_seen_at',
        // New fields for settings
        'theme_mode',       // light/dark mode
        'future_feature',   // 0 = disabled, 1 = enabled
        'profile_picture',  // path to uploaded profile picture
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'last_seen_at' => 'datetime',
            'password' => 'hashed',
            'future_feature' => 'boolean',  // cast future_feature as boolean
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

    public function canAccessFormTwoResults(): bool
    {
        $allowedEmails = array_map(
            static fn (string $email): string => strtolower(trim($email)),
            config('form_two_results.allowed_emails', [])
        );

        return $this->isAdmin() || in_array(strtolower(trim((string) $this->email)), $allowedEmails, true);
    }

    public function canPublishFormTwoResults(): bool
    {
        $publisherEmail = strtolower(trim((string) config('form_two_results.publisher_email')));

        return $this->isAdmin()
            || ($publisherEmail !== '' && strtolower(trim((string) $this->email)) === $publisherEmail);
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

    public function getAvatarStoragePathAttribute(): ?string
    {
        if (! empty($this->profile_photo)) {
            $photo = ltrim((string) $this->profile_photo, '/');

            return str_contains($photo, '/') ? $photo : 'profile_photos/'.$photo;
        }

        if (! empty($this->profile_picture)) {
            return ltrim((string) $this->profile_picture, '/');
        }

        return null;
    }

    public function getAvatarUrlAttribute(): ?string
    {
        if (! $this->avatar_storage_path || ! $this->exists) {
            return null;
        }

        return route('users.avatar', [
            'user' => $this->getKey(),
            'v' => $this->updated_at?->timestamp,
        ]);
    }

    public function getInitialsAttribute(): string
    {
        $displayName = $this->center_id ?: ($this->name ?: $this->email ?: 'User');
        $parts = preg_split('/\s+/', trim($displayName)) ?: [];

        return collect($parts)
            ->filter()
            ->take(2)
            ->map(fn (string $part): string => strtoupper(substr($part, 0, 1)))
            ->implode('') ?: 'U';
    }

    public function getIsOnlineAttribute(): bool
    {
        return $this->last_seen_at !== null
            && $this->last_seen_at->greaterThanOrEqualTo(now()->subMinutes(5));
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

    public function programDayParticipants(): HasMany
    {
        return $this->hasMany(ProgramDayParticipant::class);
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

    public function sentChatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    public function receivedChatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'recipient_id');
    }

}
