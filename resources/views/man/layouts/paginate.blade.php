<div class="row">
    <div class="col-sm-5 hidden-xs">
        <div class="dataTables_info" id="example-datatable_info" role="status" aria-live="polite">
            <strong>{{ $list->perPage() * ($list->currentPage()-1) + 1 }}</strong>-
            <strong>{{ $list->currentPage() == $list->lastPage() ? $list->total() :
                            $list->perPage() * $list->currentPage() }}</strong> of
            <strong>{{ $list->total() }}</strong>
        </div>
    </div>
    <div class="col-sm-7 col-xs-12 clearfix">
        <div class="dataTables_paginate paging_bootstrap" id="example-datatable_paginate">
            {!! $list->appends(['l'=>request('l')?:10])->render() !!}
        </div>
    </div>
</div>