/**
 *
 * @param {HTMLElement} root
 */
export default function (root) {
  let subscribers = [];
  let getter = "scrollY" in root ? "scrollY" : "scrollTop";
  let lastY = root[getter];
  let lastState;
  function handler() {
    let nextY = root[getter];
    let nextState = nextY > lastY;
    if (nextState != lastState) {
      subscribers.forEach((el) => {
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
    },
  };
}
