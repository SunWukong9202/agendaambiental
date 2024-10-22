<?php 

namespace App\Enums;

enum Status: string {
    case Accepted = 'accepted';
    case In_Progress = 'in progress';
    case Rejected = 'rejected';

    case Fixable = 'fixable';
    case Unfixable = 'unfixable';
    case Unassigned = 'unassigned';

    public static function by(Movement $movement): array
    {
        return match($movement) {
            Movement::Petition => [
                self::Accepted, self::In_Progress, self::Rejected
            ],
            Movement::Capture, Movement::Repair_Completed => [
                self::Fixable, self::Unfixable
            ],
            Movement::Assignment, Movement::Repair_Started => [
                self::In_Progress
            ],
            default => [],
        };
    }
}