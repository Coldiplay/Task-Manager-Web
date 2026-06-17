<div class="container mt-5">
    <h2>{{ $videoData['title'] }}</h2>

    <div class="video-wrapper">
        <video width="100%" height="480" controls poster="{{ asset('images/video-poster.jpg') }}">
            <!-- asset() указывает на папку public/storage -->
            <source src="{{ asset('storage/' . $videoData['filename']) }}" type="video/mp4">

            Ваш браузер не поддерживает встроенное видео.
            <a href="{{ asset('storage/' . $videoData['filename']) }}">Скачайте видео</a>, чтобы просмотреть его.
        </video>
    </div>
</div>
