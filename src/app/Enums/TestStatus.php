<?php

namespace App\Enums;

enum TestStatus:string {
    case PENDING = 'Pending';
    case ONGOING = 'Ongoing';
    case COMPLETED = 'Completed';
    case ELIMINATED = 'Eliminated';
}
