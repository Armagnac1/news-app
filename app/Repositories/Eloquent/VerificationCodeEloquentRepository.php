<?php

namespace App\Repositories\Eloquent;

use App\Models\VerificationCode;
use App\Repositories\Contracts\VerificationCodeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class VerificationCodeEloquentRepository extends AbstractEloquentRepository implements VerificationCodeRepositoryInterface
{
    public function __construct(VerificationCode $model)
    {
        parent::__construct($model);
    }

    public function getVerificationCodes(): LengthAwarePaginator
    {
        return $this->model->with('user')
            ->latest()
            ->paginate(20);
    }
}
