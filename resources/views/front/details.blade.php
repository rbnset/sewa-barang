<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="{{ asset('output.css') }}" rel="stylesheet">
	<link href="{{ asset('main.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
		rel="stylesheet" />
</head>

<body>
	<main class="max-w-[640px] mx-auto min-h-screen flex flex-col relative has-[#Bottom-nav]:pb-[144px]">
		<div id="Top-navbar" class="flex items-center justify-between px-5 pt-5 absolute top-0 z-10 w-full">
			<a href="{{ url()->previous() }}">
				<div class="size-[44px] flex shrink-0">
					<img src="{{asset('assets/images/icons/arrow-left.svg')}}" alt="icon" />
				</div>
			</a>
			<p class="text-lg leading-[27px] font-semibold">Details</p>
			<button class="size-[44px] flex shrink-0">
				<img src="{{asset('assets/images/icons/more.svg')}}" alt="icon" />
			</button>
		</div>
		<section id="Thumbnail" class="flex relative h-[370px] pt-[94px] pb-[66px] bg-[#F6F6F6]">
			<!-- Main Thumbnail -->
			<div class="w-full h-[210px] flex items-center justify-center flex-shrink-0">
				<img id="mainThumbnail" src="{{ Storage::url($product->thumbnail) }}" alt="Thumbnail"
					class="size-full object-contain transition-opacity duration-500 ease-in-out" />
			</div>
			<!-- Selection Thumbnails -->
			<div class="flex gap-4 absolute -bottom-[35px] w-full items-center justify-center">
				<button
					class="thumbnail-button size-[70px] flex p-[15px_20px] rounded-full overflow-hidden bg-white flex-shrink-0 th-active">
					<img src="{{ Storage::url($product->thumbnail) }}" alt="Thumbnail" class="size-full" />
				</button>

                @forelse ( $product->photos as $photo )
                <button
                class="thumbnail-button size-[70px] flex p-[15px_20px] rounded-full overflow-hidden bg-white flex-shrink-0 th-inactive">
                    <img src="{{ Storage::url($photo->photo) }}" alt="Thumbnail"
                    class="size-full" />
                </button>
                @empty
                    <P>Belum ada foto yang ditamabhkan</P>
                @endforelse

			</div>
		</section>
		<section id="Details" class="flex flex-col mt-[65px] px-5 w-full gap-5">
			<div id="Heading" class="flex items-center justify-between">
				<div class="flex flex-col gap-1">
					<h1 class="text-[22px] leading-[33px] font-bold">{{ $product->name }}</h1>
					<p class="text-[#6E6E70]">{{ $product->category->name }}</p>
				</div>
				<div class="flex">
					<div class="size-5 flex shrink-0">
						<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
					</div>
					<p class="font-semibold">4/5 <span class="font-normal text-[#6E6E70]">(777)</span></p>
				</div>
			</div>
			<div id="About" class="flex flex-col gap-1">
				<h2 class="font-semibold">About</h2>
				<p class="leading-[30px]">{{ $product->about }}</p>
			</div>
			<div id="Benefits" class="flex flex-col gap-3">
				<h2 class="font-semibold">Benefits</h2>
				<div class="grid grid-cols-2 gap-4">
					<div
						class="flex p-[18px_14px] outline outline-1 outline-[#EDEEF0] rounded-2xl overflow-hidden justify-start">
						<div class="flex gap-3 items-center">
							<div class="size-6 flex shrink-0">
								<img src="{{asset('assets/images/icons/note-favorite.svg')}}" alt="icon" class="size-full" />
							</div>
							<p class="text-sm leading-[21px] font-semibold text-nowrap">Original 100%</p>
						</div>
					</div>
					<div
						class="flex p-[18px_14px] outline outline-1 outline-[#EDEEF0] rounded-2xl overflow-hidden justify-start">
						<div class="flex gap-3 items-center">
							<div class="size-6 flex shrink-0">
								<img src="{{asset('assets/images/icons/dollar-circle.svg')}}" alt="icon" class="size-full" />
							</div>
							<p class="text-sm leading-[21px] font-semibold text-nowrap">More Points</p>
						</div>
					</div>
					<div
						class="flex p-[18px_14px] outline outline-1 outline-[#EDEEF0] rounded-2xl overflow-hidden justify-start">
						<div class="flex gap-3 items-center">
							<div class="size-6 flex shrink-0">
								<img src="{{asset('assets/images/icons/location.svg')}}" alt="icon" class="size-full" />
							</div>
							<p class="text-sm leading-[21px] font-semibold text-nowrap">Fully GPS</p>
						</div>
					</div>
					<div
						class="flex p-[18px_14px] outline outline-1 outline-[#EDEEF0] rounded-2xl overflow-hidden justify-start">
						<div class="flex gap-3 items-center">
							<div class="size-6 flex shrink-0">
								<img src="{{asset('assets/images/icons/shield-tick.svg')}}" alt="icon" class="size-full" />
							</div>
							<p class="text-sm leading-[21px] font-semibold text-nowrap">Insurances</p>
						</div>
					</div>
				</div>
			</div>
			<div id="Testimonials" class="flex flex-col gap-[14px]">
				<h2 class="font-semibold">Testimonials</h2>
				<div class="flex flex-col gap-4">
					<!-- Testi -->
					<div class="pb-4 border-b border-[#EDEEF0]">
						<div class="flex gap-3">
							<!-- photo -->
							<div class="size-[50px] flex shrink-0 rounded-full overflow-hidden">
								<img src="{{asset('assets/images/photos/photo-1.png')}}" alt="icon" class="size-full" />
							</div>
							<div class="flex flex-col gap-[6px] w-full">
								<div class="flex items-center justify-between">
									<p class="text-sm leading-[21px] font-semibold">Sara Putri</p>
									<div class="flex gap-[2px]">
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
									</div>
								</div>
								<p class="text-xs leading-5 text-[#6E6E70]">Bagus produknya dan cepet banget dipakenya
									anti ribet karena beberap app sudah ready</p>
							</div>
						</div>
					</div>
					<!-- Testi -->
					<div class="pb-4 border-b border-[#EDEEF0]">
						<div class="flex gap-3">
							<!-- photo -->
							<div class="size-[50px] flex shrink-0 rounded-full overflow-hidden">
								<img src="{{asset('assets/images/photos/photo-2.png')}}" alt="icon" class="size-full" />
							</div>
							<div class="flex flex-col gap-[6px] w-full">
								<div class="flex items-center justify-between">
									<p class="text-sm leading-[21px] font-semibold">Sara Putri</p>
									<div class="flex gap-[2px]">
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
									</div>
								</div>
								<p class="text-xs leading-5 text-[#6E6E70]">Bagus produknya dan cepet banget dipakenya
									anti ribet karena beberap app sudah ready</p>
							</div>
						</div>
					</div>
					<!-- Testi -->
					<div class="pb-4">
						<div class="flex gap-3">
							<!-- photo -->
							<div class="size-[50px] flex shrink-0 rounded-full overflow-hidden">
								<img src="{{asset('assets/images/photos/photo-3.png')}}" alt="icon" class="size-full" />
							</div>
							<div class="flex flex-col gap-[6px] w-full">
								<div class="flex items-center justify-between">
									<p class="text-sm leading-[21px] font-semibold">Sara Putri</p>
									<div class="flex gap-[2px]">
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
										<div class="size-5 flex shrink-0">
											<img src="{{asset('assets/images/icons/Star.svg')}}" alt="icon" class="size-full" />
										</div>
									</div>
								</div>
								<p class="text-xs leading-5 text-[#6E6E70]">Bagus produknya dan cepet banget dipakenya
									anti ribet karena beberap app sudah ready</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div id="Bottom-nav"
			class="fixed bottom-0 max-w-[640px] w-full mx-auto border-t border-[#F1F1F1] overflow-hidden z-10">
			<div class="bg-white/50 backdrop-blur-sm absolute w-full h-full"></div>
			<div class="flex items-center justify-between p-5 relative z-10">
				<div class="flex flex-col gap-1 w-fit">
					<p class="font-bold text-xl leading-[30px]">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
					<p class="text-sm leading-[21px]">/day</p>
				</div>
				<a href="{{ route('front.booking', $product->slug) }}" class="rounded-full p-[12px_24px] bg-[#FCCF2F] font-bold w-fit">Rent Now</a>
			</div>
		</div>
	</main>

	<script src="{{ asset('customjs/details.js') }}"></script>
</body>

</html>
