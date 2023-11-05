<?php

namespace Tsquare\SiteAuditor\Commands;


use Spatie\Lighthouse\Enums\Category;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BestPractices extends BaseCommand
{
    public function __construct()
    {
        $this->setDescription('Run site best practices audit');

        parent::__construct('best-practices');
    }

    public function configure(): void
    {
        parent::configureAudit('best-practices', Category::BestPractices);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->executeAudit(Category::BestPractices, $input, $output);
    }
}
