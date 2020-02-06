<?php

namespace App\Http\Controllers\QuotesCompanies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QuotesCompanies\QuotesCompany;
use Carbon\Carbon;
use App\Exports\QuotesCompaniesExport;
use Maatwebsite\Excel\Facades\Excel;

class QuotesCompaniesController extends Controller
{
    public function filter (Request $request)
    {
        $query = QuotesCompany::query();

        if ($request->agentId) {
            $query->where('created_by', $request->agentId);
        }

        if ($request->date['dateRange']) {
            $ds = Carbon::parse($request->date['dateRange']['start']['date']);
            $de = Carbon::parse($request->date['dateRange']['end']['date']);
            $query->whereBetween('created_at', [$ds, $de]);
        }

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $quotes = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    //->paginate($request->input('pagination.per_page'));
                    ->get();

        return $quotes;
    }

    public function show ($quote)
    {
        return QuotesCompany::findOrFail($quote);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'company' => 'required|string',
            'address' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string'
        ]);

        $quote = QuotesCompany::create([
            'company' => $request->company,
            'address' => $request->address,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cellphone' => $request->cellphone,
            'notes' => $request->notes
        ]);

        return QuotesCompany::find($quote->id);
    }

    public function update (Request $request)
    {
        $this->validate($request, [
            'company' => 'required|string',
            'address' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string'
        ]);

        $quote = QuotesCompany::find($request->id);
        $quote->company = $request->company;
        $quote->address = $request->address;
        $quote->name = $request->name;
        $quote->email = $request->email;
        $quote->phone = $request->phone;
        $quote->cellphone = $request->cellphone;
        $quote->notes = $request->notes;
        $quote->save();

        return QuotesCompany::find($quote->id);
    }

    public function destroy ($quote)
    {
        return QuotesCompany::destroy($quote);
    }

    // public function countPendientes (Request $request)
    // {
    //     $query = QuotesCompany::query();
    //
    //     if ($request->userId) {
    //         $query->where('created_by', $request->userId);
    //     }
    //
    //     $quotes = $query->where('status', 'Pendiente')->count();
    //
    //     return $quotes;
    // }

    public function export(Request $request)
    {
        $quotes = $this->filter($request);

        foreach ($quotes as $key => $value) {

            $dt = Carbon::parse($value->created_at);

            $data[] = [
                $value->id,
                $dt->toFormattedDateString(),
                $value->company,
                $value->address,
                $value->name,
                $value->email,
                $value->phone,
                $value->cellphone,
                $value->creator->name,
                $value->notes,
            ];
        }

        $export = new QuotesCompaniesExport($data);

        return Excel::download($export, 'cotizaciones.xlsx');
    }
}
