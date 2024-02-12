<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $fillable = ['comment_post_id', 'comment_author', 'comment_email', 'comment_content', 'comment_status', 'post_author', 'page_1', 'comment_date'];
}
