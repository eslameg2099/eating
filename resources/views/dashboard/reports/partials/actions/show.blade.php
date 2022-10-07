@if(method_exists($report, 'trashed') && $report->trashed())
    @can('view', $report)
        <a href="{{ route('dashboard.reports.trashed.show', $report) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $report)
        <a href="{{ route('dashboard.reports.show', $report) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif