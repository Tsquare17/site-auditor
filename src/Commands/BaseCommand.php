<?php

namespace Tsquare\SiteAuditor\Commands;


use DateTime;
use Spatie\Lighthouse\Enums\Category;
use Spatie\Lighthouse\Lighthouse;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends Command
{
    public function __construct($command)
    {
        parent::__construct($command);
    }

    public function configureAudit($command, Category $audit)
    {
        $this->addUsage($command . ' (Run ' . $audit->value . ' audit)');
        $this->addUsage('site-auditor.php ' . $command . ' --report-fail-only --output-path /path/to/output/ /path/to/test.csv');
        $this->addUsage('site-auditor.php ' . $command . ' -r -o /path/to/output/ /path/to/test.csv');

        $this->addArgument('file', InputArgument::REQUIRED, 'File containing urls to audit');

        $this->addOption(
            'report-fail-only',
            'r',
            InputOption::VALUE_NONE,
            'Only report URLs that don\'t score 100'
        );

        $this->addOption(
            'output-path',
            'o',
            InputOption::VALUE_REQUIRED,
            'The path to store the results file'
        );
    }

    public function executeAudit(Category $category, InputInterface $input, OutputInterface $output): int
    {
        $start = new DateTime();

        $path = $input->getOption('output-path') ?: getcwd();

        $path = $this->normalizePath($path);

        if (!$file = $input->getArgument('file')) {
            $output->writeln("<error>Provide a file</>");

            return 0;
        }

        $count = 0;
        if (file_exists($file)) {
            $name = strrev(strtok(strrev($file), '/'));

            $filePath = $file;
        } elseif (file_exists(getcwd() . '/' . $file)) {
            $name = $file;

            $filePath = getcwd() . '/' . $file;
        } else {
            $output->writeln("<error>Failed to find file: {$file}</>");

            return 0;
        }

        $name = str_replace(['.csv', '.txt'], '', $name) . '-' . $category->value . '-' . date('Y-m-d-H-i-s');

        $data = [];
        $readFile = fopen($filePath, 'r');
        while ($line = fgetcsv($readFile)) {
            if (!$line[0]) {
                break;
            }

            $count++;

            $result = Lighthouse::url($line[0])
                ->categories($category)
                ->run();

            $output->writeln("<info>Audit {$line[0]} Complete</info>");

            $scores = $result->scores();


            $data[$line[0]] = $scores[$category->value];
        }
        fclose($readFile);

        $fileName = $path . $name . '.csv';

        $f = fopen($fileName, 'w');
        fputcsv($f, ['URL', 'Score']);
        foreach ($data as $url => $score) {
            if ($input->getOption('report-fail-only')) {
                if ($score < 100) {
                    fputcsv($f, [$url, $score]);
                }
            } else {
                fputcsv($f, [$url, $score]);
            }
        }
        fclose($f);

        $end = new DateTime();

        $interval = $end->diff($start);

        $elapsed = $interval->format('%h hours %i minutes %s seconds');

        $output->writeln("<info>{$count} Audits Complete</info>");
        $output->writeln("<info>Generated report: {$fileName}</info>");
        $output->writeln("<info>Time elapsed: {$elapsed}</info>");

        return 1;
    }

    protected function normalizePath($path)
    {
        if (strpos(strrev($path), '/') !== 0) {
            $path = $path . '/';
        }

        return $path;
    }
}
