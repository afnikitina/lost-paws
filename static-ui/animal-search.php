<navbar></navbar>
<sign-in></sign-in>

<main>
	<div>
		<div class="container pt-5">
			<div class="row justify-content-between align-items-center">
				<h2 class="p-3">Search Results</h2>
				<div class="input-group col-md-3 offset-3">
					<div class="input-group-prepend">
						<button class="btn btn-dark" type="button" id="button-addon1">Search</button>
					</div>
					<input type="text" class="form-control" placeholder="Search by" aria-label="Example text with button addon" aria-describedby="button-addon1">
				</div>
				<label for="sort"></label>
				<select id="sort" class="col-md-3">
					<option value="">--Filter By--</option>
					<option *ngFor="let option of options" (click)="getAnimalByAnimalColor(option.animalColor);" value="color">Color</option>
					<option *ngFor="let option of options" (click)="getAnimalByAnimalGender(option.animalGender);" value="gender">Gender</option>
					<option *ngFor="let option of options" (click)="getAnimalByAnimalDescription(option.animalDescription);" value="description">Description</option>
					<option *ngFor="let option of options" (click)="getAnimalByAnimalSpecies(option.animalSpecies);" value="species">Species</option>
					<option *ngFor="let option of options" (click)="getAnimalByAnimalStatus(option.animalStatus);" value="status">Status</option>
				</select>
			</div>

			<div class="row bg-dark text-light justify-content-center rounded-top">
				<h4>Fuzzy</h4>
			</div>
			<div class="row align-items-center bg-dark rounded-bottom pb-3 mb-4">
				<div class="col-md-4">
					<img src="http://placekitten.com/300/250" alt="placeholder cat" class="img-fluid rounded p-3">
				</div>
				<div class="col-md-4">
					<ul class="list-group">
						<li class="list-group-item">Name: Fuzzy</li>
						<li class="list-group-item">Status: Lost</li>
						<li class="list-group-item">Species: Cat</li>
					</ul>
				</div>
				<div class="col-md-4">
					<ul class="list-group">
						<li class="list-group-item">Location: 1st and Main</li>
						<li class="list-group-item">Gender: Male</li>
						<li class="list-group-item">Color: Grey</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container pt-5">
			<div class="row justify-content-center">
				<nav aria-label="...">
					<ul class="pagination">
						<li class="page-item disabled">
							<a class="page-link" href="#" tabindex="-1">Previous</a>
						</li>
						<li class="page-item active">
							<a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
						</li>
						<li class="page-item">
							<a class="page-link" href="#">2</a>
						</li>
						<li class="page-item"><a class="page-link" href="#">3</a></li>
						<li class="page-item">
							<a class="page-link" href="#">Next</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</main>

