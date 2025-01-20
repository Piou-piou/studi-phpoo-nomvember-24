<?php

namespace App\Controller;

use App\Repository\ArticleRepository;

class ArticleController extends AbstractController
{
    public function list(): array
    {
        $articleRepository = new ArticleRepository();

        return [
            'page' => 'articles/list',
            'articles' => $articleRepository->findAll(),
        ];
    }

    public function show(int $id): array
    {
        $articleRepository = new ArticleRepository();

        return [
            'page' => 'articles/show',
            'article' => $articleRepository->find($id),
        ];
    }

    public function create(?array $postedData = null): string|array
    {
        if ($postedData) {
            //from POST method
            $articleRepository = new ArticleRepository();

            if ($articleRepository->create($postedData['title'], $postedData['content'])) {
                $this->addFlash('success_message', 'Article créé');
            } else {
                $this->addFlash('error_message', 'Une erreur est survenue');
            }

            return $this->redirectToUri('/article/list');
        }

         return [
            'page' => 'articles/create',
        ];
    }

    public function edit(int $id, ?array $postedData = null): array
    {
        $articleRepository = new ArticleRepository();
        $article = $articleRepository->find($id);

        if ($postedData) {
            //from POST method
            $articleRepository = new ArticleRepository();

            $article->title = $postedData['title'];
            $article->content = $postedData['content'];


            if ($articleRepository->update($article)) {
                $this->addFlash('success_message', 'Article mis à jour');
            } else {
                $this->addFlash('error_message', 'Une erreur est survenue');
            }

            return $this->redirectToUri('/article/show/'.$id);
        }

         return [
            'page' => 'articles/edit',
            'article' => $articleRepository->find($id),
        ];
    }
}