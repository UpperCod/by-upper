/**
 *
 * @param {HTMLElement} root
 */
function scrollDirection (root) {
  let subscribers = [];
  let getter = "scrollY" in root ? "scrollY" : "scrollTop";
  let lastY = root[getter];
  let lastState;

  function handler() {
    let nextY = root[getter];
    let nextState = nextY > lastY;

    if (nextState != lastState) {
      subscribers.forEach(el => {
        let textState = nextState ? "bottom" : "top";

        if (el instanceof HTMLElement) {
          el.dataset.direction = textState;
        } else {
          el(textState);
        }
      });
      lastState = nextState;
    }

    lastY = nextY;
  }

  root.addEventListener("scroll", handler);
  return {
    push(value) {
      subscribers.push(value);
    },

    clear() {
      root.removeEventListener("scroll", handler);
    }

  };
}

const OBSERVER = Symbol("scroll.observer");
function createScrollObserver () {
  let intersection = new IntersectionObserver(entries => entries.forEach(event => {
    event.target[OBSERVER](event);
  }), {
    rootMargin: "200px 0px"
  });
  return element => {
    let node = element;
    let dataset = element.dataset;

    switch (dataset.scrollBefore) {
      case "nextSibling":
        node = element.nextSibling;
        break;
    }

    node[OBSERVER] = ({
      isIntersecting
    }) => {
      let state = isIntersecting ? "intercepted" : "not-intercepted";
      dataset.scrollBefore = state;

      if (dataset.src && isIntersecting) {
        if (!element.hasAttribute("src")) {
          if (element.localName == "video") {
            element.addEventListener("canplay", () => {
              setTimeout(() => {
                element.style.opacity = 1;
              }, 100);
            });
          }

          element.setAttribute("src", dataset.src);
        }

        delete dataset.src;
      }
    };

    intersection.observe(node);
  };
}

let eventScroll = scrollDirection(window);
document.querySelectorAll("[data-direction]").forEach(el => eventScroll.push(el));
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
    document.querySelectorAll(toggle).forEach(el => el.classList.toggle("--active"));
  });
});
let scrollObserver = createScrollObserver();
document.querySelectorAll("[data-scroll],[data-src]").forEach(el => scrollObserver.observe(el));
//# sourceMappingURL=bundle.js.map
