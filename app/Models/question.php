<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters){
        if($filters['keyword'] ?? false){
        $query->where('examId','like','%' . request('keyword') . '%')
        ->orWhere('yearId','like','%' . request('keyword') . '%')
        ->orWhere('subjectId','like','%' . request('keyword') .'%');
        }
    }
}
