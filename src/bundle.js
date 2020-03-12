import scrollDirection from "./utils/scroll-direction";
import createScrollObserver from "./utils/scroll-observer";

let eventScroll = scrollDirection(window);

document
  .querySelectorAll("[data-direction]")
  .forEach(el => eventScroll.push(el));

document.querySelectorAll("[href]").forEach(link => {
  let href = link.getAttribute("href");
  if (/^#(.+)/.test(href)) {
    if (!document.querySelector(href)) {
      link.setAttribute("href", __dirsite + href);
    }
  }
});

document.querySelectorAll("[data-toggle]").forEach(el => {
  let toggle = el.dataset.toggle;
  el.addEventListener("click", () => {
    document
      .querySelectorAll(toggle)
      .forEach(el => el.classList.toggle("--active"));
  });
});

let scrollObserver = createScrollObserver();

document
  .querySelectorAll("[data-scroll],[data-src]")
  .forEach(el => scrollObserver.observe(el));
