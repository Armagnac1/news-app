<?php

namespace App\Http\Controllers;

use App\Services\Domain\NewsArticleService;
use App\Services\Domain\UserService;
use App\Services\Domain\VerificationCodeService;
use Inertia\Inertia;

class AdminController extends Controller
{
    protected $userService;

    protected $verificationCodeService;

    protected $newsArticleService;

    public function __construct(
        UserService $userService,
        VerificationCodeService $verificationCodeService,
        NewsArticleService $newsArticleService
    ) {
        $this->userService = $userService;
        $this->verificationCodeService = $verificationCodeService;
        $this->newsArticleService = $newsArticleService;
    }

    public function index()
    {
        $verifiedUsers = $this->userService->getVerifiedUsers();
        $incompleteUsers = $this->userService->getIncompleteUsers();
        $verificationCodes = $this->verificationCodeService->getVerificationCodes();
        $news = $this->newsArticleService->getLatestNews();

        return Inertia::render('Admin/Dashboard', [
            'verifiedUsers' => $verifiedUsers,
            'incompleteUsers' => $incompleteUsers,
            'verificationCodes' => $verificationCodes,
            'news' => $news,
        ]);
    }
}
