<?php

use Illuminate\Support\Facades\Schedule;

// Schedule the command to run daily at 1 AM
Schedule::command('ads:deactivate-expired')->dailyAt('01:00');
