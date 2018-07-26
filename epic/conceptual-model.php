<!DOCTYPE html>
<html>
	<head lang="en">
		<title>Lost Paws Conceptual Model</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>Conceptual Model</h1>
		<h2>Profile</h2>
		<ul>
			<li>profileId (primary key)</li>
			<li>profileActivationToken</li>
			<li>profileEmail</li>
			<li>profileHash</li>
			<li>profileName</li>
		</ul>
		<h2>Animal</h2>
		<ul>
			<li>animalId (primary key)</li>
			<li>animalProfileId</li>
			<li>animalChipNumber</li>
			<li>animalDate</li>
			<li>animalDescription</li>
			<li>animalFeatures</li>
			<li>animalGender</li>
			<li>animalImageUrl</li>
			<li>animalLocation</li>
			<li>animalName</li>
			<li>animalSpecies</li>
			<li>animalStatus</li>
		</ul>
		<h2>Comments</h2>
		<ul>
			<li>commentId (primary key)</li>
			<li>commentAnimalId (foreign key)</li>
			<li>commentProfileId (foreign key)</li>
			<li>commentDate</li>
			<li>commentText</li>
		</ul>
		<h2>Relations</h2>
		<ul>
			<li>One Profile can Post multiple Animals 1-n</li>
			<li>One Animal can Display one Image 1-1</li>
			<li>One Profile can Upload multiple Images 1-n</li>
			<li>One Profile can Post multiple Comments 1-m</li>
			<li>One Profile Contain multiple Comments 1-m</li>
			<li>Multiple Profiles can Post multiple Animals m-n</li>
			<li>Multiple Animals can Contain multiple Comments m-n</li>
			<li>Mutiple Profiles can Upload multiple images m-n</li>
			<li>Multiple Profiles can Post multiple Comments m-n</li>
		</ul>

	</body>
</html>