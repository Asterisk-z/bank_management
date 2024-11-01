<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function toArray()
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            // "user" =>  $this->user->,
            "kyc_document_id" => $this->kyc_document_id,
            "document_name" => $this->document->name,
            "attachment" => $this->attachment,
            "message" => $this->message,
            "status" => $this->status,
        ];
    }

    public function document()
    {
        return $this->hasOne(KycDocument::class, 'id', 'kyc_document_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
