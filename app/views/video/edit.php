<div class="row mt40">
	<div class="row">
		<div class="col-md-10">
			<div class="pull-left">
				<h2><?php echo $title;?></h2>
			</div>
		</div>
		<div class="col-md-2 text-right">
			<a href="<?php echo base_url('/') ?>" class="btn btn-danger">View All</a>
		</div>
	</div>     
     
	<form action="" method="POST" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12">
				<?php if($this->session->flashdata('error_view')){ echo '<div class="alert alert-danger">'.$this->session->flashdata('error_view').'</div>'; } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="col-md-12">
					<div class="form-group">
						<strong>Title</strong>
						<input type="text" name="video_title" class="form-control" value="<?php echo $video->video_title ?>" placeholder="Enter Video Title" required />
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<strong>Vedio</strong>
						<input type="file" class="form-control" name="video_file_name" placeholder="Uplaod Video" />
						Note* - You can upload wmv|mp4|avi|mov|flv extension file.
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<video width="320" height="240" controls>
				  <source src="<?php echo base_url('uploads/videos/').$video->video_file_name;?>" type="<?php echo $video->video_file_type ?>">
				  Sorry, your browser doesn't support the video element.
				</video>
			</div>
			
			<div class="col-md-12">
				<input type="hidden" name="id" value="<?php echo $video->id ?>" />
				<input type="hidden" name="old_file_name" value="<?php echo $video->video_file_name ?>" />
				<input type="hidden" name="video_file_type" value="<?php echo $video->video_file_type ?>" />
				<input type="submit" class="btn btn-primary" name="submit" value="Submit" />
			</div>
		</div>
	</form>
</div>