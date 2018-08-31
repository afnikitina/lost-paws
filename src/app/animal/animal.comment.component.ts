import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

//Interfaces used by the component
import {Comment} from "../shared/interfaces/comment";
import {Animal} from "../shared/interfaces/animal";
import {Profile} from "../shared/interfaces/profile";

// Services needed

import {AnimalService} from "../shared/services/animal.service";
import {ProfileService} from "../shared/services/profile.service";
import {CommentService} from "../shared/services/comment.service";

//Status and router
import {Status} from "../shared/interfaces/status";
import {ActivatedRoute, Params} from "@angular/router";

@Component({
	template: require("./animal.comment.template.html"),
	selector: "comments"
})

export class AnimalCommentComponent implements OnInit {
	animal: Animal;
	profile: Profile;
	comment: Comment = {commentId: null, commentAnimalId: null, commentProfileId: null, commentDate: null, commentText: null, profileName: null};
	comments: Comment[] = [];
	animalId = this.route.snapshot.params["animalId"];
	tempComments: any[];
	createCommentForm: FormGroup;
	status: Status = {status: null, message: null, type: null};

	constructor(
		protected formBuilder: FormBuilder,
		protected commentService: CommentService,
		protected animalService: AnimalService,
		protected route: ActivatedRoute
	) {
	}

	ngOnInit(): void {
		this.loadComments();
		this.animalService.getAnimal(this.animalId).subscribe(reply => this.animal = reply);
		this.createCommentForm = this.formBuilder.group({
			commentText: ["", [Validators.maxLength(1000), Validators.required]]
		});

	}

	loadComments() : any {
		this.commentService.getCommentbyAnimalId(this.animalId).subscribe(comments => this.tempComments = comments);
	}

	createAnimalComment(): any {
		let comment: Comment = {
			commentId: null,
			commentAnimalId: null,
			commentProfileId: null,
			commentDate: null,
			commentText: this.createCommentForm.value.commentText,
			profileName: null
		};

		this.commentService.createComment(comment)
			.subscribe(status => {
				this.status = status;

				if(status.status === 200) {
					this.loadComments();
				}
			});
	}


}