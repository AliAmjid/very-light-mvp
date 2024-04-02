<?php

use model\BasePresenter;

include __DIR__ . '/autoloader.php';

final class HomepagePresenter extends BasePresenter
{
    public function render(): void
    {
        $this->setPageTitle('Nastěnka');
        $this->setTemplateName(__DIR__ . '/template/homepage.php');
        $this->template->categories = $this->repository->getAllCategories();
        $categoryFilter = $this->getParameter('categoryId');

        if (!empty($categoryFilter)) {

            if ($this->repository->getCategoryById($categoryFilter) === null) {
                $this->template->categoryDoesNotExist = true;
            }

            $this->template->posts = $this->repository->getPostsByCategory((int)$categoryFilter);
        } else {
            $this->template->posts = $this->repository->getAllPosts();
        }
    }
}

(new HomepagePresenter())->run();