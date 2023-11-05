<?php

namespace Tsquare\SiteAuditor;


use Symfony\Component\Console\Application;
use Tsquare\SiteAuditor\Commands\A11y;
use Tsquare\SiteAuditor\Commands\BestPractices;
use Tsquare\SiteAuditor\Commands\Performance;
use Tsquare\SiteAuditor\Commands\Pwa;
use Tsquare\SiteAuditor\Commands\Seo;

class App extends Application
{
    public function __construct()
    {
        parent::__construct('Site Auditor', '0.1.0');

        $this->add(new Performance());
        $this->add(new A11y());
        $this->add(new BestPractices());
        $this->add(new Seo());
        $this->add(new Pwa());
    }
}
