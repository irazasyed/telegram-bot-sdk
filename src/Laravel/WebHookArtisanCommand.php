<?php

namespace Telegram\Bot\Laravel;

use Illuminate\Console\GeneratorCommand as LaravelGeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class WebHookArtisanCommand extends LaravelGeneratorCommand
{
    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:webhook
                {--setup : To declare your webhook on telegram servers. So the can call you.} 
                {--remove : To remove your already declared webhook on telegram servers.} 
                {--info : To get the information about your current webhook on telegram servers.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ease the Process of setting up and removing webhooks.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('setup')) {
            $this->setupWebhook();
        }

        if ($this->option('remove')) {
            $this->removeWebHook();
        }

        if ($this->option('info')) {
            $this->getInfo();
        }
    }

    private function setupWebhook()
    {
    }

    private function removeWebHook()
    {
    }

    private function getInfo()
    {
    }
}
