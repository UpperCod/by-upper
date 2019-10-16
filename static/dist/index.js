/**
 *
 * @param {HTMLElement} root
 */
function scrollDirection (root) {
  var subscribers = [];
  var getter = "scrollY" in root ? "scrollY" : "scrollTop";
  var lastY = root[getter];
  var lastState;

  function handler() {
    var nextY = root[getter];
    var nextState = nextY > lastY;

    if (nextState != lastState) {
      subscribers.forEach(function (el) {
        var textState = nextState ? "bottom" : "top";

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
    push: function push(value) {
      subscribers.push(value);
    },
    clear: function clear() {
      root.removeEventListener("scroll", handler);
    }
  };
}

function createScrollObserver () {
  return new IntersectionObserver(function (entries) {
    return entries.forEach(function (_ref) {
      var isIntersecting = _ref.isIntersecting,
          target = _ref.target;
      target[isIntersecting ? "setAttribute" : "removeAttribute"]("intercepted", "");

      if (target.dataset.src) {
        target.setAttribute("src", target.dataset.src);
      }
    });
  }, {
    rootMargin: "200px 0px"
  });
}

var eventScroll = scrollDirection(window);
document.querySelectorAll("[data-direction]").forEach(function (el) {
  return eventScroll.push(el);
});
document.querySelectorAll("[href]").forEach(function (link) {
  var href = link.getAttribute("href");

  if (/^#(.+)/.test(href)) {
    if (!document.querySelector(href)) {
      link.setAttribute("href", __dirsite + href);
    }
  }
});
document.querySelectorAll("[data-toggle]").forEach(function (el) {
  var toggle = el.dataset.toggle;
  el.addEventListener("click", function () {
    document.querySelectorAll(toggle).forEach(function (el) {
      return el.classList.toggle("--active");
    });
  });
});
var scrollObserver = createScrollObserver();
document.querySelectorAll("[data-scroll],[data-src]").forEach(function (el) {
  return scrollObserver.observe(el);
});
//# sourceMappingURL=index.js.map
