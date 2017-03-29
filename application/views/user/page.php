<h1><?=$title?></h1>
<table>
	<tr>
		<th>Name</th>
		<th>Age</th>
		<th>Introduction</th>
	</tr>
<?php foreach($results as $result): ?>
	<tr>
		<td><?=$result->name?></td>
		<td><?=$result->age?></td>
		<td><?=$result->introduction?></td>
	</tr>
<?php endforeach; ?>
</table>
<div>
	<?=$this->pagination->create_links()?>
</div>