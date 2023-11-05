<?php

namespace Tsquare\SiteAuditor\Commands;


use Spatie\Lighthouse\Enums\Category;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class A11y extends BaseCommand
{
    public function __construct()
    {
        $this->setDescription('Run site accessibility audit');

        parent::__construct('a11y');
    }

    public function configure(): void
    {
        parent::configureAudit('a11y', Category::Accessibility);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->executeAudit(Category::Accessibility, $input, $output);
    }
}
