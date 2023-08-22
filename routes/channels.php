<?php

use App\Broadcasting\UserUpdatesChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user-updates', UserUpdatesChannel::class);
