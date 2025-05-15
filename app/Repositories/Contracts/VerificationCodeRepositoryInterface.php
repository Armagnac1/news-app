<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface VerificationCodeRepositoryInterface extends RepositoryInterface
{
    public function getVerificationCodes(): LengthAwarePaginator;
}
