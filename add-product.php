<?php include('db_connect.php');?> <!-- ! -->

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-12">
			<form action="" id="manage-product">
				<div class="card">
					<div class="card-header">
						   Formulario de Produtos
				  	</div>
					<div class="card-body">
						
							<div class="form-group">
								<label class="control-label">Categoria</label>
								<select name="category_id" id="category_id" class="custom-select select2" required>
									<option value=""></option>
									<?php
									$qry = $conn->query("SELECT * FROM categories order by name asc");
									while($row=$qry->fetch_assoc()):
										$cname[$row['id']] = ucwords($row['name']);
									?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
								<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Nome</label>
								<input type="text" class="form-control" name="name" required>
							</div>
							<div class="form-group">
								<label class="control-label">Descrição</label>
								<textarea name="description" id="description" cols="30" rows="4" class="form-control" required></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Preço/label>
								<input type="number" class="form-control text-right" name="price" required>
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch">
								  <input type="checkbox" class="custom-control-input" id="status" name="status" checked value="1" required>
								  <label class="custom-control-label" for="status">Disponivel</label>
								</div>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-center">
								<button class="btn btn-primary"> Salvar</button>
								<button class="btn btn-default" type="button" onclick="$('#manage-product').get(0).reset()"> Cancelar</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p {
		margin:unset;
	}
	.custom-switch{
		cursor: pointer;
	}
	.custom-switch *{
		cursor: pointer;
	}
</style>
<script>
	$('#manage-product').on('reset',function(){
		$('input:hidden').val('')
		$('.select2').val('').trigger('change')
	})
	
	$('#manage-product').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_product',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Adicionado",'success')
					setTimeout(function(){
						location.reload('index.php?page=orders')
					},1500)

				}
				else if(resp==2){
					alert_toast("Atualizado",'success')
					setTimeout(function(){
						location.reload('index.php?page=orders')
					},1500)

				}
			}
		})
	})
	$('.edit_product').click(function(){
		start_load()
		var cat = $('#manage-product')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='price']").val($(this).attr('data-price'))
		cat.find("[name='category_id']").val($(this).attr('data-category_id')).trigger('change')
		if($(this).attr('data-status') == 1)
			$('#status').prop('checked',true)
		else
			$('#status').prop('checked',false)
		end_load()
	})
	$('.delete_product').click(function(){
		_conf("Você quer deletar esse produto?","delete_product",[$(this).attr('data-id')])
	})
	function delete_product($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_product',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Deletado",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>
