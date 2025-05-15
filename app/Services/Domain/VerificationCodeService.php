<?php

namespace App\Services\Domain;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Contracts\VerificationCodeRepositoryInterface;

class VerificationCodeService extends AbstractDomainService
{
    protected RepositoryInterface $repository;

    public function __construct(VerificationCodeRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getVerificationCodes()
    {
        return $this->repository->getVerificationCodes();
    }
}
