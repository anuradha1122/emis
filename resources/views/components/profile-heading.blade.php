<div class="bg-black py-4 md:py-8">
    <div class="flex flex-col gap-3">

        @if ($image)
            <img src="{{ $image }}" class="object-cover w-14 h-14 rounded-full m-auto border-2 border-white" alt="User image" id="user_image">
        @else
            <div class="flex items-center justify-center w-14 h-14 bg-white text-black font-bold rounded-full m-auto">
                {{ strtoupper(substr($heading, 0, 1)) }}
            </div>
        @endif

        <p class="text-3xl font-bold text-center text-white">
            {{ $heading }}
        </p>

        <p class="text-center text-gray-300">
            {{ $subHeading }}
        </p>

        {{-- Uncomment if needed --}}
        {{-- 
        <div class="flex justify-center max-w-sm gap-2 mx-auto">
            <a href="#">
                <img src="https://tailwindflex.com/public/images/icons/github.svg" class="object-cover w-6 h-6 m-auto" title="github">
            </a>
            <a href="#">
                <img src="https://tailwindflex.com/public/images/icons/linkedin.png" class="object-cover w-6 h-6 m-auto" title="linkedin">
            </a>
            <a href="#">
                <img src="https://tailwindflex.com/public/images/icons/website.svg" class="object-cover w-6 h-6 m-auto" title="website">
            </a>
            <a href="#">
                <img src="https://tailwindflex.com/public/images/icons/instagram.svg" class="object-cover w-6 h-6 m-auto" title="instagram">
            </a>
        </div>
        --}}
    </div>
</div>
