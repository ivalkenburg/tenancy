<?php

namespace App\Models;

use App\Support\Multitenancy\Traits\TenantAware;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends Model
{
    use UsesUuid,
        TenantAware,
        LogsActivity;

    static protected $logOnlyDirty = true;

    static protected $logAttributes = [
        'title',
        'body',
    ];

    protected $table = 'posts';

    protected $guarded = [];

    protected $casts = [
        'user_id' => 'string',
        'title' => 'string',
        'body' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
