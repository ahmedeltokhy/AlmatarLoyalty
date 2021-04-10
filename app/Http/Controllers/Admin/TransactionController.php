<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        abort_if(Gate::denies('transaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transactions = Transaction::with(['user_from', 'user_to']);
        if ($user_id != 1) {
            $transactions = $transactions->where('user_from_id', '=', $user_id)->orWhere('user_to_id', '=', $user_id);
        }
        $transactions = $transactions->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $user = Auth::user();
        abort_if(Gate::denies('transaction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_froms = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user_tos = User::with([])->where('id', '!=', $user->id)->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.transactions.create', compact('user_froms', 'user_tos'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $inputs = $request->all();
        $user = Auth::user();
        $inputs['user_from_id'] = $user->id;
        if ($inputs['amount'] > $user->points) {
            return redirect()->route('admin.transactions.index')->with('message', 'no sufficient balance');
        }
        $transaction = Transaction::create($inputs);

        return redirect()->route('admin.transactions.index');
    }

    public function edit(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_froms = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user_tos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $transaction->load('user_from', 'user_to');

        return view('admin.transactions.edit', compact('user_froms', 'user_tos', 'transaction'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->all());

        return redirect()->route('admin.transactions.index');
    }

    public function show(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transaction->load('user_from', 'user_to');

        return view('admin.transactions.show', compact('transaction'));
    }

    public function confirm($id)
    {
        $transaction = Transaction::where('id', '=', $id)->first();
        $transaction->status = 1;
        $transaction->save();
        return redirect()->back();
    }
}

