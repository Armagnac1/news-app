<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getVerifiedUsers(): Collection;

    public function getIncompleteUsers(): Collection;
}
