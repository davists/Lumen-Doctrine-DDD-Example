<?php

namespace Application\Core\Events;

use Illuminate\Queue\SerializesModels;

abstract class Event
{
    use SerializesModels;
}
