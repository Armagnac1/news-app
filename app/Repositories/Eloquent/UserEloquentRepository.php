<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserEloquentRepository extends AbstractEloquentRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getVerifiedUsers(): Collection
    {
        return $this->model->whereNotNull('telegram_verified_at')
            ->latest()
            ->get();
    }

    public function getIncompleteUsers(): Collection
    {
        return $this->model->whereNull('telegram_verified_at')
            ->latest()
            ->get();
    }
}
