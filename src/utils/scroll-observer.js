export default function() {
	return new IntersectionObserver(
		entries =>
			entries.forEach(({ isIntersecting, target }) => {
				target[isIntersecting ? "setAttribute" : "removeAttribute"](
					"intercepted",
					""
				);
				if (target.dataset.src) {
					target.setAttribute("src", target.dataset.src);
				}
			}),

		{
			rootMargin: "200px 0px"
		}
	);
}
