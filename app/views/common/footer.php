			<script>
			function delete_confirm(){
				if(confirm("Do you want to delete this record?")){
					return true;
				}
				return false;
			}
			function show_video($file_name,$type){				
				var video = $('.source_tag').parent('video')[0];
				console.log(video);
				video.firstElementChild.src = 'uploads/videos/'+$file_name;
				video.firstElementChild.type = $type;
				video.load();
				video.play();
			}
			
			$(document).ready(function(){
				$('.qualitychange').change(function(){					
					$('.source_tag').parent('video').find('source').attr('label',$(this).val())
					var video = $('.source_tag').parent('video')[0];
					var $currentime = video.currentTime;  //Get Current Time of Video	
					video.load();
					video.currentTime = $currentime;  //Continue from video's stop
					video.play();
				});
			});
			</script>
		</div>
		</div>     
	</body>
</html>