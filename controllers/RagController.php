<?php

class RagController extends BaseController
{
    private Post $postModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->postModel = new Post($db);
    }

    public function ask(): void
    {
        $answer = null;
        $sources = [];
        $authorGroups = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question = trim($_POST['question'] ?? '');
            if ($question !== '') {
                $results = $this->postModel->searchFullText($question);
                $sources = $results;

                // Also check for author matches and group posts by author
                $authorPosts = $this->postModel->searchByAuthor($question);
                if (!empty($authorPosts)) {
                    foreach ($authorPosts as $post) {
                        $author = $post['author'] ?? 'Desconocido';
                        if (!isset($authorGroups[$author])) {
                            $authorGroups[$author] = [];
                        }
                        $authorGroups[$author][] = $post;
                    }
                }

                $answer = $this->buildAnswer($question, $results);
            }
        }

        $this->render('rag/ask', [
            'answer' => $answer,
            'sources' => $sources,
            'authorGroups' => $authorGroups,
        ]);
    }

    private function buildAnswer(string $question, array $results): string
    {
        if (empty($results)) {
            return 'No encontré información en las publicaciones. Intenta con otra pregunta o palabras clave.';
        }

        $chunks = array_map(function ($row) {
            $snippet = mb_substr(strip_tags($row['content']), 0, 220);
            return "- {$row['title']}: {$snippet}...";
        }, $results);

        $summary = implode("\n", $chunks);
        return "Pregunta: {$question}\nBasado en lo que leí:\n{$summary}";
    }
}
