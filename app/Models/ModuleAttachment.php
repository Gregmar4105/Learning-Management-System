<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'module_id',
        'file_path',
        'original_name',
    ];

    /**
     * Get the assignment post that this attachment belongs to.
     */
    public function Module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
