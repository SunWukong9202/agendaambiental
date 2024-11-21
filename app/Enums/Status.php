<?php 

namespace App\Enums;

enum Status: string {
    use Transformers;

    case Accepted = 'accepted';
    case In_Progress = 'in progress';
    case Rejected = 'rejected';

    //stage Capture
    // case Accepted = 'accepted';
    case Repairable = 'repairable';

    //repair_completed
    case Successful = 'successful';
    case Failed = 'failed';
    
    case RepairLog = 'repair log';

    case Unassigned = 'unassigned';
    
    case Assigned = 'assigned';

    private static function resolve(Movement|string|null $movement): Movement|null
    {
        return $movement = $movement instanceof Movement
            ? $movement
            : Movement::tryFrom($movement);
    }

    //used to retrieve all status options for a given movement
    public static function by(Movement|string|null $movement, Status $exclude = null): array
    {
        $movement = self::resolve($movement);        

        return match($movement) {
            Movement::Petition, Movement::Petition_By_Name => [
                self::Accepted, self::Rejected, self::In_Progress
            ],

            Movement::Capture => [
                self::Accepted, self::Repairable,
            ],

            Movement::Reparation => [
                self::Repairable,
                self::Assigned, self::Unassigned,
                self::RepairLog, self::Successful,
                self::Failed,
            ],
            default => [
                self::Accepted
            ],
        };
    }
    

    //used to retreive next options given a previous status
    public static function next(Status|string $previous, $avoidLoop = false): array
    {
        return match($previous) {
            self::In_Progress => [
                self::Accepted, self::Rejected
            ],
            self::Assigned => match(true) {
                $avoidLoop =>  [
                    self::RepairLog, self::Successful,
                    self::Failed
                ],  
                //no avoid loop
                !$avoidLoop => [
                    self::Assigned, self::Unassigned
                ]
            },

            self::Unassigned => [
                self::Assigned, self::Unassigned
            ],

            self::RepairLog => [
                self::RepairLog, self::Successful,
                self::Failed
            ],
        };
    }


    public function getTranslatedLabel(): string
    {
        return ucfirst(str_replace('-', ' ', __($this->value)));
    }

    public function getBagdeColor(): string
    {
        return match($this) {
            self::Accepted, self::Successful => 'success',
            self::In_Progress, self::Assigned => 'warning',
            self::Rejected, self::Failed,
            self::Unassigned => 'danger',
            self::RepairLog => 'info',
            default => 'gray'
        };
    }

    public function getIcon()
    {
        return match($this) {
            self::Accepted, self::Successful => 'heroicon-m-check-circle',
            self::In_Progress => 'heroicon-m-clock',
            self::Rejected, self::Failed,
            self::Unassigned => 'heroicon-m-x-circle',
            self::Repairable => 'heroicon-m-wrench',
            self::Assigned => 'heroicon-m-clipboard-document',
            self::RepairLog => 'heroicon-m-clipboard-document-list',
            default => null
        };
    }
}