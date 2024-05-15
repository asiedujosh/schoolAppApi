<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class oralQuestionModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'examId', 'yearId', 'subjectId', 'topicId', 'questionNo', 'question', 'mimeType', 'answer', 'options', 'hints', 'publisher',
    ];

    // Add this if you want to include the audio_url in the model's array or JSON form
    protected $appends = ['audio_url'];

     // Define an accessor for the audio_url
     public function getAudioUrlAttribute()
     {
         return Storage::disk('s3')->temporaryUrl($this->question, now()->addMinutes(5));
     }
}
