<?php

namespace App\Enums;

enum TestAttemptStatus:string {
    case ATTEMPTED = 'Attempted';
    case FAILED = 'Failed To Answer';
    case ELIMINATED = 'Eliminated';
}
