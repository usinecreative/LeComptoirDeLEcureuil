<?php

namespace App\Factory;

use App\Entity\Article;
use App\Entity\Comment;

class CommentFactory
{
    public function create(Article $article): Comment
    {
        $comment = new Comment();
        $comment->setArticle($article);

        return $comment;
    }
}
