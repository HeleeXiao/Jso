<div class="col-sm-6 col-xs-5">
    <div class="dataTables_length" id="example-datatable_length">
        <label>
            <select name="example-datatable_length" aria-controls="example-datatable"
                    onchange="
                            var queryString = '{{ $request->getQueryString() }}',
                            limit = $(this).val(),
                            url = '{{ $request->url() }}';
                            window.location.href=url + ( queryString ? '?'+queryString+'&l='+limit : '?l='+limit )"
                    class="form-control">
                <option value="5"
                        @if(request('l') == 5)
                        selected
                        @endif
                >
                    5
                </option>
                <option value="10"
                        @if(request()->has('l') && request('l') == 10)
                        selected
                        @elseif( ( ! request()->has('l') || !in_array(request('l'),[5,10,20]) ) && config('list.limit',10) == 10)
                        selected
                        @endif
                >
                    10
                </option>
                <option value="20"
                        @if(request('l') == 20)
                        selected
                        @endif
                >
                    20
                </option>
            </select>
        </label>
    </div>
</div>