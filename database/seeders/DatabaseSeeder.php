<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\CRETIB;
use App\Enums\Movement;
use App\Enums\Role;
use App\Enums\Status;
use App\Models\CMUser;
use App\Models\Event;
use App\Models\Item;
use App\Models\Pivots\Delivery;
use App\Models\Pivots\Donation;
use App\Models\Pivots\ItemMovement;
use App\Models\Reagent;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Waste;
use Carbon\Carbon;
use Database\Factories\ItemFactory;
use Database\Factories\Pivots\ItemMovementFactory;
use Database\Factories\ReagentFactory;
use Database\Factories\WasteFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class
        ]);

        $moduleUsers = $this->createModuleUsers();

        $superAdmin = $moduleUsers['superAdmin'];
        //superadmin is inside admins too
        $admins = $moduleUsers['admins'];
        $capturists = $moduleUsers['capturists'];
        $technicians = $moduleUsers['technicians'];
        $interns = $moduleUsers['interns'];
        $externs = $moduleUsers['externs'];

        //We set the locale of all cm users
        CMUser::all()->each(fn($user) => $user->update([
            'locale' => 'es', //all have by default spanish
        ]));

        $panelUsers = [ 
            ...$admins,  
            ...$capturists
        ];

        $events = Event::factory()
            ->count(5)
            ->withUser(fake()->randomElement($admins))
            ->create();

        $reagents = collect(ReagentFactory::preloaded)
            ->map(fn ($reagent) => 
                Reagent::factory()
                    ->withUser(fake()->randomElement($admins))
                    ->create($reagent)
            );
        
        $items = collect(ItemFactory::preloaded)
            ->map(fn ($name) => 
                Item::factory()->create([
                    'name' => $name,
                    'cm_user_id' => fake()
                        ->randomElement($admins)
                        ->id
                ])
            );

        //ITEM CAPTURES/PETITIONS: type,status{accepte,reparable}, 
        // ItemMovementFactory::$technicians = $technicians;

        // collect($panelUsers)->each(function ($user) use ($items) {
        //     foreach (range(1, 3) as $i) {
        //         ItemMovement::factory()
        //             // ->withTechnicians($techs)
        //             ->withCapture($user, $items)
        //             ->create();
        //     }
        // });

        //superadmin impersonates a technician
        // ItemMovementFactory::$technicians = collect([$superAdmin, $admins->first()]);

        // collect($admins)->each(function ($user) use ($items) {
        //     //just for testing purpose we add to superadmin
        //     foreach(range(2, 4) as $i) {
        //         ItemMovement::factory()
        //             // ->withTechnicians(collect([$superAdmin]))
        //             ->withCapture($user, $items)
        //             ->create();
        //     }
        // });
        
        //normal users without any role/privelige
        // $interns->each(function ($user) use ($items, $admins) {
        //     foreach (range(1, rand(2, 3)) as $i) {
        //         ItemMovement::factory()
        //             ->withAdministratives($admins)
        //             ->withPetition($user, $items)
        //             ->create();
        //     } 
        // });

        $wastes = collect(WasteFactory::preloaded)->map(function ($category) {
            return Waste::factory()->create([
                'category' => $category
            ]);
        });

        //SEED EVENT DONATION
        //type{bool}, books[taken|donated]{0-255}, quantity{0-999.999}, [event,cm_user,donator][_id]{fk}
        $users = [...$externs, ...$interns];
        $events->each(function ($event) use ($users, $capturists, $wastes) {
            foreach($users as $user) {
                foreach(range(1, 3) as $i) {
                    $donation = Donation::factory()
                    ->setCapturist(fake()->randomElement($capturists))
                    ->setDonator($user);
                
                    if(rand(0,1)) {
                        $donation = $donation->bookDonation();
                    } else {
                        $donation = $donation->wasteDonation(fake()->randomElement($wastes));
                    }

                    $donation = $donation->make();
                    $event->donations()->create($donation->toArray());
                }
            }
        });
        
        //SEED EVENT DELIVERIES
        //quantity, waste_id,cm_user_id,supplier_id,event_id
        $suppliers = Supplier::factory()->count(5)->create();
        $suppliers->each(function ($supplier) use ($wastes, $events, $admins) {
            foreach(range(1, 11) as $i) {
                Delivery::factory()->create([
                    'quantity' => fake()->randomFloat(3, 1, 3),
                    'waste_id' => fake()->randomElement($wastes)->id,
                    'event_id' => fake()->randomElement($events)->id,
                    'supplier_id' => $supplier->id,
                    'cm_user_id' => fake()->randomElement($admins)->id,
                ]);
            }
        });
    }

    public function createModuleUsers()
    {
        $superAdmin = User::factory()->create([
            'email' => 'super-admin@gmail.com'
        ]);

        $superAdmin = CMUser::factory()->create([
            'user_id' => $superAdmin->id
        ]);

        $superAdmin->assignRole(Role::SuperAdmin);

        $admin = User::factory()->create([
            'email' => 'admin@gmail.com'
        ]);

        $admin = CMUser::factory()->create([
            'user_id' => $admin->id
        ]);

        $admin->assignRole(Role::Admin);

        $admins = User::factory()->count(4)->create();
        $admins = $admins->map(fn ($admin) => 
            CMUser::factory()->create([
                'user_id' => $admin->id
            ])
        );

        $admins->each(fn($admin) => 
            $admin->assignRole(Role::Admin)
        );

        //Capturists
        $capturist = User::factory()->create([
            'email' => 'capturist@gmail.com'
        ]);

        $capturist = CMUser::factory()->create([
            'user_id' => $capturist->id
        ]);

        $capturist->assignRole(Role::Capturist);

        $capturists = User::factory()->count(5)->create();

        $capturists = $capturists->map(fn ($user) => 
            CMUser::factory()->create([
                'user_id' => $user->id
            ])
        );
        
        $capturists->each(fn ($user) =>
            $user->assignRole(Role::Capturist)
        );

        //technicians
        $technician = User::factory()->create([
            'email' => 'technician@gmail.com'
        ]);

        $technician = CMUser::factory()->create([
            'user_id' => $technician->id
        ]);

        $technician->assignRole(Role::RepairTechnician);

        $technicians = User::factory()->count(5)->create();
        $technicians = $technicians->map(fn (User $user) =>     CMUser::factory()->create([
                'user_id' => $user->id
            ])
        );

        $technicians->each(fn($cm_user) => 
            $cm_user->assignRole(Role::RepairTechnician)
        );

        //we are just using the users to fill data of cmusers
        //to create extern users
        $externs = User::factory()->count(10)->make();
        $externs = $externs->map(fn ($user) => CMUser::factory()->create(
            $user->only('name', 'gender', 'email')
        ));

        //intern users
        $interns = User::factory()->count(10)->create();
        $interns = $interns->map(fn ($user) => CMUser::factory()->create([
            'user_id' => $user->id
        ]));

        $admins->push($admin, $superAdmin);

        $capturists->push($capturist);

        $technicians->push($technician);

        return [
            'superAdmin' => $superAdmin,
            'admins' => $admins,
            'capturists' => $capturists,
            'technicians' => $technicians,
            'interns' => $interns,
            'externs' => $externs
        ];
    }

}