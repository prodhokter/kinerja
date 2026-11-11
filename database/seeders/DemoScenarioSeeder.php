<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\AgencyType;
use App\Enums\EligibilityStatus;
use App\Enums\ExtortionCategory;
use App\Enums\RegionLevel;
use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Enums\ShipmentStatus;
use App\Enums\UserRole;
use App\Models\Agency;
use App\Models\AidAllocation;
use App\Models\AidProgram;
use App\Models\Beneficiary;
use App\Models\PovertyStat;
use App\Models\Region;
use App\Models\Report;
use App\Models\ReportUpdate;
use App\Models\Shipment;
use App\Models\ShipmentEvent;
use App\Models\User;
use App\Services\TicketCodeFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoScenarioSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hierarchical Pilot Regions & Central Java Regencies
        $jateng = Region::firstOrCreate(
            ['bps_code' => '33'],
            [
                'name' => 'Jawa Tengah',
                'level' => RegionLevel::Province,
                'population' => 37000000,
                'is_pilot' => false,
            ]
        );

        $banyumas = Region::firstOrCreate(
            ['bps_code' => '3302'],
            [
                'name' => 'Kabupaten Banyumas',
                'level' => RegionLevel::Regency,
                'parent_id' => $jateng->id,
                'population' => 1800000,
                'is_pilot' => true,
            ]
        );

        $cilacap = Region::firstOrCreate(
            ['bps_code' => '3301'],
            [
                'name' => 'Kabupaten Cilacap',
                'level' => RegionLevel::Regency,
                'parent_id' => $jateng->id,
                'population' => 1950000,
                'is_pilot' => false,
            ]
        );

        $purbalingga = Region::firstOrCreate(
            ['bps_code' => '3303'],
            [
                'name' => 'Kabupaten Purbalingga',
                'level' => RegionLevel::Regency,
                'parent_id' => $jateng->id,
                'population' => 1020000,
                'is_pilot' => false,
            ]
        );

        $banjarnegara = Region::firstOrCreate(
            ['bps_code' => '3304'],
            [
                'name' => 'Kabupaten Banjarnegara',
                'level' => RegionLevel::Regency,
                'parent_id' => $jateng->id,
                'population' => 1030000,
                'is_pilot' => false,
            ]
        );

        $kebumen = Region::firstOrCreate(
            ['bps_code' => '3305'],
            [
                'name' => 'Kabupaten Kebumen',
                'level' => RegionLevel::Regency,
                'parent_id' => $jateng->id,
                'population' => 1380000,
                'is_pilot' => false,
            ]
        );

        $patikraja = Region::firstOrCreate(
            ['bps_code' => '330211'],
            [
                'name' => 'Kecamatan Patikraja',
                'level' => RegionLevel::District,
                'parent_id' => $banyumas->id,
                'population' => 60000,
                'is_pilot' => false,
            ]
        );

        $kedungwringin = Region::firstOrCreate(
            ['bps_code' => '3302112001'],
            [
                'name' => 'Desa Kedungwringin',
                'level' => RegionLevel::Village,
                'parent_id' => $patikraja->id,
                'population' => 5200,
                'is_pilot' => true,
            ]
        );

        // 2. Poverty Stats (BPS Riil)
        PovertyStat::updateOrCreate(
            ['region_id' => $banyumas->id, 'year' => 2026],
            ['poverty_percent' => 12.84, 'poor_population' => 231120, 'source' => 'BPS Kabupaten Banyumas 2026']
        );
        PovertyStat::updateOrCreate(
            ['region_id' => $cilacap->id, 'year' => 2026],
            ['poverty_percent' => 11.02, 'poor_population' => 214890, 'source' => 'BPS Kabupaten Cilacap 2026']
        );
        PovertyStat::updateOrCreate(
            ['region_id' => $purbalingga->id, 'year' => 2026],
            ['poverty_percent' => 15.30, 'poor_population' => 156060, 'source' => 'BPS Kabupaten Purbalingga 2026']
        );
        PovertyStat::updateOrCreate(
            ['region_id' => $banjarnegara->id, 'year' => 2026],
            ['poverty_percent' => 15.20, 'poor_population' => 156560, 'source' => 'BPS Kabupaten Banjarnegara 2026']
        );
        PovertyStat::updateOrCreate(
            ['region_id' => $kebumen->id, 'year' => 2026],
            ['poverty_percent' => 16.34, 'poor_population' => 225492, 'source' => 'BPS Kabupaten Kebumen 2026']
        );

        // 3. Agencies
        $dinsos = Agency::firstOrCreate(
            ['slug' => 'dinsos-banyumas'],
            [
                'name' => 'Dinas Sosial Kabupaten Banyumas',
                'type' => AgencyType::RegencySocialOffice,
                'region_id' => $banyumas->id,
                'is_simulated' => true,
            ]
        );

        $pos = Agency::firstOrCreate(
            ['slug' => 'pos-purwokerto'],
            [
                'name' => 'PT Pos Indonesia KC Purwokerto',
                'type' => AgencyType::Distributor,
                'region_id' => $banyumas->id,
                'is_simulated' => true,
            ]
        );

        // 4. Aid Programs
        $pkh = AidProgram::firstOrCreate(
            ['code' => 'PKH'],
            [
                'name' => 'Program Keluarga Harapan',
                'description' => 'Bantuan sosial tunai bersyarat bagi keluarga rentan kemiskinan dengan komponen kesehatan, pendidikan, dan kesejahteraan.',
                'cash_value' => 750000,
                'goods_value' => 0,
                'goods_description' => null,
                'frequency' => 'quarterly',
                'is_active' => true,
            ]
        );

        $bpnt = AidProgram::firstOrCreate(
            ['code' => 'BPNT'],
            [
                'name' => 'Bantuan Pangan Non-Tunai (Sembako)',
                'description' => 'Bantuan pangan komoditas sembako bergizi untuk pemenuhan pangan pokok keluarga penerima manfaat.',
                'cash_value' => 0,
                'goods_value' => 200000,
                'goods_description' => 'Beras Premium 10 kg, Telur Ayam 1 kg',
                'frequency' => 'monthly',
                'is_active' => true,
            ]
        );

        // 5. Aid Allocations (for Anomaly Calculation)
        AidAllocation::updateOrCreate(
            ['region_id' => $banyumas->id, 'program_id' => $pkh->id, 'period' => '2026-10'],
            ['quota_recipients' => 30000, 'actual_recipients' => 29500, 'budget' => 22500000000, 'is_simulated' => true]
        );
        AidAllocation::updateOrCreate(
            ['region_id' => $cilacap->id, 'program_id' => $pkh->id, 'period' => '2026-10'],
            ['quota_recipients' => 12000, 'actual_recipients' => 11800, 'budget' => 9000000000, 'is_simulated' => true]
        );
        AidAllocation::updateOrCreate(
            ['region_id' => $purbalingga->id, 'program_id' => $pkh->id, 'period' => '2026-10'],
            ['quota_recipients' => 45000, 'actual_recipients' => 44200, 'budget' => 33750000000, 'is_simulated' => true]
        );
        AidAllocation::updateOrCreate(
            ['region_id' => $banjarnegara->id, 'program_id' => $pkh->id, 'period' => '2026-10'],
            ['quota_recipients' => 20500, 'actual_recipients' => 20000, 'budget' => 15375000000, 'is_simulated' => true]
        );
        AidAllocation::updateOrCreate(
            ['region_id' => $kebumen->id, 'program_id' => $pkh->id, 'period' => '2026-10'],
            ['quota_recipients' => 29000, 'actual_recipients' => 28500, 'budget' => 21750000000, 'is_simulated' => true]
        );

        // 6. Beneficiaries (Masked Simulation Data)
        /** @var string $pepper */
        $pepper = config('hakwarga.nik_pepper', 'simulated-pepper');

        $ben1 = Beneficiary::firstOrCreate(
            ['public_id' => '01JB00000000000000000DEMO1'],
            [
                'region_id' => $kedungwringin->id,
                'program_id' => $pkh->id,
                'nik_hash' => hash_hmac('sha256', '3302112001990001', $pepper),
                'masked_name' => 'S*** W***',
                'masked_address' => 'RT 02/RW 03',
                'eligibility_status' => EligibilityStatus::Eligible,
                'is_simulated' => true,
            ]
        );

        $ben2 = Beneficiary::firstOrCreate(
            ['public_id' => '01JB00000000000000000DEMO2'],
            [
                'region_id' => $kedungwringin->id,
                'program_id' => $bpnt->id,
                'nik_hash' => hash_hmac('sha256', '3302112001990002', $pepper),
                'masked_name' => 'A*** H***',
                'masked_address' => 'RT 01/RW 01',
                'eligibility_status' => EligibilityStatus::Eligible,
                'is_simulated' => true,
            ]
        );

        $ben3 = Beneficiary::firstOrCreate(
            ['public_id' => '01JB00000000000000000DEMO3'],
            [
                'region_id' => $kedungwringin->id,
                'program_id' => $pkh->id,
                'nik_hash' => hash_hmac('sha256', '3302112001990003', $pepper),
                'masked_name' => 'M*** T***',
                'masked_address' => 'RT 04/RW 02',
                'eligibility_status' => EligibilityStatus::Eligible,
                'is_simulated' => true,
            ]
        );

        // 7. Gold Demo Shipment 1: In Delivery (Step 4 of 5)
        $ship1 = Shipment::updateOrCreate(
            ['receipt_code' => 'HWR-PKH-2610-DEMO01'],
            [
                'beneficiary_id' => $ben1->id,
                'program_id' => $pkh->id,
                'agency_id' => $pos->id,
                'period' => '2026-10',
                'entitled_cash' => 750000,
                'entitled_goods_value' => 0,
                'entitled_goods_description' => null,
                'current_status' => ShipmentStatus::InDelivery,
                'distribution_point' => 'Balai Desa Kedungwringin',
                'is_simulated' => true,
            ]
        );

        ShipmentEvent::where('shipment_id', $ship1->id)->delete();
        ShipmentEvent::insert([
            [
                'shipment_id' => $ship1->id,
                'status' => ShipmentStatus::DataCollected->value,
                'occurred_at' => Carbon::now()->subDays(6)->setHour(9)->setMinute(0),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Pendataan DTKS wilayah Desa Kedungwringin selesai dicatat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship1->id,
                'status' => ShipmentStatus::EligibilityVerified->value,
                'occurred_at' => Carbon::now()->subDays(4)->setHour(14)->setMinute(30),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Kelayakan komponen balita & lansia terverifikasi sah.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship1->id,
                'status' => ShipmentStatus::Scheduled->value,
                'occurred_at' => Carbon::now()->subDays(2)->setHour(10)->setMinute(15),
                'agency_id' => $pos->id,
                'user_id' => null,
                'note' => 'Jadwal distribusi ditetapkan ke Kantor Pos Cabang Pembantu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship1->id,
                'status' => ShipmentStatus::InDelivery->value,
                'occurred_at' => Carbon::now()->subHours(18)->setMinute(45),
                'agency_id' => $pos->id,
                'user_id' => null,
                'note' => 'Dana bansos dalam perjalanan kurir resmi menuju titik salur Balai Desa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 8. Gold Demo Shipment 2: Scheduled (Step 3 of 5)
        $ship2 = Shipment::updateOrCreate(
            ['receipt_code' => 'HWR-BPNT-2610-DEMO02'],
            [
                'beneficiary_id' => $ben2->id,
                'program_id' => $bpnt->id,
                'agency_id' => $pos->id,
                'period' => '2026-10',
                'entitled_cash' => 0,
                'entitled_goods_value' => 200000,
                'entitled_goods_description' => 'Beras Premium 10 kg, Telur Ayam 1 kg',
                'current_status' => ShipmentStatus::Scheduled,
                'distribution_point' => 'E-Warong Amanah Kedungwringin',
                'is_simulated' => true,
            ]
        );

        ShipmentEvent::where('shipment_id', $ship2->id)->delete();
        ShipmentEvent::insert([
            [
                'shipment_id' => $ship2->id,
                'status' => ShipmentStatus::DataCollected->value,
                'occurred_at' => Carbon::now()->subDays(5)->setHour(10)->setMinute(0),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Pendataan kuota sembako alokasi Oktober 2026.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship2->id,
                'status' => ShipmentStatus::EligibilityVerified->value,
                'occurred_at' => Carbon::now()->subDays(3)->setHour(11)->setMinute(30),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Verifikasi desil 1 selesai tanpa sanggahan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship2->id,
                'status' => ShipmentStatus::Scheduled->value,
                'occurred_at' => Carbon::now()->subDays(1)->setHour(15)->setMinute(0),
                'agency_id' => $pos->id,
                'user_id' => null,
                'note' => 'Pengemasan komoditas sembako dan jadwal ambil di E-Warong terdekat disiapkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 9. Gold Demo Shipment 3: Received at Point (Step 5 of 5)
        $ship3 = Shipment::updateOrCreate(
            ['receipt_code' => 'HWR-PKH-2610-DEMO03'],
            [
                'beneficiary_id' => $ben3->id,
                'program_id' => $pkh->id,
                'agency_id' => $dinsos->id,
                'period' => '2026-10',
                'entitled_cash' => 600000,
                'entitled_goods_value' => 0,
                'entitled_goods_description' => null,
                'current_status' => ShipmentStatus::ReceivedAtPoint,
                'distribution_point' => 'Balai Desa Kedungwringin',
                'is_simulated' => true,
            ]
        );

        ShipmentEvent::where('shipment_id', $ship3->id)->delete();
        ShipmentEvent::insert([
            [
                'shipment_id' => $ship3->id,
                'status' => ShipmentStatus::DataCollected->value,
                'occurred_at' => Carbon::now()->subDays(7)->setHour(8)->setMinute(30),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Pendataan awal penerima PKH lansia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship3->id,
                'status' => ShipmentStatus::EligibilityVerified->value,
                'occurred_at' => Carbon::now()->subDays(5)->setHour(13)->setMinute(0),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Verifikasi NIK dan status kependudukan valid.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship3->id,
                'status' => ShipmentStatus::Scheduled->value,
                'occurred_at' => Carbon::now()->subDays(4)->setHour(9)->setMinute(0),
                'agency_id' => $pos->id,
                'user_id' => null,
                'note' => 'Jadwal serah terima di Balai Desa Kedungwringin disahkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship3->id,
                'status' => ShipmentStatus::InDelivery->value,
                'occurred_at' => Carbon::now()->subDays(2)->setHour(8)->setMinute(0),
                'agency_id' => $pos->id,
                'user_id' => null,
                'note' => 'Dana disalurkan melalui petugas juru bayar kantor pos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shipment_id' => $ship3->id,
                'status' => ShipmentStatus::ReceivedAtPoint->value,
                'occurred_at' => Carbon::now()->subDay()->setHour(11)->setMinute(20),
                'agency_id' => $dinsos->id,
                'user_id' => null,
                'note' => 'Bantuan telah diterima utuh di Balai Desa Kedungwringin tanpa potongan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 10. Simulated Reports for Scorecard SLA Evaluation
        $dinsosCilacap = Agency::firstOrCreate(
            ['slug' => 'dinsos-cilacap'],
            [
                'name' => 'Dinas Sosial Kabupaten Cilacap',
                'type' => AgencyType::RegencySocialOffice,
                'region_id' => $cilacap->id,
                'is_simulated' => true,
            ]
        );

        $ticketFactory = new TicketCodeFactory;

        // Seed 6 reports for Dinsos Banyumas (mostly fast response & resolved -> Grade A)
        for ($i = 1; $i <= 6; $i++) {
            $created = Carbon::now()->subDays(15 - $i);
            $firstResp = $created->copy()->addHours(12 + ($i * 4)); // <= 72 hours
            $resolved = $i <= 5 ? $created->copy()->addDays(5 + $i) : null; // <= 14 days

            $rep = Report::updateOrCreate(
                ['ticket_code' => sprintf('HWT-2026-BMS%03d', $i)],
                [
                    'secret_hash' => $ticketFactory->hashSecret(sprintf('BMS%02d-TEST-CODE', $i)),
                    'type' => ReportType::Extortion,
                    'category' => ExtortionCategory::AdminFee->value,
                    'region_id' => $banyumas->id,
                    'agency_id' => $dinsos->id,
                    'amount_claimed' => 20000 * $i,
                    'description' => sprintf('Laporan simulasi penarikan biaya administrasi nomor %d di wilayah Banyumas.', $i),
                    'status' => $resolved ? ReportStatus::Resolved : ReportStatus::InProgress,
                    'first_response_at' => $firstResp,
                    'resolved_at' => $resolved,
                    'is_simulated' => true,
                    'created_at' => $created,
                    'updated_at' => $resolved ?? $firstResp,
                ]
            );

            ReportUpdate::firstOrCreate(
                ['report_id' => $rep->id, 'status' => ReportStatus::InProgress],
                [
                    'message' => 'Petugas Dinsos Banyumas telah melakukan verifikasi ke kantor desa.',
                    'is_public' => true,
                    'created_at' => $firstResp,
                ]
            );
        }

        // Seed 5 reports for PT Pos (mixed response -> Grade B)
        for ($i = 1; $i <= 5; $i++) {
            $created = Carbon::now()->subDays(20 - ($i * 2));
            $firstResp = $i <= 4 ? $created->copy()->addHours(36) : $created->copy()->addHours(96); // 1 late
            $resolved = $i <= 3 ? $created->copy()->addDays(8) : null;

            Report::updateOrCreate(
                ['ticket_code' => sprintf('HWT-2026-POS%03d', $i)],
                [
                    'secret_hash' => $ticketFactory->hashSecret(sprintf('POS%02d-TEST-CODE', $i)),
                    'type' => ReportType::Extortion,
                    'category' => ExtortionCategory::CashDeduction->value,
                    'region_id' => $banyumas->id,
                    'agency_id' => $pos->id,
                    'amount_claimed' => 50000,
                    'description' => sprintf('Laporan keterlambatan dan selisih uang bansos kantor pos nomor %d.', $i),
                    'status' => $resolved ? ReportStatus::Resolved : ReportStatus::InProgress,
                    'first_response_at' => $firstResp,
                    'resolved_at' => $resolved,
                    'is_simulated' => true,
                    'created_at' => $created,
                    'updated_at' => $resolved ?? $firstResp,
                ]
            );
        }

        // Seed 5 reports for Dinsos Cilacap (slower response -> Grade C)
        for ($i = 1; $i <= 5; $i++) {
            $created = Carbon::now()->subDays(25 - ($i * 2));
            $firstResp = $i <= 2 ? $created->copy()->addHours(48) : $created->copy()->addHours(110); // 3 late
            $resolved = $i === 1 ? $created->copy()->addDays(12) : null;

            Report::updateOrCreate(
                ['ticket_code' => sprintf('HWT-2026-CLP%03d', $i)],
                [
                    'secret_hash' => $ticketFactory->hashSecret(sprintf('CLP%02d-TEST-CODE', $i)),
                    'type' => ReportType::Extortion,
                    'category' => ExtortionCategory::CardWithheld->value,
                    'region_id' => $cilacap->id,
                    'agency_id' => $dinsosCilacap->id,
                    'amount_claimed' => 0,
                    'description' => sprintf('Laporan penahanan kartu KKS di wilayah Cilacap nomor %d.', $i),
                    'status' => $resolved ? ReportStatus::Resolved : ReportStatus::Submitted,
                    'first_response_at' => $firstResp,
                    'resolved_at' => $resolved,
                    'is_simulated' => true,
                    'created_at' => $created,
                    'updated_at' => $resolved ?? $firstResp,
                ]
            );
        }

        // 11. Demo Admin Users for Filament Panel
        $demoPassword = bcrypt('admin123');

        User::updateOrCreate(
            ['email' => 'admin@hakwarga.test'],
            [
                'name' => 'Administrator Utama',
                'password' => $demoPassword,
                'role' => UserRole::SuperAdmin,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'moderator@hakwarga.test'],
            [
                'name' => 'Moderator Publik HakWarga',
                'password' => $demoPassword,
                'role' => UserRole::Moderator,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'petugas.bms@hakwarga.test'],
            [
                'name' => 'Petugas Dinsos Banyumas',
                'password' => $demoPassword,
                'role' => UserRole::AgencyOfficer,
                'agency_id' => $dinsos->id,
                'email_verified_at' => now(),
            ]
        );
    }
}
