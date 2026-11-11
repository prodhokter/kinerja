<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\DisputeCategory;
use App\Enums\ExtortionCategory;
use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Http\Requests\StoreDisputeReportRequest;
use App\Http\Requests\StoreExtortionReportRequest;
use App\Models\AidProgram;
use App\Models\Region;
use App\Models\Report;
use App\Models\ReportUpdate;
use App\Models\Shipment;
use App\Services\PiiMasker;
use App\Services\TicketCodeFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function choose(): View
    {
        return view('reports.choose');
    }

    public function createExtortion(Request $request): View
    {
        $regions = Region::orderBy('name')->get(['id', 'name', 'bps_code', 'level']);
        $categories = ExtortionCategory::cases();
        $prefillResi = $request->query('resi');

        $shipment = null;
        $prefillRegionId = null;
        if (! empty($prefillResi)) {
            $shipment = Shipment::with(['beneficiary.region', 'program', 'agency'])
                ->where('receipt_code', $prefillResi)
                ->first();
            if ($shipment && $shipment->beneficiary) {
                $prefillRegionId = $shipment->beneficiary->region_id;
            }
        }

        return view('reports.extortion-create', compact('regions', 'categories', 'prefillResi', 'shipment', 'prefillRegionId'));
    }

    public function storeExtortion(
        StoreExtortionReportRequest $request,
        TicketCodeFactory $ticketFactory,
        PiiMasker $piiMasker
    ): RedirectResponse {
        $validated = $request->validated();

        $ticketCode = $ticketFactory->makeTicketCode();
        $secretCode = $ticketFactory->makeSecretCode();
        $secretHash = $ticketFactory->hashSecret($secretCode);

        /** @var string $rawDescription */
        $rawDescription = $validated['description'];
        $cleanDescription = $piiMasker->mask($rawDescription);

        /** @var int $regionId */
        $regionId = $validated['region_id'];

        /** @var string $category */
        $category = $validated['category'];

        /** @var int|null $amountClaimed */
        $amountClaimed = $validated['amount_claimed'] ?? null;

        $report = Report::create([
            'ticket_code' => $ticketCode,
            'secret_hash' => $secretHash,
            'type' => ReportType::Extortion,
            'category' => $category,
            'region_id' => $regionId,
            'amount_claimed' => $amountClaimed,
            'description' => $cleanDescription,
            'status' => ReportStatus::Submitted,
            'is_simulated' => true,
        ]);

        ReportUpdate::create([
            'report_id' => $report->id,
            'status' => ReportStatus::Submitted,
            'message' => 'Laporan telah diterima oleh sistem dan masuk ke dalam antrean telaah verifikasi.',
            'is_public' => true,
        ]);

        $request->session()->flash('ticket_info', [
            'ticket_code' => $ticketCode,
            'secret_code' => $secretCode,
            'type' => 'extortion',
        ]);

        return redirect()->route('report.success');
    }

    public function createDispute(): View
    {
        $regions = Region::orderBy('name')->get(['id', 'name', 'bps_code', 'level']);
        $programs = AidProgram::where('is_active', true)->get(['id', 'code', 'name']);
        $categories = DisputeCategory::cases();

        return view('reports.dispute-create', compact('regions', 'programs', 'categories'));
    }

    public function storeDispute(
        StoreDisputeReportRequest $request,
        TicketCodeFactory $ticketFactory,
        PiiMasker $piiMasker
    ): RedirectResponse {
        $validated = $request->validated();

        $ticketCode = $ticketFactory->makeTicketCode();
        $secretCode = $ticketFactory->makeSecretCode();
        $secretHash = $ticketFactory->hashSecret($secretCode);

        /** @var string $rawDescription */
        $rawDescription = $validated['description'];
        /** @var string $targetName */
        $targetName = $validated['target_beneficiary_name'];

        $cleanDescription = $piiMasker->mask(sprintf(
            "Sanggahan terhadap penerima: %s.\nKeterangan: %s",
            $targetName,
            $rawDescription
        ));

        /** @var int $regionId */
        $regionId = $validated['region_id'];
        /** @var int $programId */
        $programId = $validated['program_id'];
        /** @var string $category */
        $category = $validated['category'];

        $report = Report::create([
            'ticket_code' => $ticketCode,
            'secret_hash' => $secretHash,
            'type' => ReportType::Dispute,
            'category' => $category,
            'region_id' => $regionId,
            'program_id' => $programId,
            'description' => $cleanDescription,
            'status' => ReportStatus::Submitted,
            'is_simulated' => true,
        ]);

        ReportUpdate::create([
            'report_id' => $report->id,
            'status' => ReportStatus::Submitted,
            'message' => 'Sanggahan kelayakan penerima telah dicatat untuk ditelaah bersama data kependudukan.',
            'is_public' => true,
        ]);

        $request->session()->flash('ticket_info', [
            'ticket_code' => $ticketCode,
            'secret_code' => $secretCode,
            'type' => 'dispute',
        ]);

        return redirect()->route('report.success');
    }

    public function success(Request $request): View|RedirectResponse
    {
        $info = $request->session()->get('ticket_info');

        if (! is_array($info)) {
            return redirect()->route('report.choose');
        }

        return view('reports.success', [
            'ticketCode' => $info['ticket_code'],
            'secretCode' => $info['secret_code'],
            'type' => $info['type'],
        ]);
    }
}
