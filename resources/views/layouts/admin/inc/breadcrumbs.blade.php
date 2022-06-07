<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ Arr::get($breadcrumbs, 'title') }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @foreach (Arr::get($breadcrumbs, 'path') as $key => $value)
                        @if ($value == 0)
                            <li class="breadcrumb-item active">{{ $key }}</li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ $value }}">{{ $key }}</a></li>
                        @endif
                    @endforeach
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
