@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.transaction.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.transactions.update", [$transaction->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
{{--            <div class="form-group">--}}
{{--                <label for="user_from_id">{{ trans('cruds.transaction.fields.user_from') }}</label>--}}
{{--                <select class="form-control select2 {{ $errors->has('user_from') ? 'is-invalid' : '' }}" name="user_from_id" id="user_from_id">--}}
{{--                    @foreach($user_froms as $id => $user_from)--}}
{{--                        <option value="{{ $id }}" {{ (old('user_from_id') ? old('user_from_id') : $transaction->user_from->id ?? '') == $id ? 'selected' : '' }}>{{ $user_from }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                @if($errors->has('user_from'))--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        {{ $errors->first('user_from') }}--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.transaction.fields.user_from_helper') }}</span>--}}
{{--            </div>--}}
            <div class="form-group">
                <label for="user_to_id">{{ trans('cruds.transaction.fields.user_to') }}</label>
                <select class="form-control select2 {{ $errors->has('user_to') ? 'is-invalid' : '' }}" name="user_to_id" id="user_to_id">
                    @foreach($user_tos as $id => $user_to)
                        <option value="{{ $id }}" {{ (old('user_to_id') ? old('user_to_id') : $transaction->user_to->id ?? '') == $id ? 'selected' : '' }}>{{ $user_to }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transaction.fields.user_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.transaction.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $transaction->amount) }}" step="0.01" required>
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transaction.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
