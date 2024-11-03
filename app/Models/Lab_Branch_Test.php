<?php

namespace App\Models;

use App\Models\Courier;
use App\Models\Diagnose;
use App\Models\SponserTest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lab_Branch_Test extends Model
{
    use HasFactory;
    protected $table='lab_tests';

    // Indicate that the model does not have an auto-incrementing ID
    public $incrementing = false;

    // Specify the primary key fields
    protected $primaryKey = ['test_id', 'lab_id'];

    protected $fillable=['lab_id', 'test_id', 'price', 'points', 'notes','discount_points','courier_id','has_courier','test_tot'];
    protected $keyType = 'int';

public function sponsor(){
    return $this->belongsTo(SponserTest::class,'sponser_id');
}
     // Define the relationship
     public function labOrders()
     {
         return $this->hasMany(LabOrder::class, 'test_id', 'test_id'); // Adjust based on actual foreign key in LabOrder
     }
     public function courier()
     {
         return $this->belongsTo(Courier::class, 'courier_id')->withDefault();
     }
     public function test() {
        return $this->belongsTo(Test::class, 'test_id');
    }

    

    //  In Eloquent relationships, specifying the foreign key and local key parameters helps Laravel understand how to relate two models. Let’s break down what these parameters mean and whether they are required:
//         LabOrder::class: The related model that this model has a relationship with.
// 'test_id': The foreign key in the LabOrder model that references the test_id in the Lab_Branch_Test model.
// 'test_id': The local key in the Lab_Branch_Test model that the foreign key refers to.
// When to Use Foreign Key and Local Key
// Specify Foreign Key and Local Key:

// You specify these parameters when:

// Your foreign key in the LabOrder model (test_id) does not match the primary key in the Lab_Branch_Test model (test_id).
// You are using composite keys or non-standard column names
    
    protected $casts = [
        'points' => 'integer',
    ];

       // If you are using composite primary keys, you might need to handle them explicitly in your queries
       public function getKeyName()
       {
           return $this->primaryKey;
       }
}
