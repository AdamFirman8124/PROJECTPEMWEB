<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Certificate extends Model
    {
        protected $fillable = ['seminar_id', 'download_start_date', 'user_id', 'user_name'];

        // Relasi dengan model User
        public function user() {
            return $this->belongsTo(User::class);
        }
        
        public function seminar() {
            return $this->belongsTo(Seminar::class);
        }
    }