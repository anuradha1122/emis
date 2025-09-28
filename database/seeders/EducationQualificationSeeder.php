<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EducationQualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks and truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('education_qualifications')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['name' => 'Below O/L', 'qualificationTypeId' => 1],
            ['name' => 'O/L or Equal', 'qualificationTypeId' => 1],
            ['name' => 'A/L or Equal', 'qualificationTypeId' => 1],
            ['name' => 'Bachelor of Science (BSc)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Arts (BA)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Commerce (BCom)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Business Administration (BBA)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Fine Arts (BFA)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Education (BEd)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Engineering (BEng)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Technology (BTech)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Computer Applications (BCA)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Medicine and Bachelor of Surgery (MBBS)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Laws (LLB)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Architecture (BArch)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Pharmacy (BPharm)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Design (BDes)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Social Work (BSW)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Dental Surgery (BDS)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Science in Nursing (BSc Nursing)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Veterinary Science (BVSc)', 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Public Administration (BPA)', 'qualificationTypeId' => 2],
            ['name' => 'Master of Science (MSc)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Arts (MA)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Commerce (MCom)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Business Administration (MBA)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Fine Arts (MFA)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Education (MEd)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Engineering (MEng)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Technology (MTech)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Computer Applications (MCA)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Laws (LLM)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Architecture (MArch)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Social Work (MSW)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Pharmacy (MPharm)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Public Health (MPH)', 'qualificationTypeId' => 3],
            ['name' => 'Master of Public Administration (MPA)', 'qualificationTypeId' => 3],
            ['name' => 'Doctor of Philosophy (PhD)', 'qualificationTypeId' => 4],
            ['name' => 'Doctor of Medicine (MD)', 'qualificationTypeId' => 4],
            ['name' => 'Master of Philosophy (MPhil)', 'qualificationTypeId' => 4],
            ['name' => 'Doctor of Education (EdD)', 'qualificationTypeId' => 4],
            ['name' => 'Doctor of Science (DSc)', 'qualificationTypeId' => 4],
            ['name' => 'Doctor of Laws (LLD)', 'qualificationTypeId' => 4],
            ['name' => 'Doctor of Business Administration (DBA)', 'qualificationTypeId' => 4],
            ['name' => 'Doctor of Pharmacy (PharmD)', 'qualificationTypeId' => 4],
            ['name' => 'Bachelor of Library and Information Science (BLIS)', 'qualificationTypeId' => 4],
            ['name' => 'Master of Library and Information Science (MLIS)', 'qualificationTypeId' => 5],
            ['name' => 'Doctor of Veterinary Medicine (DVM)', 'qualificationTypeId' => 5],
            ['name' => 'Juris Doctor (JD)', 'qualificationTypeId' => 5],
            ['name' => 'Associate of Science (AS)', 'qualificationTypeId' => 5],
            ['name' => 'Associate of Arts (AA)', 'qualificationTypeId' => 5],
        ];

        DB::table('education_qualifications')->insert($data);
    }
}
