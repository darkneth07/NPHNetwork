<!DOCTYPE html>
<html>
<head>
	<title>IpHuntz Music Uploader</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
</head>
<body>
	<div>
		<form action="action.php" method="post" enctype="multipart/form-data" id="multiple-upload-form">
		    <center>
		        <b><br>IPHUNTZ MUSIC UPLOADER<br><br><small>Note: If its done uploaded, Wait 5 seconds before quit. Then type your file music name you uploaded. | NethPH 😚</small></b>
		        <center>
			<input type="button" id="select-file-btn" value="Select Files" onclick="document.getElementById('files').click(); return false;" />
			<input type="submit" id="file-upload-btn" name="file_upload_btn" value="Upload">
	</center>
			<input type="file" id="files" name="files[]" multiple="" style="visibility: hidden;">
			<br><br>
			<div class="file-bar">
				<span class="file-bar-fill" id="file-bar-fill-id"><span class="file-bar-fill-text" id="file-bar-fill-text-id"></span></span>
			</div>
			<script type="text/javascript">
				var app = app || {};

				(function(o){
					"use strict";

					var ajax, getFormData, setProgress;

					ajax = function(data){
						var xmlhttp = new XMLHttpRequest(), uploaded;

						xmlhttp.addEventListener('readystatechange', function(){
							if(this.readyState==4){
								if(this.status==200){
									uploaded = JSON.parse(this.response);

									if(typeof o.options.finished==='function'){
										o.options.finished(uploaded);
									}

								} else {
									if(typeof o.options.error === 'function'){
										o.options.error();
									}
								}
							}
						});

						xmlhttp.upload.addEventListener("progress", function(event){
							var percent;
							if(event.lengthComputable===true){
								percent = Math.round((event.loaded / event.total) * 100);
								setProgress(percent);
							}

						});

						if(o.options.progressBar!==undefined){
							o.options.progressBar.style.width=0;
						}
						if(o.options.progressText!==undefined){
							o.options.progressText.innerText=0;
						}

						xmlhttp.open("post", o.options.processor);
						xmlhttp.send(data);
					};

					getFormData = function(source){
						var data = new FormData(), i;

						if(source.length<=0)
						{
							return false;
						}
						else
						{
							for(i=0;i<source.length; i++){
								data.append('files[]', source[i]);
							}

							return data;
						}
					};

					setProgress = function(value){
						if(o.options.progressBar!==undefined){
							o.options.progressBar.style.width = value? value+"%":0;
						}
						if(o.options.progressText!==undefined){
							o.options.progressText.innerText=value?value+"%":0;
						}
					};

					o.uploader = function(options){
						o.options = options;

						if(o.options.files !== undefined){
							var imageFormDataValue = getFormData(o.options.files.files);
							if(imageFormDataValue===false)
							{
								alert("No Files Selected");
								document.getElementById("file-upload-btn").disabled = false;
								document.getElementById("select-file-btn").disabled = false;
							}
							else
							{
								ajax(imageFormDataValue);
							}
						}
					};

				}(app));

				document.getElementById("file-upload-btn").addEventListener("click", function(e){
					e.preventDefault();

					document.getElementById("file-upload-btn").setAttribute("disabled", "true");
					document.getElementById("select-file-btn").setAttribute("disabled", "true");

					var f = document.getElementById('files'),
						pb = document.getElementById('file-bar-fill-id'),
						pt = document.getElementById('file-bar-fill-text-id');

					app.uploader({
						files: f,
						progressBar: pb,
						progressText: pt,
						processor: "action.php",

						finished: function(data){
							document.getElementById("file-upload-btn").disabled = false;
							document.getElementById("select-file-btn").disabled = false;

							if(data.status===true){
								alert(data.data);
							}
							
						},

						error: function(){
							alert("Error occured. Try Again after page reload.");
						}
					});
				});
			</script>
		</form>
		</center>
	</div>
</body>
</html>