<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('positions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $data = [
            ['id' => '1', 'name' => 'Teacher', 'workPlaceCatagoryId' => 1],
            ['id' => '2', 'name' => 'Sectional Head', 'workPlaceCatagoryId' => 1],
            ['id' => '3', 'name' => 'Assistant Principal', 'workPlaceCatagoryId' => 1],
            ['id' => '4', 'name' => 'Vice Principal', 'workPlaceCatagoryId' => 1],
            ['id' => '5', 'name' => 'Principal', 'workPlaceCatagoryId' => 1],
            ['id' => '6', 'name' => 'Divisional Director', 'workPlaceCatagoryId' => 1],
            ['id' => '7', 'name' => 'Zonal Director', 'workPlaceCatagoryId' => 1],
            ['id' => '8', 'name' => 'Additional Zonal director', 'workPlaceCatagoryId' => 1],
            ['id' => '9', 'name' => 'Zonal Assistant Director/Deputy Director Planning', 'workPlaceCatagoryId' => 1],
            ['id' => '10', 'name' => 'Zonal Assistant Director/Deputy Director Administration', 'workPlaceCatagoryId' => 1],
            ['id' => '11', 'name' => 'Zonal Assistant Director/Deputy Establishment', 'workPlaceCatagoryId' => 1],
            ['id' => '12', 'name' => 'Zonal Assistant Director/Deputy Education administration', 'workPlaceCatagoryId' => 1],
            ['id' => '13', 'name' => 'Zonal Assistant Director/Deputy Director Development - I', 'workPlaceCatagoryId' => 1],
            ['id' => '14', 'name' => 'Zonal Assistant Director/Deputy Director Development - II', 'workPlaceCatagoryId' => 1],
            ['id' => '15', 'name' => 'Zonal Assistant Director/Deputy Director(Primary Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '16', 'name' => 'Zonal Assistant Director/Deputy Director(13 Years Mandatory Education II)', 'workPlaceCatagoryId' => 1],
            ['id' => '17', 'name' => 'Zonal Assistant Director/Deputy Director(Special Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '18', 'name' => 'Zonal Assistant Director/Deputy Director(Non-Formal Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '19', 'name' => 'Zonal Assistant Director/Deputy Director(Pirivena Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '20', 'name' => 'Zonal Assistant Director/Deputy Director(Tamil Medium & Plantation Schools)', 'workPlaceCatagoryId' => 1],
            ['id' => '21', 'name' => 'Zonal Assistant Director/Deputy Director(Disaster Management)', 'workPlaceCatagoryId' => 1],
            ['id' => '22', 'name' => 'Zonal Assistant Director/Deputy Director(School health and Nutrition)', 'workPlaceCatagoryId' => 1],
            ['id' => '23', 'name' => 'Zonal Assistant Director/Deputy Director(Career Guidance and Vocational Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '24', 'name' => 'Zonal Assistant Director/Deputy Director(Mathematics)', 'workPlaceCatagoryId' => 1],
            ['id' => '25', 'name' => 'Zonal Assistant Director/Deputy Director(Science)', 'workPlaceCatagoryId' => 1],
            ['id' => '26', 'name' => 'Zonal Assistant Director/Deputy Director(English)', 'workPlaceCatagoryId' => 1],
            ['id' => '27', 'name' => 'Zonal Assistant Director/Deputy Director(Technology & Technical Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '28', 'name' => 'Zonal Assistant Director/Deputy Director(Primary Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '29', 'name' => 'Zonal Assistant Director/Deputy Director(First Language (Sinhala) and Second Language)', 'workPlaceCatagoryId' => 1],
            ['id' => '30', 'name' => 'Zonal Assistant Director/Deputy Director(First Language (Tamil) and Second Language)', 'workPlaceCatagoryId' => 1],
            ['id' => '31', 'name' => 'Zonal Assistant Director/Deputy Director(Bilingual Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '32', 'name' => 'Zonal Assistant Director/Deputy Director(Religious Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '33', 'name' => 'Zonal Assistant Director/Deputy Director(Agriculture)', 'workPlaceCatagoryId' => 1],
            ['id' => '34', 'name' => 'Zonal Assistant Director/Deputy Director(Commerce, Business studies and Accounting education)', 'workPlaceCatagoryId' => 1],
            ['id' => '35', 'name' => 'Zonal Assistant Director/Deputy Director(School Library Development)', 'workPlaceCatagoryId' => 1],
            ['id' => '36', 'name' => 'Zonal Assistant Director/Deputy Director(Co-curricular & Extra Curricular Activities)', 'workPlaceCatagoryId' => 1],
            ['id' => '37', 'name' => 'Zonal Assistant Director/Deputy Director(Sports and Physical Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '38', 'name' => 'Zonal Assistant Director/Deputy Director(Aesthetic Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '39', 'name' => 'Zonal Assistant Director/Deputy Director(Social Cohesion)', 'workPlaceCatagoryId' => 1],
            ['id' => '40', 'name' => 'Zonal Assistant Director/Deputy Director(Civic Education and Social Sciences)', 'workPlaceCatagoryId' => 1],
            ['id' => '41', 'name' => 'Zonal Assistant Director/Deputy Director(ICT)', 'workPlaceCatagoryId' => 1],
            ['id' => '42', 'name' => 'Provincial Director', 'workPlaceCatagoryId' => 1],
            ['id' => '43', 'name' => 'Additional Provincial Director (Administration)', 'workPlaceCatagoryId' => 1],
            ['id' => '44', 'name' => 'Additional Provincial Director (Development)', 'workPlaceCatagoryId' => 1],
            ['id' => '45', 'name' => 'Additional Provincial Director (FInance)/Chief Accountant', 'workPlaceCatagoryId' => 1],
            ['id' => '46', 'name' => 'Assistant Director/Deputy Director Planning', 'workPlaceCatagoryId' => 1],
            ['id' => '47', 'name' => 'Assistant Director/Deputy Director Administration', 'workPlaceCatagoryId' => 1],
            ['id' => '48', 'name' => 'Assistant Director/Deputy Director Development', 'workPlaceCatagoryId' => 1],
            ['id' => '49', 'name' => 'Assistant Director/Deputy Director School affairs', 'workPlaceCatagoryId' => 1],
            ['id' => '50', 'name' => 'Provincial Assistant Director/Deputy Director Planning', 'workPlaceCatagoryId' => 1],
            ['id' => '51', 'name' => 'Provincial Assistant Director/Deputy Director Administration', 'workPlaceCatagoryId' => 1],
            ['id' => '52', 'name' => 'Provincial Assistant Director/Deputy Establishment', 'workPlaceCatagoryId' => 1],
            ['id' => '53', 'name' => 'Provincial Assistant Director/Deputy Education administration', 'workPlaceCatagoryId' => 1],
            ['id' => '54', 'name' => 'Provincial Assistant Director/Deputy Director Development - I', 'workPlaceCatagoryId' => 1],
            ['id' => '55', 'name' => 'Provincial Assistant Director/Deputy Director Development - II', 'workPlaceCatagoryId' => 1],
            ['id' => '56', 'name' => 'Provincial Assistant Director/Deputy Director(Primary Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '57', 'name' => 'Provincial Assistant Director/Deputy Director(13 Years Mandatory Education II)', 'workPlaceCatagoryId' => 1],
            ['id' => '58', 'name' => 'Provincial Assistant Director/Deputy Director(Special Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '59', 'name' => 'Provincial Assistant Director/Deputy Director(Non-Formal Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '60', 'name' => 'Provincial Assistant Director/Deputy Director(Pirivena Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '61', 'name' => 'Provincial Assistant Director/Deputy Director(Tamil Medium & Plantation Schools)', 'workPlaceCatagoryId' => 1],
            ['id' => '62', 'name' => 'Provincial Assistant Director/Deputy Director(Disaster Management)', 'workPlaceCatagoryId' => 1],
            ['id' => '63', 'name' => 'Provincial Assistant Director/Deputy Director(School health and Nutrition)', 'workPlaceCatagoryId' => 1],
            ['id' => '64', 'name' => 'Provincial Assistant Director/Deputy Director(Career Guidance and Vocational Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '65', 'name' => 'Provincial Assistant Director/Deputy Director(Mathematics)', 'workPlaceCatagoryId' => 1],
            ['id' => '66', 'name' => 'Provincial Assistant Director/Deputy Director(Science)', 'workPlaceCatagoryId' => 1],
            ['id' => '67', 'name' => 'Provincial Assistant Director/Deputy Director(English)', 'workPlaceCatagoryId' => 1],
            ['id' => '68', 'name' => 'Provincial Assistant Director/Deputy Director(Technology & Technical Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '69', 'name' => 'Provincial Assistant Director/Deputy Director(Primary Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '70', 'name' => 'Provincial Assistant Director/Deputy Director(First Language (Sinhala) and Second Language)', 'workPlaceCatagoryId' => 1],
            ['id' => '71', 'name' => 'Provincial Assistant Director/Deputy Director(First Language (Tamil) and Second Language)', 'workPlaceCatagoryId' => 1],
            ['id' => '72', 'name' => 'Provincial Assistant Director/Deputy Director(Bilingual Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '73', 'name' => 'Provincial Assistant Director/Deputy Director(Religious Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '74', 'name' => 'Provincial Assistant Director/Deputy Director(Agriculture)', 'workPlaceCatagoryId' => 1],
            ['id' => '75', 'name' => 'Provincial Assistant Director/Deputy Director(Commerce, Business studies and Accounting education)', 'workPlaceCatagoryId' => 1],
            ['id' => '76', 'name' => 'Provincial Assistant Director/Deputy Director(School Library Development)', 'workPlaceCatagoryId' => 1],
            ['id' => '77', 'name' => 'Provincial Assistant Director/Deputy Director(Co-curricular & Extra Curricular Activities)', 'workPlaceCatagoryId' => 1],
            ['id' => '78', 'name' => 'Provincial Assistant Director/Deputy Director(Sports and Physical Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '79', 'name' => 'Provincial Assistant Director/Deputy Director(Aesthetic Education)', 'workPlaceCatagoryId' => 1],
            ['id' => '80', 'name' => 'Provincial Assistant Director/Deputy Director(Social Cohesion)', 'workPlaceCatagoryId' => 1],
            ['id' => '81', 'name' => 'Provincial Assistant Director/Deputy Director(Civic Education and Social Sciences)', 'workPlaceCatagoryId' => 1],
            ['id' => '82', 'name' => 'Provincial Assistant Director/Deputy Director(ICT)', 'workPlaceCatagoryId' => 1],
            ['id' => '100', 'name' => 'Education Secretary', 'workPlaceCatagoryId' => 1],
            ['id' => '90', 'name' => 'Sipthathu Coordinator', 'workPlaceCatagoryId' => 1],
            ['id' => '101', 'name' => 'Senior Assistant Secretary', 'workPlaceCatagoryId' => 1],
            ['id' => '200', 'name' => 'Sipthathu Data Officer', 'workPlaceCatagoryId' => 1],
          ];


        DB::table('positions')->insert($data);
    }
}
