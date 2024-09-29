<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">{{ Auth::user()->role }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ ucfirst(basename(request()->route()->getPrefix())) }}</li>
                    <li class="breadcrumb-item active">
                        {{ ucfirst(str_replace(['index', 'show', 'create', 'edit'], ['Index', 'Show', 'Create', 'Edit'], request()->route()->getActionMethod())) }}
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
