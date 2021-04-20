@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.app.locales.index') }}
@endsection

@section('toolbar')
    <v-button-group>
        <v-button tooltip="Create"
                  route="{{ route('admin.app.locales.create') }}">
            <icon-plus></icon-plus>
        </v-button>
        <v-button tooltip="Download from Firebase"
                  submit="#download-locales">
            <icon-download-cloud></icon-download-cloud>
            @push('forms')
                <form class="d-none" id="download-locales" action="{{ route('admin.app.locales.download') }}"
                      method="post">
                    @csrf
                </form>
            @endpush
        </v-button>
        <v-button tooltip="Upload to Firebase"
                  submit="#upload-locales">
            <icon-upload-cloud></icon-upload-cloud>
            @push('forms')
                <form class="d-none" id="upload-locales" action="{{ route('admin.app.locales.upload') }}" method="post">
                    @csrf
                </form>
            @endpush
        </v-button>
        <v-button route="{{ route('admin.app.locale.groups.index') }}">
            Groups
        </v-button>
    </v-button-group>
@endsection

@section('content')
    @if ($appLocales->isNotEmpty())
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Localizations ({{ $appLocales->count() }})</h5>
                @include('admin.app.locales.list')
            </div>
        </div>
    @endif
@endsection
<script>
    import IconDownloadCloud from "../../../../js/components/icons/IconDownloadCloud";
    import IconUploadCloud from "../../../../js/components/icons/IconUploadCloud";
    export default {
        components: {IconUploadCloud, IconDownloadCloud}
    }
</script>
