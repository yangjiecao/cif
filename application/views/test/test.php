<h2><?= $title?></h2>
<ul>
<?php foreach($tests as $test): ?>
	<li><?=$test->id?>--<?=$test->name?>--<?=$test->degree?></li>
<?php endforeach; ?>
<a href="/blog/create">添加</a>
</ul>
