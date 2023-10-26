<?php

declare(strict_types=1);

namespace Idos\Views;

use Exception;

class View
{
    private const TEMPLATE_SUFFIX = ".phtml";

    private const BASE_TEMPLATE_PATH = __DIR__ . "/Templates/base.view" . self::TEMPLATE_SUFFIX;
    private string $pathToView;

    public function __construct(
        private string $view,
        private ?array $context = null
    ) {
        $this->pathToView = __DIR__ . "/Templates/" . $this->view . self::TEMPLATE_SUFFIX;
    }

    /**
     * @throws Exception
     */
    public function show(): void {

        if (! is_file($this->pathToView)) {
            // pokud soubor neexistuje, vyhodíme Exception o neexistujícím souboru šablony
            throw new Exception(sprintf("File not `%s` found", $this->pathToView));
        }

        // přes "output buffering" načteme šablonu form.view do $template a naplníme ji daty pro proměnné
        ob_start();
        if ($this->context !== null) {
            extract($this->context);
        }
        require($this->pathToView);
        $template = ob_get_clean();

        // zde $template vložíme do base.view šablony
        ob_start();
        extract(['html_body' => $template]);
        require(self::BASE_TEMPLATE_PATH);
        $baseTemplate = ob_get_clean();

        // vykreslíme na výstup konečnou podobu pohledu (view)
        echo $baseTemplate;
    }
}