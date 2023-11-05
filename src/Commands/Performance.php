<?php

namespace Tsquare\SiteAuditor\Commands;


use Spatie\Lighthouse\Enums\Category;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Performance extends BaseCommand
{
    public function __construct()
    {
        $this->setDescription('Run site performance audit');

        parent::__construct('performance');
    }

    public function configure(): void
    {
        parent::configureAudit('performance', Category::Performance);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->executeAudit(Category::Performance, $input, $output);
    }
}
