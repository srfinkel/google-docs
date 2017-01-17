<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Phase 1 of Data Design Project</title>
		<link href="styles.css" rel="stylesheet">
	</head>
	<body>
		<h1>
			Persona
		</h1>
		<p>
			Molly is 60-years-old with a long track record of being an artist-educator. She is somewhat tech savvy, meaning
			she
			uses technology in her everyday life although is not a "techie" person. She uses a 2012 MacbookPro laptop
			running El Capitan and an iPhone 6. She uses google docs becuase she collaborates with other professionals
			across the country developing projects and needs a tool to track meeting notes, to do lists, etc. She uses
			google docs because it is simple and integrates well with her e-mail and her collaborators' emails.
		</p>

		<h1>
			Use Case
		</h1>
		<p>
			Molly has regular Director's Meetings every two weeks. The Project Administrator is in charge of developing a
			draft agenda in google docs and sharing it with Molly prior to the meeting. Molly is responsible for reviewing the
			draft agenda and adding items based on their priority. She edits the draft agenda and then reshares the new agenda with
			other collaborators for the meeting.
		</p>

		<h1>
			Interaction Flow
		</h1>
		<ol>
			<li class="client">
				Molly logs into her e-mail.
			</li>
			<li>
				Google opens Molly's account with access to her Google Drive.
			</li>
			<li class="client">
				Molly opens draft agenda from her Google Drive.
			</li>
			<li>
				Google opens the plain text document for Molly.
			</li>
			<li class="client">
				Molly edits parts of the agenda.
			</li>
			<li>
				Google drive automatically saves the changes.
			</li>
			<li class="client">
				Molly resends the updated google doc to her collaborators.
			</li>
		</ol>

		<h1>
			Conceptual Model
		</h1>
		<h2>Entities & Attributes</h2>
		<h3>Profile</h3>
		<ul>
			<li>
				profileId (primary key)
			</li>
			<li>
				profileEmail
			</li>
			<li>
				profileHash
			</li>
			<li>
				profileSalt
			</li>
		</ul>
		<h3>Document</h3>
		<ul>
			<li>
				documentId (primary key)
			</li>
			<li>
				documentProfileId (foreign key)
			</li>
			<li>
				documentDate
			</li>
			<li>
				documentContent
			</li>
			<li>
				documentTime
			</li>
		</ul>
		<h3>Collaborators</h3>
		<ul>
			<li>
				collaboratorProfileId (foreign key)
			</li>
			<li>
				collaboratorDocumentId (foreign key)
			</li>
		</ul>

		<h2>Relations</h2>
		<ul>
			<li>Many <strong>Collaborators</strong> can make many <strong>Documents - <em>(m to n)</em></strong></li>
		</ul>
		<img src="images/google-docs-ERD.svg">
	</body>
</html>