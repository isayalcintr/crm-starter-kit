<?php

namespace App\Http\Controllers\Offer;

use App\Enums\Offer\StageEnum;
use App\Enums\Offer\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Offer\ChangeStageRequest;
use App\Http\Requests\Offer\StoreRequest;
use App\Http\Requests\Offer\UpdateRequest;
use App\Models\Offer\Offer;
use App\Objects\Offer\OfferFilterObject;
use App\Objects\Offer\OfferObject;
use App\Services\Offer\OfferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class OfferController extends Controller
{
    protected OfferService $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle('Teklifler');
        return view('pages.offer.index');
    }

    public function listWithDatatable(DataTables $dataTables, Request $request)
    {
        $filter = (new OfferFilterObject())->initFromRequest($request);
        return $dataTables->eloquent($this->offerService->list($filter))->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        setPageTitle("Teklif Ekle");
        return view('pages.offer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $object = new OfferObject();
            $object->initFromRequest($request)
                ->setStage(StageEnum::OFFER->value)
                ->setStatus(StatusEnum::PROCESSING->value)
                ->setCreatedBy(Auth::id());
            $this->offerService->store($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        setPageTitle("Teklif Düzenle - " . $offer->getAttribute('code'));
        if ($offer->getAttribute('status') != StatusEnum::PROCESSING->value)
            return view('errors.not-valid', ['message' => "Bu teklif düzenlemek için uygun değil!"]);
        View::share(['_pageData' => [
            "offer" => $offer,
            "items" => $offer->items()->with('product')->get(),
        ]]);
        return view('pages.offer.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Offer $offer)
    {
        try {
            $object = new OfferObject();
            $object->initFromRequest($request)->setOffer($offer)->setUpdatedBy(Auth::id())
                ->setIgnoredProperties(
                    'status',
                    'stage',
                    'created_by',
                    'deleted_by',
                    'deleted_date',
                    'approved_by',
                    'approved_date',
                    'cancelled_by',
                    'cancelled_date',
                );
            $this->offerService->update($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    public function cancel(Offer $offer)
    {
        try {
            if ($offer->getAttribute('status') != StatusEnum::PROCESSING->value) {
                throw new \Exception("Bu teklif iptal etmek için uygun değil!");
            }
            $object = new OfferObject();
            $object->setOffer($offer)->setStatus(StatusEnum::REJECTED->value)
                ->setCancelledBy(Auth::id())
                ->setCancelledDate(date('Y-m-d H:i:s'));
            $this->offerService->cancel($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde iptal edildi!'], 200);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    public function changeStage(ChangeStageRequest $request,Offer $offer)
    {
        try {
            $stage = $request->input('stage');
            $object = new OfferObject();
            $object->setOffer($offer)->setStage($stage)
                ->setApprovedBy(Auth::id())
                ->setApprovedDate(date('Y-m-d H:i:s'));
            $this->offerService->changeStage($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde değiştilidi!'], 200);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        try {
            if ($offer->getAttribute('status') != StatusEnum::PROCESSING->value)
                throw new \Exception("Bu teklif silmek için uygun değil!");
            $this->offerService->destroy((new OfferObject())->setOffer($offer)->setDeletedBy(Auth::id()));
            return response()->json(['status' => 200, 'message' => 'Teklif silindi!'], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
}
