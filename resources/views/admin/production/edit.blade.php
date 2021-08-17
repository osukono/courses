@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.courses.edit', $course) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body mb-2">
            <h5 class="card-title mb-4">{{ $course }}</h5>
            <form action="{{ route('admin.courses.update', $course) }}" method="post" autocomplete="off">
                @method('patch')
                @csrf

                @input(['name' => 'title', 'label' => 'Title', 'default' => $course->title])
                @textarea(['name' => 'description', 'label' => 'Description', 'default' => $course->description])
                @input(['name' => 'android_product_id', 'label' => 'Android Product ID', 'default' => $course->android_product_id])
                @input(['name' => 'ios_product_id', 'label' => 'iOS Product ID', 'default' => $course->ios_product_id])
                @input(['name' => 'ad_mob_banner_unit_id_android', 'label' => 'Android AdMob Banner ID', 'default'=> $course->ad_mob_banner_unit_id_android])
                @input(['name' => 'ad_mob_banner_unit_id_ios', 'label' => 'iOS AdMob Banner ID', 'default' => $course->ad_mob_banner_unit_id_ios])
                @input(['name' => 'demo_lessons', 'label' => 'Demo Lessons', 'default'=> $course->demo_lessons])
                @input(['name' => 'version', 'label' => 'Version', 'default' => $course->minor_version])
                @input(['name' => 'firebase_id', 'label' => 'Firebase ID', 'default' => $course->firebase_id])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.courses.show', $course)])
            </form>
        </div>
    </div>
@endsection
