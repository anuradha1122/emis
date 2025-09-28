<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfessionalQualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Temporarily disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('professional_qualifications')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            // Foundational Teacher Qualifications
            ['name' => 'National Diploma in Teaching (College of Education)', 'qualificationLevel' => 1, 'qualificationTypeId' => 1],
            ['name' => 'Higher National Diploma (HND)', 'qualificationLevel' => 1, 'qualificationTypeId' => 1],
            ['name' => 'National Diploma/Diploma', 'qualificationLevel' => 1, 'qualificationTypeId' => 1],
            ['name' => 'Teacher Training Certificate (Full-time)', 'qualificationLevel' => 1, 'qualificationTypeId' => 1],
            ['name' => 'Teacher Training Certificate (Distance Learning)', 'qualificationLevel' => 1, 'qualificationTypeId' => 1],
            ['name' => 'Certificate in Teacher Librarianship', 'qualificationLevel' => 1, 'qualificationTypeId' => 1],
            ['name' => 'Diploma in Teacher Librarianship', 'qualificationLevel' => 1, 'qualificationTypeId' => 1],
        
            // Undergraduate-Level Qualifications
            ['name' => 'Bachelor of Education (B.Ed)', 'qualificationLevel' => 2, 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Arts in Education (BA Ed)', 'qualificationLevel' => 2, 'qualificationTypeId' => 2],
            ['name' => 'Bachelor of Science in Education (BSc Ed)', 'qualificationLevel' => 2, 'qualificationTypeId' => 2],
            ['name' => 'Diploma in Education', 'qualificationLevel' => 2, 'qualificationTypeId' => 2],
        
            // Postgraduate Diplomas
            ['name' => 'Post Graduate Diploma in Education (PGDE)', 'qualificationLevel' => 3, 'qualificationTypeId' => 3],
            ['name' => 'Post Graduate Diploma in Educational Administration', 'qualificationLevel' => 3, 'qualificationTypeId' => 3],
            ['name' => 'Post Graduate Diploma in Teaching English as a Second Language (TESOL)', 'qualificationLevel' => 3, 'qualificationTypeId' => 3],
            ['name' => 'Post Graduate Diploma in Teacher Librarianship', 'qualificationLevel' => 3, 'qualificationTypeId' => 3],
            ['name' => 'Post Graduate Diploma in Special Education', 'qualificationLevel' => 3, 'qualificationTypeId' => 3],
        
            // Master's Degrees
            ['name' => 'Master of Education (M.Ed)', 'qualificationLevel' => 4, 'qualificationTypeId' => 4],
            ['name' => 'Master of Arts in Education (MA Ed)', 'qualificationLevel' => 4, 'qualificationTypeId' => 4],
            ['name' => 'Master of Arts in Teacher Education (M.A.T.E)', 'qualificationLevel' => 4, 'qualificationTypeId' => 4],
            ['name' => 'Master of Science in Education Management (MSc EdMgt)', 'qualificationLevel' => 4, 'qualificationTypeId' => 4],
            ['name' => 'Master in Teacher Librarianship (MTL)', 'qualificationLevel' => 4, 'qualificationTypeId' => 4],
            ['name' => 'Master of Social Work in Education (MSW Ed)', 'qualificationLevel' => 4, 'qualificationTypeId' => 4],
        
            // Doctoral-Level Qualifications
            ['name' => 'Doctorate in Education (Ph.D.)', 'qualificationLevel' => 5, 'qualificationTypeId' => 5],
            ['name' => 'Doctor of Philosophy in Education (Ph.D. Ed)', 'qualificationLevel' => 5, 'qualificationTypeId' => 5],
            ['name' => 'Doctor of Education (Ed.D)', 'qualificationLevel' => 5, 'qualificationTypeId' => 5],
            ['name' => 'Doctor of Educational Leadership', 'qualificationLevel' => 5, 'qualificationTypeId' => 5],
        
            // Specializations in Education
            ['name' => 'Diploma in Special Education', 'qualificationLevel' => 3, 'qualificationTypeId' => 6],
            ['name' => 'Certificate in Special Education', 'qualificationLevel' => 1, 'qualificationTypeId' => 6],
            ['name' => 'Diploma in Montessori Teaching', 'qualificationLevel' => 3, 'qualificationTypeId' => 6],
            ['name' => 'Certificate in Montessori Teaching', 'qualificationLevel' => 1, 'qualificationTypeId' => 6],
            ['name' => 'Diploma in Early Childhood Education', 'qualificationLevel' => 3, 'qualificationTypeId' => 6],
            ['name' => 'Certificate in Early Childhood Education', 'qualificationLevel' => 1, 'qualificationTypeId' => 6],
            ['name' => 'Diploma in Inclusive Education', 'qualificationLevel' => 3, 'qualificationTypeId' => 6],
            ['name' => 'Certificate in Inclusive Education', 'qualificationLevel' => 1, 'qualificationTypeId' => 6],
        
            // Leadership and Administration
            ['name' => 'Diploma in Educational Administration', 'qualificationLevel' => 3, 'qualificationTypeId' => 7],
            ['name' => 'Certificate in Educational Leadership', 'qualificationLevel' => 2, 'qualificationTypeId' => 7],
            ['name' => 'Master of Educational Leadership', 'qualificationLevel' => 4, 'qualificationTypeId' => 7],
            ['name' => 'Post Graduate Diploma in Education Management', 'qualificationLevel' => 3, 'qualificationTypeId' => 7],
        
            // Psychology and Counseling
            ['name' => 'Diploma in Educational Psychology', 'qualificationLevel' => 3, 'qualificationTypeId' => 8],
            ['name' => 'Certificate in Educational Psychology', 'qualificationLevel' => 1, 'qualificationTypeId' => 8],
            ['name' => 'Certificate in Child Psychology', 'qualificationLevel' => 1, 'qualificationTypeId' => 8],
        
            // Language and TESOL Qualifications
            ['name' => 'Diploma in Teaching English as a Second Language', 'qualificationLevel' => 3, 'qualificationTypeId' => 9],
            ['name' => 'Certificate in Teaching English as a Foreign Language (TEFL)', 'qualificationLevel' => 2, 'qualificationTypeId' => 9],
            ['name' => 'Certificate in English Language Teaching to Adults (CELTA)', 'qualificationLevel' => 2, 'qualificationTypeId' => 9],
            ['name' => 'Diploma in English Language Teaching to Adults (DELTA)', 'qualificationLevel' => 3, 'qualificationTypeId' => 9],
        
            // Modern and Digital Teaching
            ['name' => 'Certificate in Digital Pedagogy', 'qualificationLevel' => 2, 'qualificationTypeId' => 10],
            ['name' => 'Certificate in Online Teaching Methods', 'qualificationLevel' => 2, 'qualificationTypeId' => 10],
            ['name' => 'Diploma in Learning and Development', 'qualificationLevel' => 3, 'qualificationTypeId' => 10],
        
            // Curriculum and Assessment
            ['name' => 'Certificate in Classroom Assessment', 'qualificationLevel' => 2, 'qualificationTypeId' => 11],
            ['name' => 'Diploma in Curriculum Development', 'qualificationLevel' => 3, 'qualificationTypeId' => 11],
            ['name' => 'Post Graduate Diploma in Curriculum Studies', 'qualificationLevel' => 3, 'qualificationTypeId' => 11],
        ];
        

        DB::table('professional_qualifications')->insert($data);
    }
}
