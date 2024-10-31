<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {//action: 
        // 'donation', 'petititon', 'capture'. estado: 'in_progress', 'accepted', 'denied', 'fixed', 'unfixable' 'assigned_to_fix'
        Schema::create('items', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 80);
            $table->bigInteger('stock');
            $table->timestamps();
        });

        //ItemMovement: will be use as pivot to be able to use enums
        Schema::create('item_user', function (Blueprint $table): void {
            $table->id();

            $table->string('type', 16);
            $table->string('status', 16)->nullable();
        
            $table->tinyInteger('quantity')->default(1);
            //use to keep track of the movements related to one another
            //this could be used to distinguish between petition made and settlement
            //but given that is just a binary state is enough to use the timestamps for distinguishment
            $table->unsignedBigInteger('group_id')->nullable();

            $table->string('observations', 255)->nullable();
            $table->string('item_name', 80)->nullable();
            //user related to the action {reparator|settler}
            $table->foreignId('related_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();//created_at, updated_at
        });

        Schema::create('reagents', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 80);
            $table->string('unit', 32);
            $table->string('group', 16);
            $table->string('chemical_formula', 16);
            $table->boolean('visible');
            $table->string('max_per_petition', 12, 3)->default(99.999);
            $table->decimal('stock', 12, 3, true);//999 999 999 999.999
            $table->timestamps();
        });

        //ReagentMovement
        Schema::create('reagent_user', function (Blueprint $table): void {
            $table->id();
            $table->string('type', 16);
            $table->string('status', 16)->nullable();
            //donation specific fields
            $table->string('photo_url')->nullable();
            $table->string('container', 16)->nullable();
            $table->float('weight')->nullable();
            $table->date('expiration')->nullable();
            $table->string('condition', 16)->nullable();
            $table->string('proc_fac', 80)->nullable();
            $table->string('proc_lab', 80)->nullable();
            $table->string('cretib', 30)->nullable();
            //common
            $table->string('chemical_state', 16)->nullable();
            $table->decimal('quantity', 9, 3, true);//999 999. 999
            $table->string('unit', 32);
            //petition specific
            $table->string('comment')->nullable();
            //petition by name: reagent_name and reagent_id are excluded one of the other
            $table->string('reagent_name', 80)->nullable();
            //user who settle the petition
            $table->foreignId('settler_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reagent_id')->nullable()
                    ->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->string('key', 100)->unique();
            $table->string('value', 255); 
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table): void {
            $table->id();
            $table->string('file_path');
            $table->date('from');
            $table->date('to');
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('report_user', function (Blueprint $table) {
            $table->id();
            $table->string('status', 12);//generated, sent, archived, deleted
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('report_id')->constrained()->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reagent_user');
        Schema::dropIfExists('reagents');
        Schema::dropIfExists('item_user');
        Schema::dropIfExists('items');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('report_user');
        Schema::dropIfExists('reports');

    }
};

// public function deleteReport($reportId)
    // {
    //     $report = Report::find($reportId);
        
    //     if ($report) {
    //         // Delete the associated PDF file
    //         $pdfPath = storage_path('app/reports/' . $report->file_name); // Adjust path as necessary
    //         if (file_exists($pdfPath)) {
    //             unlink($pdfPath); // Delete the file
    //         }

    //         // Update the report status to deleted
    //         $report->status = 'deleted';
    //         $report->save();
    //     }
    // }
