<?php

namespace Database\Factories\Pivots;

use App\Models\Item;
use App\Enums\Movement;
use App\Enums\Role;
use App\Enums\Status;
use App\Models\CMUser;
use App\Models\Pivots\ItemMovement;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\ItemFactory;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pivots\ItemMovement>
 */
class ItemMovementFactory extends Factory
{
    public static $technicians;
    protected $administratives;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => Status::In_Progress,
            'observations' => fake()->text(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (ItemMovement $movement) {
            if($movement->type == Movement::Capture && $movement->status == Status::Reparable) {
                $movement->update([
                    'group_id' => $movement->id,
                ]);

                return fake()->boolean()
                    ? $this->createRepairProcess($movement)
                    : null;
            } 

            if(fake()->boolean() && in_array($movement->type, [Movement::Petition, Movement::Petition_By_Name])) {
                $this->administratives = $this->administratives ?? CMUser::role(Role::Admin)->get();
                $administrative = fake()->randomElement($this->administratives);

                $data = [
                    'status' => fake()->randomElement([
                        Status::Accepted, Status::Rejected 
                    ]),
                    'related_id' => $administrative->id,
                    'updated_at' => Carbon::now()->addHours(rand(12, 48))
                ];

                if($movement->item_name) {
                    $item = Item::firstOrCreate(
                        ['name' => $movement->item_name],
                        ['cm_user_id' => $administrative->id]
                    );
                    
                    $data['item_id'] = $item->id;
                }

                $movement->update($data);
            }
        });
    }

    public function withAdministratives($users)
    {
        $this->administratives = $users;
        return $this->state(function () {
            return [];
        });
    }    

    public function withCapture(CMUser $user, $items)
    {
        return $this->state(function () use ($user, $items) {
            return [
                'cm_user_id' => $user->id,
                'type' => Movement::Capture,
                'status' => fake()->randomElement([
                    Status::Accepted, Status::Reparable
                ]),
                'item_id' => fake()->randomElement($items)->id,
            ];
        });
    }

    public function withPetition(CMUser $user, $items)
    {
        $name = fake()->boolean() 
            ? fake()->randomElement(ItemFactory::forNamedPetitions)
            : null;

        return $this->state(function () use ($user, $items, $name) {
            $data = [
                'cm_user_id' => $user->id,
                'type' => Movement::Petition,
                'status' => Status::In_Progress,
            ];

            if(isset($name)) {
                $data['type'] = Movement::Petition_By_Name;
                $data['item_name'] = $name;
            } else {
                $data['item_id'] = fake()->randomElement($items)->id;
            }

            return $data;
        });
    }

    public function withTechnicians($technicians)
    {
        $this->technicians = $technicians;

        return $this->state(fn() => []);
    }

    protected function createRepairProcess(ItemMovement $captureMovement)
    {
        // Get the technicians if not already set
        // $this->technicians = $this->technicians ;//?? CMUser::role(Role::RepairTechnician)->get();
        // dump(self::$technicians);

        // if(!self::$technicians) return;

        $availableTechnicians = self::$technicians->shuffle(); // Shuffle for randomness

        $baseDate = Carbon::now()->addMinutes(rand(5, 15));
        $initialTechnician = $availableTechnicians->pop(); // Take the first technician

        // Update capture movement with the initial technician
        $captureMovement->update([
            'related_id' => $initialTechnician->id
        ]);

        // Assignment
        $assignment = $captureMovement->replicate()->fill([
            'type' => Movement::Assignment,
            'status' => Status::Assigned,
            'created_at' => $baseDate,
            'related_id' => $initialTechnician->id,
        ]);
        $assignment->save();

        // Un/assignments loop with unique technicians each time
        // foreach (range(0, 1) as $i) {
            // Unassign
            $baseDate = $baseDate->addMinutes(rand(5, 15));

            $unassign = $assignment->replicate()->fill([
                'status' => Status::Unassigned,
                'created_at' => $baseDate,
            ]);
            
            $unassign->save();

            // Reassign with a new technician (ensuring uniqueness)
            $baseDate = $baseDate->addMinutes(rand(5, 15));
            if ($availableTechnicians->isEmpty()) {
                $availableTechnicians = self::$technicians->shuffle(); // Refill and shuffle if exhausted
            }

            $technician = $availableTechnicians->pop();

            $assignment = $assignment->replicate()->fill([
                'related_id' => $technician->id,
                'status' => Status::Assigned,
                'created_at' => $baseDate,
            ]);
            $assignment->save();
        // }

        // Update capture movement with the last assigned technician
        $captureMovement->update([
            'related_id' => $assignment->related_id
        ]);

        // Halt the process randomly
        if (fake()->boolean()) return;

        // Repair start
        $baseDate = $baseDate->addMinutes(rand(5, 15));
        $repairStart = $assignment->replicate()->fill([
            'type' => Movement::Repair_Started,
            'status' => Status::In_Progress,
            'created_at' => $baseDate,
        ]);
        $repairStart->save();

        // Repair logs
        foreach (range(0, rand(2, 5)) as $j) {
            $baseDate = $baseDate->addMinutes(rand(5, 15));
            $repairLog = $repairStart->replicate()->fill([
                'type' => Movement::Repair_Log,
                'status' => Status::repairmentTry,
                'observations' => fake()->text(),
                'created_at' => $baseDate,
            ]);
            $repairLog->save();
        }

        // Repair completion
        $baseDate = $baseDate->addMinutes(rand(5, 15));
        $completion = $repairStart->replicate()->fill([
            'type' => Movement::Repair_Completed,
            'status' => fake()->randomElement(Status::by(Movement::Repair_Completed)),
            'created_at' => $baseDate,
        ]);
        $completion->save();
    }
}



    // public function movement(Movement $movement, $items, $user = null): Factory
    // {
    //     return $this->state(function () use ($movement, $items, $user): array {
    //         $data = [
    //             'type' => $movement,
    //             'status' => fake()->randomElement(Status::by($movement)),  
    //         ];

    //         if($data['type'] == Movement::Petition_By_Name) {
    //             $data['item_name'] = fake()->name() . fake()->bothify('###');
    //             if($data['status'] == Status::Accepted) {
    //                 Item::factory()->create([
    //                     'name' => $data['item_name'],
    //                     'cm_user_id' => $user->id
    //                 ]);
    //             }
    //         } else {
    //             $data['item_id'] = fake()->randomElement($items);
    //         }

    //         return $data;
    //     });
    // }

    // public function setItem(Item $item): Factory
    // {
    //     return $this->state(function ($args) use ($item) {
    //         return [
    //             'item_id' => $item->id
    //         ];
    //     });
    // }

    // public function setGroupId(ItemMovement $movement): Factory
    // {
    //     return $this->state(function ($attrs) use ($movement) {
    //         return [
    //             'group_id' => $movement->group_id
    //         ];
    //     });
    // }

    // public function setReparator(CMUser $user): Factory
    // {
    //     return $this->state(function ($attrs) use ($user) {
    //         return [
    //             'related_id' => $user->id,
    //         ];
    //     });
    // }

    // public function setUser(CMUser $user): Factory
    // {
    //     return $this->state(function ($attrs) use ($user) {
    //         return [
    //             'cm_user_id' => $user->id,
    //         ];
    //     });
    // }