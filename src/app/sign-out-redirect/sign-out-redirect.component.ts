import {Component} from "@angular/core";

@Component ({
	template: require("./sign-out-redirect.template.html"),
	selector: "signed-out"
})

export class SignOutRedirectComponent {
	ngOnInit() {
		//set session storage for sign in purposes
		window.sessionStorage.setItem('url', window.location.pathname);
	};

}