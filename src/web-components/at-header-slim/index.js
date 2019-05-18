import { h, customElement } from "@atomico/element";
import { useRef } from "@atomico/core";
import style from "./style.css";

function IconMenu() {
	return (
		<svg width="30" height="19" viewBox="0 0 30 19">
			<g transform="translate(-1310 -31)">
				<rect width="30" height="3" rx="1.5" transform="translate(1310 31)" />
				<rect width="30" height="3" rx="1.5" transform="translate(1310 39)" />
				<rect width="30" height="3" rx="1.5" transform="translate(1310 47)" />
			</g>
		</svg>
	);
}

function Header({ label = "Menu", show }) {
	let ref = useRef();
	return (
		<host shadowDom ref={ref}>
			<style>{style}</style>
			<button
				class="menu"
				onClick={() => {
					ref.current.show = !ref.current.show;
				}}
			>
				<IconMenu />
				<strong>{label}</strong>
			</button>
			<div class="aside">
				<slot name="nav" />
			</div>
			<slot name="icons" />
		</host>
	);
}

Header.observables = {
	label: String,
	show: Boolean
};

export default customElement("at-header-slim", Header);
