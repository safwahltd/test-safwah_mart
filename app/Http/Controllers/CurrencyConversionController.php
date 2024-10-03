<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\CurrencyConversion;

use App\Traits\CheckPermission;
use Illuminate\Http\Request;

class CurrencyConversionController extends Controller
{
    use CheckPermission;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $this->hasAccess('currency-conversions.index');

        $currencyConversions = CurrencyConversion::with('currency')->orderByDesc('effected_month')->paginate(30);

        return view('global.currency-conversions.index', compact('currencyConversions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $this->hasAccess('currency-conversions.create');

        if (!$request->filled('month')) {
            $request->month = fdate(today(), 'Y-m');
        }

        $currencies = Currency::orderBy('name')->whereDoesntHave('currency_conversions', function ($q) use($request) {
            $q->where('effected_month', $request->month);
        })->get();

        return view('global.currency-conversions.create', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->hasAccess('currency-conversions.create');

        $count = 0;
        if ($request->filled('month')) {
            foreach ($request->currency_ids as $key => $currency_id) {
                if ($request->currency_rates[$key] != '') {
                    CurrencyConversion::create([
                        'effected_month' => $request->month,
                        'currency_id'    => $currency_id,
                        'rate'           => $request->currency_rates[$key]
                    ]);
                    $count++;
                }
            }
        }

        if ($count > 0) {
            return redirect()->route('currency-conversions.index')->with('message', $count . ' currency conversion created successfully for ' . fdate($request->month, 'F, Y'));
        }

        return redirect()->back()->with('error', 'No records created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->hasAccess('currency-conversions.delete');

        try {
            CurrencyConversion::destroy($id);
            return redirect()->back()->with('message', 'Item deleted successfully');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Item can not be deleted');
        }
    }
}
