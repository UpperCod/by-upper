const OBSERVER = Symbol("scroll.observer");
export default function () {
  let intersection = new IntersectionObserver(
    (entries) =>
      entries.forEach((event) => {
        event.target[OBSERVER](event);
      }),
    {
      rootMargin: "200px 0px",
    }
  );

  return (element) => {
    let node = element;
    let dataset = element.dataset;
    switch (dataset.scrollBefore) {
      case "nextSibling":
        node = element.nextSibling;
        break;
    }
    node[OBSERVER] = ({ isIntersecting }) => {
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
