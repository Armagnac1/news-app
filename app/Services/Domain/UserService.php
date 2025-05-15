<?php

namespace App\Services\Domain;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService extends AbstractDomainService
{
    protected RepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getVerifiedUsers()
    {
        return $this->repository->getVerifiedUsers();
    }

    public function getIncompleteUsers()
    {
        return $this->repository->getIncompleteUsers();
    }
}
