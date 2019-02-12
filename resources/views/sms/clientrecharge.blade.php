@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | SMS Module')

@section('content_header')
  <h1>
    <i class="fa fa-envelope-o"></i> এসএমএস মডিউল (SMS Module) | রিচার্জ
    <div class="pull-right">
      <small>বর্তমান SMS রেটঃ {{ Auth::user()->school->smsrate }} ৳</small>
    </div>
  </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary" style="position: relative; left: 0px; top: 0px;">
        <div class="box-header ui-sortable-handle" style="">
          <i class="fa fa-battery-full"></i>
          <h3 class="box-title">Recharge SMS</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <big>
              <div class="row">
                <div class="col-md-8">
                  <b>01837409842</b>-(বিকাশ পার্সোনাল) নম্বরে <b>{{ $tk }}</b> টাকা <b>বিকাশ</b> করুন। এবং ট্রানজেকশন আইডিটি নিচের বক্সে লিকে 'দাখিল করুন' বাটনে ক্লিক করুন
                </div>
                <div class="col-md-4">
                  <img src="{{ asset('images/bkash.png') }}" class="img-responsive" style="max-height: 80px; widows: auto;">
                </div>
              </div><br/>
            </big>
            {!! Form::open(['route' => ['sms.rechargerequest'], 'method' => 'POST']) !!}
               <div class="form-group">
                  <label for="tk">রিচার্জ পরিমানঃ (টাকা)</label>
                  <input type="hidden" name="smscount" value="{{ $smscount }}">
                  <input type="number" name="tk" class="form-control"" required="" placeholder="Recharge Amount (Tk)" value="{{ $tk }}" readonly="">
                </div>
                <div class="form-group">
                  <label for="trx_id">ট্রানজেকশন আইডিঃ</label>
                  <input type="text" name="trx_id" class="form-control"" required="" placeholder="ট্রানজেকশন আইডিঃ" step="any">
                </div>
               <button class="btn btn-primary" type="submit">দাখিল করুন</button>
            {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
@stop


@section('js')
  
@stop