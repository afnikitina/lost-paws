//Import needed @angularDependencies.
import {RouterModule, Routes} from "@angular/router";

// Place needed components here!
import {HomeComponent} from "./home/home.component";
import {AboutUsComponent} from "./about-us/about-us.component";
import {AnimalPostComponent} from "./animal-post/animal-post.component";
import {AnimalCardComponent} from "./animal/animal.card.component";
import {AnimalCommentComponent} from "./animal/animal.comment.component";
import {ContactComponent} from "./animal/contact.component";
import {NavbarComponent} from "./shared/components/navbar/navbar.component";
import {SigninComponent} from "./shared/components/navbar/signin.component";
import {ProfileComponent} from "./profile/profile.component";
import {AnimalSearchComponent} from "./search/animal.search.component";
import {GoogleExitComponent} from "./shared/components/navbar/google.exit.component";
import {SignOutRedirectComponent} from "./sign-out-redirect/sign-out-redirect.component";


// Import all needed Interceptors
import {APP_BASE_HREF} from "@angular/common";
import {HTTP_INTERCEPTORS} from "@angular/common/http";


//Import needed services
import {AuthService} from "./shared/services/auth.service";
import {AnimalService} from "./shared/services/animal.service";
import {CookieService} from "ng2-cookies";
import {CommentService} from "./shared/services/comment.service";
import {ProfileService} from "./shared/services/profile.service";
import {JwtHelperService} from "@auth0/angular-jwt";
import {SessionService} from "./shared/services/session.service";
import {SignOutService} from "./shared/services/sign.out.service";
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";
import {GoogleExitService} from "./shared/services/google.exit.service";
//import {AnimalSearchComponent} from "./search/animal.search.component";


// Add components to the array that will be passed off to the module
export const allAppComponents = [HomeComponent, NavbarComponent, AnimalCardComponent, AnimalCommentComponent, AnimalPostComponent, AboutUsComponent, ContactComponent, SigninComponent, ProfileComponent, AnimalSearchComponent, GoogleExitComponent, SignOutRedirectComponent];
/**
 * Add routes to the array that will be passed off to the module.
 * Place them in order of most specific to least specific.
 **/
export const routes: Routes = [
	{path: "signed-out", component: SignOutRedirectComponent},
	{path: "google-exit", component: GoogleExitComponent},
	{path: "animal/:animalId", component: AnimalCardComponent},
	{path: "animal-post", component: AnimalPostComponent},
	{path: "about-us", component: AboutUsComponent},
	{path: "search", redirectTo: "/search/animalStatus/Lost"},
	{path: "search/:animalParameter/:animalValue", component: AnimalSearchComponent},
	{path: "profile", component: ProfileComponent},
	{path: "", component: HomeComponent},
];

// An array of services

const services: any[] = [AuthService, AnimalService, CommentService, CookieService, JwtHelperService, ProfileService, SessionService, SignOutService, GoogleExitService];

// An array of misc providers
const providers: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true}
];

export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);
