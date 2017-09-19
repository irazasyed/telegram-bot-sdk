<?php

namespace Telegram\Bot\Laravel;

use Illuminate\Console\GeneratorCommand as LaravelGeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Telegram\Bot\Api;

class WebHookArtisanCommand extends LaravelGeneratorCommand
{
    private $telegram;

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

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $botName = $this->argument('botName');
        $token = config("telegram.bots.$botName.token");
        $this->telegram = new Api($token);


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
        $botName = $this->argument('botName');

        $params = ['url' => config("telegram.bots.$botName.webhookUrl")];
        ;
        if($certificatePath = config("telegram.bots.$botName.certificatePath")){
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
