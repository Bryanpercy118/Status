<?php

namespace App\Models;
use App\Events\ChirpCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class chirp extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
    ];
    protected $dispatchesEvents = [
        'created' => ChirpCreated::class,
    ];
    //Relacion usuario entre los post y el usuario que la publica
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
