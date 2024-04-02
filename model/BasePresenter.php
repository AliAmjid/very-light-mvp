<?php

namespace model;

use JetBrains\PhpStorm\NoReturn;

abstract class BasePresenter
{

    protected \StdClass $template;

    protected ?\PDO $db;

    protected AppRepository $repository;

    protected string $layout;

    protected ?string $pageTitle;

    protected ?string $templateName;

    public function __construct()
    {
        $this->template = new \StdClass();
        $this->db = PDOSingleton::get();
        $this->repository = new AppRepository($this->db);
        $this->layout = __DIR__ . '/../template/@layout.php';
    }

    public function init()
    {

    }

    abstract public function render();


    public function getTemplate(): \StdClass
    {
        return $this->template;
    }

    public function getPageTitle(): ?string
    {
        return $this->pageTitle;
    }

    protected function setPageTitle(string $pageTitle): void
    {
        $this->pageTitle = $pageTitle;
    }

    public function getTemplateName(): string
    {
        if (!$this->templateName) {
            throw new \RuntimeException('Šabolna nebyla nastavene.');

        }
        return $this->templateName;
    }

    protected function setTemplateName(?string $templateName): void
    {
        $this->templateName = $templateName;
    }

    #[NoReturn]
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit();
    }

    public function run()
    {
        $this->init();
        $this->render();
        $GLOBALS['presenter'] = [$this, $this->template];
        include $this->layout;
    }

    protected function getFromValues(): \StdClass
    {
        $body = new \StdClass();
        foreach ($_POST as $key => $value) {
            $body->$key = $value;
        }
        return $body;
    }

    protected function isFormSubmit(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function getParameter(string $name): ?string
    {
        return $_GET[$name] ?? null;
    }
}