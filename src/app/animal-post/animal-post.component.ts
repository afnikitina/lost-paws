import { Component, OnInit } from "@angular/core";
import { FormBuilder, FormGroup, FormControl,  ReactiveFormsModule, Validators } from '@angular/forms';
import { Animal } from "../shared/interfaces/animal";
import { AnimalService } from "../shared/services/animal.service";
import { AuthService } from "../shared/services/auth.service";
import {Status} from "../shared/interfaces/status";

@Component({
	selector: "animal-post",
	template: require("./animal-post.template.html")
})
export class AnimalPostComponent implements OnInit {
	animalForm: FormGroup;
	/*animal: Animal;*/
	submitted : boolean = false;
	status : Status = null;

	constructor(protected authService: AuthService,
					protected animalService: AnimalService,
					protected fb: FormBuilder) {
	}

	ngOnInit() : void {
		this.animalForm = this.fb.group({
			status: ["", [Validators.required]],
			species: ["", [Validators.required]],
			gender: ["", [Validators.required]],
			name: ["", [Validators.maxLength(100)]],
			color: ["", [Validators.required]],
			location: ["", [Validators.maxLength(200)]],
			description: ["", [Validators.maxLength(500), Validators.required]],
		});
	}



	/*
		animalId: string;
		animalProfileId: string;
		animalColor: string;
		animalDate: string;
		animalDescription: string;
		animalGender: string;
		animalImageUrl: string;
		animalLocation: string;
		animalName: string;
		animalSpecies: string;
		animalStatus: string;
	 */

	createAnimal() : void {
		this.submitted = true;

		const animal: Animal = {
			animalId: null,
			animalProfileId: null,
			animalColor: this.animalForm.value.color,
			animalDate: null,
			animalDescription: this.animalForm.value.description,
			animalGender: this.animalForm.value.gender,
			animalImageUrl: '',
			animalLocation: this.animalForm.value.location,
			animalName: this.animalForm.value.name,
			animalSpecies: this.animalForm.value.species,
			animalStatus: this.animalForm.value.status
		};

/*		console.log(this.animalForm.value.color || "color is undefined");
		console.log(this.animalForm.value.description || "description is undefined");
		console.log(this.animalForm.value.gender || "gender is undefined");
		console.log(this.animalForm.value.location || "location is undefined");
		console.log(this.animalForm.value.name || "name is undefined");
		console.log(this.animalForm.value.species || "species is undefined");
		console.log(this.animalForm.value.status || "status is undefined");*/

		if (animal) {
			console.log(animal.animalColor || "there is no animal created");
			this.animalService.createAnimal(animal).subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.animalForm.reset();
				}
			});
		} else {
			console.log("animal wasn't created");
		}
	}
}
