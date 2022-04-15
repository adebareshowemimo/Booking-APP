<!-- PAGE-HEADER -->
<div class="page-header">
  <div>
    <h1 class="page-title">{{ $title }}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route("admin.$model.index", $parentEntry ?? null) }}">{{ $title }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $state }}</li>
    </ol>
  </div>
  @if ($state === 'List' && ((isset($allowCreate) && $allowCreate === true) || !isset($allowCreate)))
    <div class="ml-auto pageheader-btn">
      <a href="{{ route("admin.$model.create") }}" class="btn btn-primary btn-icon text-white">
        Add {{ $title }} <i class="fe fe-plus"></i>
      </a>
    </div>
  @endif
</div>
<!-- PAGE-HEADER END -->
