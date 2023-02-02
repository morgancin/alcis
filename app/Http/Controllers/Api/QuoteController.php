<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Quote;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\QuoteRequest;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //@var \App\Models\Api\Quote
            $oQuotes = Quote::get();

            if ($oQuotes->count() > 0)
                return response()->json($oQuotes, Response::HTTP_OK);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuoteRequest $request)
    {
        $success = true;
        DB::beginTransaction();

        try	{
            //@var \App\Models\Quote
            $oQuote = Quote::create([
                                "total" => $request->total,
                                "user_id" => $request->user_id,
                                "sub_total" => $request->sub_total,
                                "description" => $request->description,
                                "activity_id" => $request->activity_id,
                                //"expire_at" => $request->expire_at,
                                //"discount_amount" => $request->discount_amount,
                                //"discount_percent" => $request->discount_percent,
                            ]);
            if($oQuote)
            {
                if(is_array($request->quote_items))
                {
                    if(count($request->quote_items) > 0)
                    {
                        $oQuote->items->create($request->quote_items);
                    }
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($success === true) {
            DB::commit();

            return response()->json([
                'message' => __('api.messages.added')
            ], Response::HTTP_OK);
        }
    }

    /**
     * Display the document quote.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function document_quote()
    {
        try {
            //$name=DB::table('invoices')->where('id_payments',$id)->first();
            //$file = storage_path('facturas/'. env('RUC') .'-' . $name->type_document.'-'.$name->serie.'-'.$name->correlative.'.pdf');
            //$pdf= env('RUC') .'-' . $name->type_document.'-'.$name->serie.'-'.$name->correlative.'.pdf';
            //return response()->json('hey', Response::HTTP_OK);

            $pdf= 'pruebas.pdf';
            $file = storage_path('file_pdf/example_pdf.pdf');
            $headers = array(
                            'Content-Type: application/pdf',
                        );

            return response()->download($file, $pdf, $headers);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            //@var \App\Models\Api\Quote
            $oQuote = Quote::with([
                'items:id,quote_id,quantity,price,total',
                'items.product:id,sku,name,description',
            ])
            ->findOrFail($id);

            if ($oQuote !== null)
                return response()->json($oQuote, Response::HTTP_OK);
            else
                return response()->json(['message' => __('api.messages.notfound')], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
