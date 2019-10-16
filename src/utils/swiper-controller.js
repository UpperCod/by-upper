export default function(slides) {
	let prevent;
	slides.forEach(currentSlide => {
		currentSlide.on("transitionStart", () => {
			if (prevent && currentSlide !== prevent) return;
			prevent = currentSlide;
			slides
				.filter(slide => currentSlide !== slide)
				.forEach(slide => {
					slide.slideTo(currentSlide.activeIndex);
				});
			prevent = false;
		});
	});
}
