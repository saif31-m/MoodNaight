@extends('theme.default')
<style type="text/css">
    @media  print {
      @page  { margin: 0; }
      body { margin: 1.6cm; }
    }
</style>
@section('content')
<!-- row -->

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">{{ trans('labels.dashboard') }}</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ trans('labels.invoice') }}</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <!-- End Row -->
    <div class="card" id="printDiv">
        <div class="card-header">
            {{ trans('labels.invoice') }}
            <strong>{{$getusers->order_number}}</strong> 
            <span class="float-right"> <strong>{{ trans('labels.status') }}:</strong>
                @if($getusers->status == '1')
                    {{ trans('labels.order_received') }}
                @elseif ($getusers->status == '2')
                    {{ trans('labels.order_on_the_way') }}
                @elseif ($getusers->status == '3')
                    {{ trans('labels.assigned_to_driver') }}
                @elseif ($getusers->status == '4')
                    {{ trans('labels.delivered') }}
                @else
                    {{ trans('labels.cancelled') }}
                @endif
            </span>

        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-8">
                    <h6 class="mb-3">To:</h6>
                    <div>
                        <strong>{{$getusers['users']->name}}</strong>
                    </div>
                    <div>{{$getusers->address}}, {{$getusers->pincode}}</div>
                    <div>{{ trans('labels.email') }}: {{$getusers['users']->email}}</div>
                    <div>{{ trans('labels.mobile') }}: {{$getusers['users']->mobile}}</div>
                </div>


                @if ($getusers->order_notes !="")
                <div class="col-sm-4">
                    <h6 class="mb-3">{{ trans('labels.order_note') }}:</h6>
                    <div>{{$getusers->order_notes}}</div>
                </div>
                @endif

            </div>

            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="center">#</th>
                            <th>{{ trans('labels.item') }}</th>
                            <th>{{ trans('labels.variation') }}</th>
                            <th class="right">{{ trans('labels.unit_cost') }}</th>
                            <th class="center">{{ trans('labels.qty') }}</th>
                            <th class="right">{{ trans('labels.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        foreach ($getorders as $orders) {
                        ?>
                        <tr>
                            <td class="center">{{$i}}</td>
                            <td class="left strong">
                                {{$orders->item_name}}
                                @foreach ($orders['addons'] as $addons)
                                <div class="cart-addons-wrap">
                                    <div class="cart-addons">
                                        <b>{{$addons['name']}}</b> : {{Auth::user()->currency}}{{number_format($addons['price'], 2)}}
                                    </div>
                                </div>
                                @endforeach

                                @if ($orders->item_notes != "")
                                    <b>{{ trans('labels.item_note') }}</b> : {{$orders->item_notes}}
                                @endif
                            </td>
                            <td class="left strong">{{$orders->variation}}</td>
                            <td class="left">{{Auth::user()->currency}}{{number_format($orders->variation_price, 2)}}</td>
                            <td class="center">{{$orders->qty}}</td>
                            <td class="right">{{Auth::user()->currency}}{{number_format($orders->total_price, 2)}}</td>
                        </tr>
                        <?php
                            $data[] = array(
                                "total_price" => $orders->total_price
                            );
                        ?>
                        <?php
                        $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-5">

                </div>

                <div class="col-lg-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                            <tr>
                                <td class="left">
                                    <strong>{{ trans('labels.tax') }}</strong> ({{$getusers->tax}}%)
                                </td>
                                <td class="right">
                                    <strong>{{Auth::user()->currency}}{{number_format($getusers->tax_amount, 2)}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="left">
                                    <strong>{{ trans('labels.delivery_charge') }}</strong>
                                </td>
                                <td class="right">
                                    <strong>{{Auth::user()->currency}}{{number_format($getusers->delivery_charge, 2)}}</strong>
                                </td>
                            </tr>
                            @if ($getusers->discount_amount != 0)
                            <tr>
                                <td class="left">
                                    <strong>{{ trans('labels.discount') }}</strong> ({{$getusers->promocode}})
                                </td>
                                <td class="right">
                                    <strong> - {{Auth::user()->currency}}{{number_format($getusers->discount_amount, 2)}}</strong>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="left">
                                    <strong>{{ trans('labels.total') }}</strong>
                                </td>
                                <td class="right">
                                    <strong>{{Auth::user()->currency}}{{number_format($getusers->order_total, 2)}}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>
    <!-- End Row -->
    <button type="button" class="btn btn-primary float-right" id="doPrint">
        <i class="fa fa-print" aria-hidden="true"></i> {{ trans('labels.print') }}
    </button>
</div>
<!-- #/ container -->

<!-- #/ container -->
@endsection
@section('script')
<script type="text/javascript">
    $(document).on('click', '.btn', function (event) {
         var printContents = document.getElementById('printDiv').innerHTML;
         var originalContents = document.body.innerHTML;
         document.body.innerHTML = printContents;
         window.print();
         document.body.innerHTML = originalContents;
    });
</script>
@endsection