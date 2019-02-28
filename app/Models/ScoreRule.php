<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreRule extends Model
{
    //
    const INDEX_CONTINUE_LOGIN = 'multi_login_score';
    const INDEX_REVIEW_PRODUCT = 'review_product';
    const INDEX_LOGIN = 'login_score';
    const INDEX_REGISTER = 'register_score';
}
