<?php

namespace Telegram\Bot\Laravel\Artisan;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\TableCell;
use Telegram\Bot\Api;
use Telegram\Bot\BotsManager;
use Telegram\Bot\Exceptions\TelegramBotNotFoundException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\WebhookInfo;

class WebhookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:webhook {bot? : The bot name defined in the config file}
                {--all : To perform actions on all your bots.}
                {--setup : To declare your webhook on Telegram servers. So they can call you.}
                {--remove : To remove your already declared webhook on Telegram servers.}
                {--info : To get the information about your current webhook on Telegram servers.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ease the Process of setting up and removing webhooks.';

    protected Api $telegram;

    protected BotsManager $botsManager;

    /** @var array Bot Config */
    protected array $config = [];

    /**
     * Execute the console command.
     *
     * @throws TelegramSDKException
     */
    public function handle(BotsManager $botsManager): void
    {
        $this->botsManager = $botsManager;
        $bot = $this->argument('bot');

        try {
            $this->telegram = $this->botsManager->bot($bot);
        } catch (TelegramBotNotFoundException $e) {
            $this->warn($e->getMessage());
            $this->warn('You must specify a proper bot name or configure one.');
            $this->line('');
            $this->info('💡Omitting the bot name will fallback to the default bot.');

            return;
        }

        $this->config = $this->botsManager->getBotConfig($bot);

        if ($this->option('setup')) {
            $this->setupWebhook();
        }

        if ($this->option('remove')) {
            $this->removeWebhook();
        }

        if ($this->option('info')) {
            $this->getInfo();
        }
    }

    /**
     * Setup Webhook.
     *
     * @throws TelegramSDKException
     */
    private function setupWebhook(): void
    {
        $params = ['url' => data_get($this->config, 'webhook_url')];
        $certificatePath = data_get($this->config, 'certificate_path', false);

        if ($certificatePath && 'YOUR-CERTIFICATE-PATH' !== $certificatePath) {
            $params['certificate'] = $certificatePath;
        }

        $response = $this->telegram->setWebhook($params);
        if ($response) {
            $this->info('Success: Your webhook has been set!');

            return;
        }

        $this->error('Your webhook could not be set!');
    }

    /**
     * Remove Webhook.
     *
     * @throws TelegramSDKException
     */
    private function removeWebhook(): void
    {
        if ($this->confirm(sprintf('Are you sure you want to remove the webhook for %s?', $this->config['bot']))) {
            $this->info('Removing webhook...');

            if ($this->telegram->removeWebhook()) {
                $this->info('Webhook removed successfully!');

                return;
            }

            $this->error('Webhook removal failed');
        }
    }

    /**
     * Get Webhook Info.
     *
     * @throws TelegramSDKException
     */
    private function getInfo(): void
    {
        $this->alert('Webhook Info');

        if ($this->option('all')) {
            $bots = $this->botsManager->getConfig('bots');
            collect($bots)->each(function ($bot, $key): void {
                $response = $this->botsManager->bot($key)->getWebhookInfo();
                $this->makeWebhookInfoResponse($response, $key);
            });

            return;
        }

        $response = $this->telegram->getWebhookInfo();
        $bot = $this->config['bot'];
        $this->makeWebhookInfoResponse($response, $bot);
    }

    /**
     * Make WebhookInfo Response for console.
     */
    private function makeWebhookInfoResponse(WebhookInfo $response, string $bot): void
    {
        $rows = $response->map(function ($value, $key): array {
            $key = Str::title(str_replace('_', ' ', $key));
            $value = is_bool($value) ? $this->mapBool($value) : $value;

            return ['key' => $key, 'value' => $value];
        })->toArray();

        $this->table([
            [new TableCell('Bot: '.$bot, ['colspan' => 2])],
            ['Key', 'Info'],
        ], $rows);
    }

    /**
     * Map Boolean Value to Yes/No.
     */
    private function mapBool(bool $value): string
    {
        return $value ? 'Yes' : 'No';
    }
}
