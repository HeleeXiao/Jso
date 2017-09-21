<?php

namespace App\Jobs;

use App\Models\SDK\AutoMailSdk;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPasswordForgetMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailInfo;

    /**
     * Create a new job instance.
     *
     * @param array $mailInfo
     * @return void
     */
    public function __construct(array $mailInfo)
    {
        $this->mailInfo = $mailInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new AutoMailSdk())->send(
            'web.mails.password-reset-link',
            $this->mailInfo['email'],
            $this->mailInfo['title'],
            ['link' => $this->mailInfo['link']]
        );
    }

    /**
     * Record the error message.
     *
     * @param \Exception $exception
     * @throws \Exception
     */
    public function failed(\Exception $exception)
    {
        \Logger::error($exception->getMessage());
        throw $exception;
    }
}
