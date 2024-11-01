<?php

namespace Database\Seeders;

use App\Models\KycDocument;
use Illuminate\Database\Seeder;

class KycDocumentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kyc_documents = ["International Passport", "Driver's license", "State ID card", "Social Security Number (SSN)", "Social Insurance Number (SIN)", "Proof of Address:", "Utility bill (electric, gas, water)", "Bank statement", "Lease agreement", "Government correspondence", "Birth Certificate:", "Citizenship or Immigration Documents", "Permanent resident card", "Visa ", "Employee ID", "Student ID"];

        foreach ($kyc_documents as $kyc_document) {
            if (KycDocument::where('name', $kyc_document)->exists()) {
                return;
            }
            KycDocument::create(['name' => $kyc_document]);
        }

    }
}
