<?php

use model\BasePresenter;

require_once __DIR__ . '/autoloader.php';

final class EditPresenter extends BasePresenter
{

    private array $errors = [];

    public function init(): void
    {
        if ($this->isFormSubmit()) {
            $this->onFormSubmit();
        }
    }


    private function validateForm(): void
    {
        $values = $this->getFromValues();
        if (empty($values->category)) {
            $this->errors['category'] = 'Musíte vybrat kategorii.';
            return;
        }

        $category = $this->repository->getCategoryById((int)$values->category);
        if (!$category) {
            $this->errors['category'] = 'Zvolená kategorie neexistuje!';
            return;
        }

        $text = trim($values->text ?? '');
        if (empty($text)) {
            $this->errors['text'] = 'Musíte zadat text příspěvku.';
        }
    }

    private function onFormSubmit(): void
    {
        $values = $this->getFromValues();
        $this->validateForm();

        // end validate
        if (!empty($this->errors)) {
            return;
        }

        if ($this->getParameter('postId')) {
            $this->repository->updatePost(
                (int)$this->getParameter('postId'),
                1,
                (int)$values->category,
                trim($values->text)
            );
        } else {
            $this->repository->insertPost(1, (int)$values->category, trim($values->text));
        }

        $this->redirect('index.php');
    }

    public function render(): void
    {
        $postId = $this->getParameter('postId');
        $this->setPageTitle($postId ? 'Editace příspěvku' : 'Nový příspěvek');
        $this->template->errors = $this->errors;
        $this->setTemplateName(__DIR__ . '/template/edit.php');
        $this->template->categories = $this->repository->getAllCategories();
        if ($postId) {
            $post = $this->repository->getPostById($postId);
            if (!$post) {
               $this->redirect('index.php');
            }
            $this->template->post = $post;
        }
    }
}

(new EditPresenter())->run();