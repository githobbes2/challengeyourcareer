@extends('layouts.admin')

@section('styles')
<style type="text/css">
    iframe {
        border: none !important;
    }

    @media print {
        * { overflow: -moz-scrollbars-none; }
        ::-webkit-scrollbar { width: 0 !important }
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.reports.title') }}
        <div class="local-menu float-right">
            <a class="btn btn-default float-right" href="#" onclick="window.history.back();">{{ trans('global.back_to_list') }}</a>
            <button class="btn btn-info float-right mr-2" type="button" id="printBtn" style="display:none">{{ trans('global.print') }}</button>
        </div>
    </div>

    <div class="card-body">
        <div id="reportContainer" style="height:800px;min-height:500px;"></div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('dist/powerbi.js') }}"></script>
<script>
    $(document).ready(function(){
        var models = window['powerbi-client'].models;
        var embedConfiguration= {
            type: 'report',
            id: '{{ config('powerbi.reportID') }}', // Power-BI report ID
            embedUrl: "{!! $embedUrl !!}",
            accessToken: "{!! $token !!}",
            settings: {
                panes: {
                    pageNavigation: {
                        visible: true,
                        position: models.PageNavigationPosition.Left
                    }
                }
            },
        };
        var $reportContainer = $('#reportContainer');
        var report = powerbi.embed($reportContainer.get(0), embedConfiguration);

        report.on("loaded", function(){
            report.updateSettings({
                panes: {
                    filters :{
                        visible: false
                    },
                }
            }).catch(function (errors) {
                console.log(errors);
            });
        });

        $('#printBtn').click(function(event) {
            window.print();
        })
        $('#printBtn').show();
    });
</script>
@endsection
