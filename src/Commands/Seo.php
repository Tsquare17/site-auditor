<?php

namespace Tsquare\SiteAuditor\Commands;


use Spatie\Lighthouse\Enums\Category;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Seo extends BaseCommand
{
    public function __construct()
    {
        $this->setDescription('Run site SEO audit');

        parent::__construct('seo');
    }

    public function configure(): void
    {
        parent::configureAudit('seo', Category::Seo);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->executeAudit(Category::Seo, $input, $output);
    }
}
