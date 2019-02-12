@extends('adminlte::page')

@section('title', 'Queen Island Kitchen | SMS Module')

@section('content_header')
  <h1>
    <i class="fa fa-envelope-o"></i> এসএমএস মডিউল (SMS Module)
    <div class="pull-right">
      <small>বর্তমান SMS রেটঃ {{ Auth::user()->school->smsrate }} ৳</small>
    </div>
  </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{ Auth::user()->school->smsbalance }}</h3>

          <p>SMS Balance</p>
        </div>
        <div class="icon">
          <i class="ion ion-chatboxes"></i>
        </div>
        <span class="small-box-footer">{{ date('l | F d, Y') }}</span>
      </div>

      <div class="box box-primary" style="position: relative; left: 0px; top: 0px;">
        <div class="box-header ui-sortable-handle" style="">
          <i class="fa fa-battery-full"></i>

          <h3 class="box-title">এসএমএস রিচার্জ (Recharge SMS)</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
         <div class="form-group">
           <label for="smsamount">SMS Amount:</label>
           <input type="number" name="smsamount" id="smsamount" class="form-control"" required="" placeholder="SMS Amount" min="500">
         </div>
         <button class="btn btn-primary" id="smsamountbtn">Check Amount</button><br/><br/>
         <big id="smsamounttext">
           
         </big>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-6">
      {{-- <div class="box box-success" style="position: relative; left: 0px; top: 0px;">
        <div class="box-header ui-sortable-handle" style="">
          <i class="fa fa-paper-plane"></i>

          <h3 class="box-title">এসএমএস পাঠান (Send Bulk SMS)</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <big>Total Recipients: {{ $memberscount }}</big>
          {!! Form::open(['route' => ['sms.sendbulk'], 'method' => 'POST']) !!}
            <div class="form-group">
              <label for="singlemessage">Message:</label>
              <textarea type="text" name="message" id="singlemessage" class="form-control textarea" required="" placeholder="Write message"></textarea>
            </div>
            <table class="table">
              <tr id="smstestresult">
                <td>Encoding: <span class="encoding">GSM_7BIT</span></td>
                <td>Length: <span class="length">0</span></td>
                <td>SMS Cost: <span class="messages" id="smscount">0</span></td>
                <td>Remaining: <span class="remaining">160</span></td>
              </tr>
            </table>
            <input type="hidden" name="smscount" id="smscounthidden" required="">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#sendBulkModal" data-backdrop="static"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send SMS</button>
              <div class="modal fade" id="sendBulkModal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header modal-header-success">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-envelope-o" aria-hidden="true"></i> SMS Sending Confirmation</h4>
                    </div>
                    <div class="modal-body">
                      Are you sure to send SMS to <b>{{$memberscount }} persons?</b>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Send SMS</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
          {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
      <div class="box box-warning" style="position: relative; left: 0px; top: 0px;">
        <div class="box-header ui-sortable-handle" style="">
          <i class="fa fa-user-plus"></i>

          <h3 class="box-title">নতুন নম্বর যোগ করুন (Add New Number)</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
         {!! Form::open(['route' => 'membership.store_direct_contact', 'method' => 'POST']) !!}
         <div class="form-group">
           {!! Form::label('phone', 'Mobile Number (11 Digits)') !!}
           {!! Form::text('phone', null, array('class' => 'form-control', 'placeholder' => 'Write 11 Digit Mobile Number (Like 01700000000)', 'required' => '', 'pattern' =>'\d*', 'maxlength' => '11')) !!}
           {!! Form::hidden('name', 'Direct_Contact') !!}
           {!! Form::hidden('point', 0) !!}
           {!! Form::hidden('type', 0) !!}
         </div>
         <button class="btn btn-warning">Add Number</button>
         {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div> --}}
    </div>
  </div>
@stop


@section('js')
  <script type="text/javascript" src="{{ asset('js/smscounter.js') }}"></script>
  <script type="text/javascript">
    $('#smsamountbtn').click(function() {
        var smsamount = $('#smsamount').val();
        if(smsamount < 500) {
          $('#smsamounttext').html('<span style="color:red;">কমপক্ষে <b>500</b> মেসেজ লিখুন!</span>');
        } else {
          var smsrate = {{ Auth::user()->school->smsrate }};
          var rechargeamount = Math.ceil(($('#smsamount').val() * smsrate) + (($('#smsamount').val() * smsrate) * (2/100)));
          var token = "";
          var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

          for (var i = 0; i < 100; i++) {
            token += possible.charAt(Math.floor(Math.random() * possible.length));
          }

          window.location.href = '{{ url('sms/client/recharge') }}'+'/'+$('#smsamount').val()+'/'+token+'/'+rechargeamount;
          $('#smsamounttext').html('<big><b>01837409842</b></big> (বিকাশ পার্সোনাল) নম্বরে মোটঃ <big><b>' + rechargeamount + '/-</b></big> টাকা বিকাশ করুন এবং ফোন দিয়ে জানিয়ে দিন। ১ ঘন্টার মধ্যে ব্যালেন্স রিচার্জ করে দেওয়া হবে।');
        }
    });
  </script>
@stop