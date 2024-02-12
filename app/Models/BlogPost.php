<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'post_tags', 'post_comment_count', 'post_category_id', 'author_id', 'post_author', 'page_1', 'page_2', 'post_status', 'post_content_excerpt', 'post_image'];
}
