<div class="table-responsive">
	
	<table class="table table-striped table-hover">
		<tr>
		<th>Image</th><th>Username</th><th>Email</th><th>Gender</th><th>Role</th><th>Date</th>
			<th>
				<a href="index.php?page=signup">
				<button type="button" class="btn btn-outline-primary">
				  <i class="fa-solid fa-plus me-1"></i>Add user
				</button>
			</a>
			</th>
		</tr>

		<?php if (!empty($users)):?>
			<?php foreach ($users as $user):?>
	 		<tr>
	 			<td>
	 				<a href="index.php?page=profile&id=<?=$user['id']?>">
						<img src="<?=crop($user['image'],400,$user['gender'])?>" style="width: 100%;max-width:100px;" >
					</a>
				</td>

				
				<td>
					<a href="index.php?page=profile&id=<?=$user['id']?>">
						<?=esc($user['username'])?>
					</a>	
				</td>
				<td><?=esc($user['email'])?></td>
				<td><?=esc($user['gender'])?></td>
				<td><?=esc($user['role'])?></td>
				<td><?=esc($user['date'])?></td>
				<td>
					<a href="index.php?page=user-edit&id=<?=$user['id']?>">
						<button class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-pen-to-square me-1"></i>Edit</button></a>
					<a href="index.php?page=user-delete&id=<?=$user['id']?>">
						<button class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash me-1"></i>Delete</button></a>
				</td>
			</tr>
			<?php endforeach;?>
		<?php endif;?>
		
	</table>
</div>

<script>
	function adduser(){
		var name
	}
</script>