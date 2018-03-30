<?php
namespace App\Mail\Application;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Event\EventLog;

class EventNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $event_log;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EventLog $eventLog)
    {
        $this->event_log = $eventLog;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.Application.notification');
    }
}
