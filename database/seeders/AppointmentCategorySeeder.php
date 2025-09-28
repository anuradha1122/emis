<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppointmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('appointment_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $data = array(
            array('id' => '1','description' => 'Graduate Teachers (All graduates including post-graduates)','name' => 'Graduate'),
            array('id' => '2','description' => 'Trained Teachers ( Including National Teaching Sciences Diploma / Science-Maths two year diploma/ Distant teacher training)','name' => 'Trained'),
            array('id' => '3','description' => 'Teachers who are not trained and others with two year/three year diplomas','name' => 'Other Diplomas'),
            array('id' => '4','description' => 'Probationary/Trainee  teachers who are not enlisted to Sri Lanka Teaching Service','name' => 'Probationary'),
            array('id' => '5','description' => 'Teachers who receive allowances on contract-basis and other methods.','name' => 'Contract-basis')
        );
        
        DB::table('appointment_categories')->insert($data);
    }
}
