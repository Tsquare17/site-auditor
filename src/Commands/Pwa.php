<?php

namespace Tsquare\SiteAuditor\Commands;


use Spatie\Lighthouse\Enums\Category;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Pwa extends BaseCommand
{
    public function __construct()
    {
        $this->setDescription('Run progressive web app audit');

        parent::__construct('pwa');
    }

    public function configure(): void
    {
        parent::configureAudit('pwa', Category::ProgressiveWebApp);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->executeAudit(Category::ProgressiveWebApp, $input, $output);
    }
}
