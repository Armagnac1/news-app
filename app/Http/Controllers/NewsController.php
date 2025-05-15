<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use App\Services\Domain\NewsArticleService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsArticleService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index()
    {
        $news = $this->newsService->getLatestNews();

        return Inertia::render('News/Index', [
            'news' => $news,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $news = $this->newsService->searchNews($query);

        return response()->json($news);
    }

    public function show(NewsArticle $article)
    {
        return Inertia::render('News/Show', [
            'article' => $article,
        ]);
    }

    public function updateAllSources(): \Illuminate\Http\RedirectResponse
    {
        try {
            $sources = $this->newsService->getAvailableSources();

            foreach ($sources as $source) {
                $this->newsService->fetchAndStoreNews($source);
            }

            return back()->with('success', 'All news sources updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update all news sources');
        }
    }
}
