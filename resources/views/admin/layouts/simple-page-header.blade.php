<!-- PAGE-HEADER -->
<div class="page-header">
  <div>
    <h1 class="page-title">{{ $title }}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route("admin.$model.index", $parentEntry ?? null) }}">{{ $title }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $state }}</li>
    </ol>
  </div>
</div>
<!-- PAGE-HEADER END -->
