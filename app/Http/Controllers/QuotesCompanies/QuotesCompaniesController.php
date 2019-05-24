<?php

namespace App\Http\Controllers\QuotesCompanies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QuotesCompanies\QuotesCompany;

class QuotesCompaniesController extends Controller
{
    public function filter (Request $request)
    {
        $query = QuotesCompany::query();

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $quotes = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    ->paginate($request->input('pagination.per_page'));

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
}
