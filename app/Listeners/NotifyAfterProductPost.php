<?php

namespace App\Listeners;

use App\Events\ProductPost;
use App\Notifications\PostSuccessFullNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAfterProductPost
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProductPost $event)
    {
        $event->user->notify(new PostSuccessFullNotification($event->product));
    }
}
