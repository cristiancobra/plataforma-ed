<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'text_id',
        'task_id',
        'proposal_id',
        'type',
        'name',
        'path',
        'status',
    ];

    /**
     * Get the text that owns the attachment.
     */
    public function text()
    {
        return $this->belongsTo(Text::class);
    }

    /**
     * Get the task that owns the attachment.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the proposal that owns the attachment.
     */
    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    /**
     * Get the account that owns the attachment.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the full URL for the attachment
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
