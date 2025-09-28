<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IllnessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Disable FK checks → safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('illnesses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = array(
            array('id' => '1','name' => 'Asthma','active' => 1),
            array('id' => '2','name' => 'Chronic Bronchitis','active' => 1),
            array('id' => '3','name' => 'Cystic Fibrosis','active' => 1),
            array('id' => '4','name' => 'Epilepsy','active' => 1),
            array('id' => '5','name' => 'Migraine (Chronic)','active' => 1),
            array('id' => '6','name' => 'Autism Spectrum Disorder (ASD)','active' => 1),
            array('id' => '7','name' => 'Cerebral Palsy','active' => 1),
            array('id' => '8','name' => 'Diabetes (Type 1 & Type 2)','active' => 1),
            array('id' => '9','name' => 'Thyroid Disorders (Hypothyroidism/Hyperthyroidism)','active' => 1),
            array('id' => '10','name' => 'Hypertension (High Blood Pressure)','active' => 1),
            array('id' => '11','name' => 'Congenital Heart Disease','active' => 1),
            array('id' => '12','name' => 'Irritable Bowel Syndrome (IBS)','active' => 1),
            array('id' => '13','name' => 'Crohn s Disease','active' => 1),
            array('id' => '14','name' => 'Ulcerative Colitis','active' => 1),
            array('id' => '15','name' => 'Lupus','active' => 1),
            array('id' => '16','name' => 'Rheumatoid Arthritis','active' => 1),
            array('id' => '17','name' => 'Psoriasis','active' => 1),
            array('id' => '18','name' => 'Celiac Disease','active' => 1),
            array('id' => '19','name' => 'Tuberculosis (Latent or Active)','active' => 1),
            array('id' => '20','name' => 'HIV/AIDS','active' => 1),
            array('id' => '21','name' => 'Hepatitis B or C','active' => 1),
            array('id' => '22','name' => 'Scoliosis','active' => 1),
            array('id' => '23','name' => 'Osteoarthritis','active' => 1),
            array('id' => '24','name' => 'Juvenile Rheumatoid Arthritis','active' => 1),
            array('id' => '25','name' => 'Anemia (Chronic)','active' => 1),
            array('id' => '26','name' => 'Hemophilia','active' => 1),
            array('id' => '27','name' => 'Thalassemia','active' => 1),
            array('id' => '28','name' => 'Chronic Kidney Disease (CKD)','active' => 1),
            array('id' => '29','name' => 'Nephrotic Syndrome','active' => 1),
            array('id' => '30','name' => 'Depression (Chronic)','active' => 1),
            array('id' => '31','name' => 'Anxiety Disorders','active' => 1),
            array('id' => '32','name' => 'ADHD (Attention-Deficit/Hyperactivity Disorder)','active' => 1),
            array('id' => '33','name' => 'Other','active' => 1)
        );

        DB::table('illnesses')->insert($data);
    }
}
