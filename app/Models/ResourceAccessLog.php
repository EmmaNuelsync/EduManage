<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceAccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'student_id',
        'accessed_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'accessed_at' => 'datetime',
    ];

    /**
     * Get the resource that was accessed.
     */
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get the student who accessed the resource.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}