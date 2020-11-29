<div class="row mt40">
	<div class="row">
		<div class="col-md-10">
			<h2><?php echo $title;?></h2>
		</div>
		<div class="col-md-2 text-right">
			<a href="<?php echo base_url('home/create/') ?>" class="btn btn-danger">Add Video</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php if($this->session->flashdata('success_view')){ echo '<div class="alert alert-success">'.$this->session->flashdata('success_view').'</div>'; } ?>
		</div>
	</div>
	<div class="table-responsive-sm">
		<table class="table">
			<thead class="thead-light">
				<tr>			
					<th width="20%">Title</th>
					<th>Video</th>
					<th>Created at</th>
					<th class="text-center" colspan="3">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if(!empty($videos)){
				foreach($videos as $video){ 
			?>
					<tr>				
						<td><?php echo $video->video_title; ?></td>
						<td>
							<video controls width="25%">
								<source label="fullHD" src="<?php echo base_url('uploads/videos/').$video->video_file_name;?>" type="<?php echo $video->video_file_type; ?>">
								<source label="720p"   src="<?php echo base_url('uploads/videos/').$video->video_file_name;?>" type="<?php echo $video->video_file_type; ?>">
								<source label="360p"   src="<?php echo base_url('uploads/videos/').$video->video_file_name;?>" type="<?php echo $video->video_file_type; ?>">
							</video>
						</td>
						<td><?php echo $video->add_date; ?></td>
						<td><a href="javascript:void(0);" onclick="show_video('<?php echo $video->video_file_name;?>','<?php echo $video->video_file_type;?>');" class="btn btn-primary" data-toggle="modal" data-target="#videoModalCenter">View</a></td>
						<td><a href="<?php echo base_url('home/edit/'.$video->id) ?>" class="btn btn-primary">Edit</a></td>
						<!--<td><a href="<?php echo base_url('home/delete/'.$video->id) ?>" class="btn btn-primary">Delete</a></td>-->
						<td>
							<form action="<?php echo base_url('home/delete/'.$video->id) ?>" method="post">
								<input type="hidden" name="video_file_name" value="<?php echo $video->video_file_name ?>" />
								<button onclick="return delete_confirm();" class="btn btn-danger" type="submit">Delete</button>
							</form>
						</td>
					</tr>
			<?php 
				}
			}else{
				echo '<tr><td colspan="5">Data not found.</td></tr>';
			}
			?>	
			</tbody>
		</table>
		<p><?php echo $links; ?></p>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="videoModalCenter" tabindex="-1" role="dialog" aria-labelledby="videoModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="videoModalLongTitle">
					<select class="form-control qualitychange" autocomplete="off">
						<option selected value="FullHD">Full HD</option>
						<option value="720p">720p</option>
						<option value="360p">360p</option>
					</select>
				</h5>				
			</div>
			<div class="modal-body"> 
			   <video controls preload width="100%">
				  <source class="source_tag" label="fullHD" src="" type="">				  
			   </video>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>				
			</div>
		</div>
	</div>
</div>