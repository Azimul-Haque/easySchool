@extends('adminlte::page')

@section('title', 'EasySchool | SMS Admin')

@section('content_header')
  <h1>
    SMS Admin
    <div class="pull-right">

    </div>
  </h1>
@stop

@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6">
          <div class="info-box">
            <span class="info-box-icon bg-green"><span class="glyphicon glyphicon-import"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Actual Balance</span>
              <span class="info-box-number">
                ৳ {{ $actualbalance }} (<span id="currentBalance"></span>)
              </span>
              <span class="info-box-text">Available SMS: {{ (int) ($actualbalance / 0.20) }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
        <div class="col-md-6">
          <div class="info-box">
            <span class="info-box-icon bg-red"><span class="glyphicon glyphicon-export"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">SMS Balance</span>
              <span class="info-box-number">
                {{ $totalsalesms->totalsms }}
              </span>
              <span class="info-box-text"><big></big></span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
      </div>

      <div class="box box-primary" style="position: relative; left: 0px; top: 0px;">
        <div class="box-header ui-sortable-handle" style="">
          <i class="fa fa-battery-full"></i>

          <h3 class="box-title">Recharge SMS</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['route' => ['sms.rechargeschoolsms'], 'method' => 'POST']) !!}
               <div class="form-group">
                 <label for="smsamount">School:</label>
                 <select name="school_id" class="form-control" required="">
                   <option value="" selected="" disabled="">Select School</option>
                   @foreach($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                   @endforeach
                 </select>
               </div>
               <div class="row">
                 <div class="form-group col-md-6">
                   <label for="smsamount">SMS Amount:</label>
                   <input type="number" name="smsamount" class="form-control"" required="" placeholder="SMS Amount">
                 </div>
                 <div class="form-group col-md-6">
                   <label for="smsamount">SMS Rate:</label>
                   <input type="number" name="smsrate" class="form-control"" required="" placeholder="SMS Rate" step="any">
                 </div>
               </div>
               <button class="btn btn-primary" type="submit">Add SMS</button>
            {!! Form::close() !!}
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-success" style="position: relative; left: 0px; top: 0px;">
        <div class="box-header ui-sortable-handle" style="">
          <i class="fa fa-battery-half"></i>

          <h3 class="box-title">SMS Balances</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table" id="datatable-sms-balances">
            <thead>
              <tr>
                <th>School</th>
                <th>SMS Balance</th>
                <th>SMS Rate</th>
              </tr>
            </thead>
            <tbody>
              @foreach($schools as $school)
                <tr>
                  <td>{{ $school->name }}</td>
                  <td>{{ $school->smsbalance }}</td>
                  <td>{{ $school->smsrate }} ৳</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-warning" style="position: relative; left: 0px; top: 0px;">
        <div class="box-header ui-sortable-handle" style="">
          <i class="fa fa-battery-full"></i>

          <h3 class="box-title">SMS Recharge History</h3>
          <div class="box-tools pull-right">
            
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table" id="datatable-sms-recharge-history">
            <thead>
              <tr>
                <th>School</th>
                <th>SMS Count</th>
                <th>Claimed Recharge Amount (Tk)</th>
                <th>Trx ID</th>
                <th>Activation Status</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($smsrechargehistories as $history)
                <tr>
                  <td>{{ $history->school->name }}</td>
                  <td>{{ $history->smscount }}</td>
                  <td>{{ $history->tk }} ৳</td>
                  <td><big><b>{{ $history->trx_id }}</b></big></td>
                  <td>
                    @if($history->activation_status == 1)
                      <span style="color: green;"><b>Activated</b></span>
                    @else
                      <span style="color: red;"><b>Pending</b></span>
                    @endif
                  </td>
                  <td>{{ date('F d, Y h:i A', strtotime($history->created_at)) }}</td>
                  <td>
                    {{-- edit modal--}}
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editModal{{ $history->id }}" data-backdrop="static" title="Recharged and activated"><i class="fa fa-check" aria-hidden="true"></i></button>
                    <!-- Trigger the modal with a button -->
                    <!-- Modal -->
                    <div class="modal fade" id="editModal{{ $history->id }}" role="dialog">
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header modal-header-success">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Activation confirmation</h4>
                          </div>
                          <div class="modal-body">
                            <big>
                              <b>School:</b> {{ $history->school->name }}<br/>
                              <b>Trx ID:</b> {{ $history->trx_id }}<br/>
                              <b>Datetime:</b> {{ date('F d, Y h:i A', strtotime($history->created_at)) }}<br/><br/>
                              Confirm activation of this payment?</b>?
                            </big>
                          </div>
                          <div class="modal-footer">
                            {!! Form::model($history, ['route' => ['sms.update.history', $history->id], 'method' => 'PATCH']) !!}
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                    </div>
                    {{-- edit modal--}}

                    {{-- delete modal--}}
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $history->id }}" data-backdrop="static" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    <!-- Trigger the modal with a button -->
                    <!-- Modal -->
                    <div class="modal fade" id="deleteModal{{ $history->id }}" role="dialog">
                      <div class="modal-dialog modal-md">
                        <div class="modal-content">
                          <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete confirmation</h4>
                          </div>
                          <div class="modal-body">
                            <big>
                              <b>School:</b> {{ $history->school->name }}<br/>
                              <b>Trx ID:</b> {{ $history->trx_id }}<br/>
                              <b>Datetime:</b> {{ date('F d, Y h:i A', strtotime($history->created_at)) }}<br/><br/>
                              Confirm delete this payment?</b>?
                            </big>
                          </div>
                          <div class="modal-footer">
                            {!! Form::model($history, ['route' => ['sms.destroy.history', $history->id], 'method' => 'DELETE']) !!}
                                <button type="submit" class="btn btn-danger">Delete</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                    </div>
                    {{-- delete modal--}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
@stop

@section('js')
<script type="text/javascript" src="{{ asset('js/smscounter.js') }}"></script>
<script type="text/javascript">
  $(function () {
    $('#datatable-sms-balances').DataTable({
      'paging'      : true,
      'pageLength'  : 10,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'order': [[ 0, "asc" ]],
       // columnDefs: [
       //    { targets: [5], type: 'date'}
       // ],
      'language': {
         "lengthMenu": "প্রতি পৃষ্ঠায় _MENU_ টি রেকর্ড প্রদর্শন করুন",
         "zeroRecords": "কোন তথ্য পাওয়া যায়নি!",
         "info": "পৃষ্ঠা নম্বরঃ _PAGE_, মোট পৃষ্ঠাঃ _PAGES_ টি",
         "infoEmpty": "তথ্য পাওয়া যায়নি",
         "infoFiltered": "(মোট _MAX_ সংখ্যক রেকর্ড থেকে খুঁজে বের করা হয়েছে)",
         "search":         "খুঁজুনঃ",
         "paginate": {
             "first":      "প্রথম পাতা",
             "last":       "শেষ পাতা",
             "next":       "পরের পাতা",
             "previous":   "আগের পাতা"
         },
       }
    })
  })
  $(function () {
    $('#datatable-sms-recharge-history').DataTable({
      'paging'      : true,
      'pageLength'  : 10,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'order': [[ 5, "desc" ]],
       columnDefs: [
          { targets: [5], type: 'date'}
       ],
      'language': {
         "lengthMenu": "প্রতি পৃষ্ঠায় _MENU_ টি রেকর্ড প্রদর্শন করুন",
         "zeroRecords": "কোন তথ্য পাওয়া যায়নি!",
         "info": "পৃষ্ঠা নম্বরঃ _PAGE_, মোট পৃষ্ঠাঃ _PAGES_ টি",
         "infoEmpty": "তথ্য পাওয়া যায়নি",
         "infoFiltered": "(মোট _MAX_ সংখ্যক রেকর্ড থেকে খুঁজে বের করা হয়েছে)",
         "search":         "খুঁজুনঃ",
         "paginate": {
             "first":      "প্রথম পাতা",
             "last":       "শেষ পাতা",
             "next":       "পরের পাতা",
             "previous":   "আগের পাতা"
         },
       }
    })
  })
</script>
<script type="text/javascript">
  $(function(){
   $('a[title]').tooltip();
   $('button[title]').tooltip();
  });
</script>

<script type="text/javascript">
  function currentBalanceInquery(data) {
   $.ajax({
       url: "http://66.45.237.70/balancechk.php?username=01751398392&password=Bulk.Sms.Bd.123",
       type: "GET",
       data: {},
       success: function (data) {
           var balance = data;
           if(balance < 0) {
            balance = 0;
           }
           $("#currentBalance").text(balance);
       }
   });
  }
  setTimeout(currentBalanceInquery(), 1000*1);
  setInterval(currentBalanceInquery, 1000*30);
</script>

@stop