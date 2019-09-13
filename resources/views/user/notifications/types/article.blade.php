<?php

use App\Models\ArticleNotification;

// 文章内容通知
$article = ArticleNotification::query()->find($data['id'] ?? null);
$content = $article->content ?? '';
?>

{!! $content !!}