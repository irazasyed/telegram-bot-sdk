<?php

namespace Telegram\Bot\Laravel\Artisan;

use Illuminate\Console\GeneratorCommand as LaravelGeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Telegram\Bot\BotsManager;

class WebhookCommand extends LaravelGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:webhook {botName : The bot name defined in the config file}
                {--setup : To declare your webhook on telegram servers. So they can call you.} 
                {--remove : To remove your already declared webhook on telegram servers.} 
                {--info : To get the information about your current webhook on telegram servers.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ease the Process of setting up and removing webhooks.';

    private $telegram;

    private $config;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param \Telegram\Bot\BotsManager $botManager
     * @return void
     */
    public function handle(BotsManager $botManager)
    {
        $botName = $this->argument('botName');

        $this->telegram = $botManager->bot($botName);
        $this->config = $botManager->getBotConfig($botName);

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
        $params = ['url' => array_get($this->config, 'webhook_url')];

        $certificatePath = array_get($this->config, 'certificate_path', false);
        if ($certificatePath) {
            $params['certificate'] = $certificatePath;
        }

        $response = $this->telegram->setWebhook($params);

        $this->info($response->description);
    }

    private function removeWebHook()
    {
        $response = $this->telegram->removeWebhook();

        $this->info($response->description);
    }

    private function getInfo()
    {
    }
}
