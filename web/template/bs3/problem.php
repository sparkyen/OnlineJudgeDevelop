<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title>
		<?php echo $OJ_NAME ?> <?php echo $OJ_BBS ?>
	</title>

	<?php include("template/$OJ_TEMPLATE/css.php"); ?>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
	<div class="container">
		<?php include("template/$OJ_TEMPLATE/nav.php"); ?>

		<!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron"></div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<?php
				if ($pr_flag) {
					echo "<title>$MSG_PROBLEM" . $row['problem_id'] . "--" . $row['title'] . "</title>";
					echo "<center><h3>$id: " . $row['title'] . "</h3></center>";
					echo "<div align=right><sub>[$MSG_Creator : <span id='creator'></span>]</sub></div>";
				} else {
					//$PID="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					$id = $row['problem_id'];
					echo "<title>$MSG_PROBLEM " . $PID[$pid] . ": " . $row['title'] . " </title>";
					echo "<center><h3>$MSG_PROBLEM " . $PID[$pid] . ": " . $row['title'] . "</h3><center>";
					echo "<div align=right><sub>[$MSG_Creator : <span id='creator'></span>]</sub></div>";
				}
				echo "<center>";
				echo "<span class=green>$MSG_Time_Limit : </span><span><span fd='time_limit' pid='" . $row['problem_id'] . "'  >" . $row['time_limit'] . "</span></span> sec&nbsp;&nbsp;";
				echo "<span class=green>$MSG_Memory_Limit : </span>" . $row['memory_limit'] . " MB";

				if ($row['spj']) echo "&nbsp;&nbsp;<span class=red>Special Judge</span>";
				if (isset($OJ_OI_MODE) && $OJ_OI_MODE) {
					echo "<br><br>";
				} else {
					echo "<br><br>";
					echo "<div class='btn-group' role='group'>";
					echo "<a class='btn btn-info btn-sm' href='submitpage.php?id=$id' role='button'>$MSG_SUBMIT</a>";
					echo "<a class='btn btn-primary btn-sm' role='button' href=status.php?problem_id=" . $row['problem_id'] . "&jresult=4>$MSG_SOVLED: " . $row['accepted'] . "</a>";
					echo "<a class='btn btn-primary btn-sm' role='button' href=status.php?problem_id=" . $row['problem_id'] . ">$MSG_SUBMIT: " . $row['submit'] . "</a>";
					//echo "<a class='btn btn-primary btn-sm' role='button' href=problemstatus.php?id=".$row['problem_id'].">$MSG_STATISTICS</a>";
					if (isset($_SESSION[$OJ_NAME . '_' . 'administrator']) || isset($_SESSION[$OJ_NAME . '_' . 'contest_creator']) || isset($_SESSION[$OJ_NAME . '_' . 'problem_editor'])) {
						require_once("include/set_get_key.php");
						echo "<a class='btn btn-success btn-sm' role='button' href=admin/problem_edit.php?id=$id&getkey=" . $_SESSION[$OJ_NAME . '_' . 'getkey'] . ">EDIT</a>";
						echo "<a class='btn btn-success btn-sm' role='button' href=javascript:phpfm(" . $row['problem_id'] . ")>TESTDATA</a>";
					}
					echo "</div>";
				}

				echo "</center>";
				# end of head
				echo "</div>";
				echo "<!--StartMarkForVirtualJudge-->";
				?>

				<div class="panel panel-body">
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h4>
								<?php echo $MSG_Description ?>
							</h4>
						</div>
						<div class='panel-body content'>
							<?php echo $row['description'] ?>
						</div>
					</div>

					<?php
					if ($row['input']) { ?>
						<div class='panel panel-default'>
							<div class='panel-heading'>
								<h4>
									<?php echo $MSG_Input ?>
								</h4>
							</div>
							<div class='panel-body content'>
								<?php echo $row['input'] ?>
							</div>
						</div>
					<?php }
					if ($row['output']) { ?>
						<div class='panel panel-default'>
							<div class='panel-heading'>
								<h4>
									<?php echo $MSG_Output ?>
								</h4>
							</div>
							<div class='panel-body content'>
								<?php echo $row['output'] ?>
							</div>
						</div>
						<?php }



					$basedir = $OJ_SAMPLE_DATA . "/" . $row['problem_id'];
					for ($id = 1;; $id++) {
						$myfile = @fopen($basedir . "/sample" . $id . ".in", "r");
						if ($myfile) {
						?>
							<div class="panel-samplecase">
								<div class='panel panel-default' style="width: 48%;float: left;">
									<div class='panel-heading'>
										<h4>
											<?php echo $MSG_Sample_Input . $id ?>
											<a href="javascript:CopyToClipboard($('#sampleinput').text())">Copy</a>
										</h4>
									</div>
									<div class='panel-body'>
										<pre class=content><span id="sampleinput" class=sampledata><?php
											while (!feof($myfile)) {
												$sample = fgets($myfile);
												if (strlen($sample)) {
													$sample = str_replace("<", "&lt;", $sample);
													$sample = str_replace(">", "&gt;", $sample);
													echo $sample;
												}
											}
											fclose($myfile);
											?></span></pre>
									</div>
								</div>
							<?php
						} else {
							// echo $basedir . "/sample" . $id . "in";
							break;
						}
						$myfile = @fopen($basedir . "/sample" . $id . ".out", "r");
						if ($myfile) {
							?>
								<div class='panel panel-default' style="width: 48%;float: right;">
									<div class='panel-heading'>
										<h4>
											<?php echo $MSG_Sample_Output . $id ?>
											<a href="javascript:CopyToClipboard($('#sampleinput').text())">Copy</a>
										</h4>
									</div>
									<div class='panel-body'>
										<pre class=content><span id="sampleinput" class=sampledata><?php
											while (!feof($myfile)) {
												$sample = fgets($myfile);
												if (strlen($sample)) {
													$sample = str_replace("<", "&lt;", $sample);
													$sample = str_replace(">", "&gt;", $sample);
													echo $sample;
												}
											}
											fclose($myfile);?></span></pre>
									</div>
								</div>
								<div style="clear: both"></div>
							</div>
						<?php

						} else break;
					}
					// $sinput=str_replace("<","&lt;",$row['sample_input']);
					// $sinput=str_replace(">","&gt;",$sinput);
					// $soutput=str_replace("<","&lt;",$row['sample_output']);
					// $soutput=str_replace(">","&gt;",$soutput);

					/* if(strlen($sinput)){?>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h4>
								<?php echo $MSG_Sample_Input?> 
								<a href="javascript:CopyToClipboard($('#sampleinput').text())">Copy</a>
							</h4>
						</div>
						<div class='panel-body'><pre class=content><span id="sampleinput" class=sampledata><?php echo $sinput?></span></pre>
						</div>
					</div>
					<?php }

        if(strlen($soutput)){?>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h4>
								<?php echo $MSG_Sample_Output?>
								<a href="javascript:CopyToClipboard($('#sampleoutput').text())">Copy</a>
							</h4>
						</div>
						<div class='panel-body'><pre class=content><span id='sampleoutput' class=sampledata><?php echo $soutput?></span></pre>
						</div>
					</div>
					<?php }*/

					if ($row['hint']) { ?>
						<div class='panel panel-default'>
							<div class='panel-heading'>
								<h4>
									<?php echo $MSG_HINT ?>
								</h4>
							</div>
							<div class='panel-body content'>
								<?php echo $row['hint'] ?>
							</div>
						</div>
					<?php }

					if ($pr_flag) { ?>
						<div class='panel panel-default'>
							<div class='panel-heading'>
								<h4>
									<?php echo $MSG_SOURCE ?>
								</h4>
							</div>

							<div fd="source" style='word-wrap:break-word;' pid=<?php echo $row['problem_id'] ?> class='panel-body content'>
								<?php
								$cats = explode(" ", $row['source']);
								foreach ($cats as $cat) {
									$hash_num = hexdec(substr(md5($cat), 0, 7));
									$label_theme = $color_theme[$hash_num % count($color_theme)];
									if ($label_theme == "") $label_theme = "default";
									echo "<a class='label label-$label_theme' style='display: inline-block;' href='problemset.php?search=" . urlencode(htmlentities($cat, ENT_QUOTES, 'utf-8')) . "'>" . htmlentities($cat, ENT_QUOTES, 'utf-8') . "</a>&nbsp;";
								} ?>
							</div>

						</div>
					<?php } ?>

				</div>




			</div>
		</div>
		<!-- /container -->


		<!-- Bootstrap core JavaScript
  ================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<?php include("template/$OJ_TEMPLATE/js.php"); ?>
		<script>
			function phpfm(pid) {
				//alert(pid);
				$.post("admin/phpfm.php", {
					'frame': 3,
					'pid': pid,
					'pass': ''
				}, function(data, status) {
					if (status == "success") {
						document.location.href = "admin/phpfm.php?frame=3&pid=" + pid;
					}
				});
			}

			$(document).ready(function() {
				$("#creator").load("problem-ajax.php?pid=<?php echo $id ?>");
				$(".panel-samplecase").each(function() {
					var height1 = $(this).children(".panel:first").children(".panel-body").children(".content").height();
					var height2 = $(this).children(".panel:last").children(".panel-body").children(".content").height();
					var max_height;
					if (height1 > height2) max_height = height1;
					else max_height = height2;
					$(this).children(".panel:first").children(".panel-body").children(".content").css("height", (max_height + 21) + "px");
					$(this).children(".panel:last").children(".panel-body").children(".content").css("height", (max_height + 21) + "px");
				});
			});

			function CopyToClipboard(input) {
				var textToClipboard = input;

				var success = true;
				if (window.clipboardData) { // Internet Explorer
					window.clipboardData.setData("Text", textToClipboard);
				} else {
					// create a temporary element for the execCommand method
					var forExecElement = CreateElementForExecCommand(textToClipboard);

					/* Select the contents of the element 
					(the execCommand for 'copy' method works on the selection) */
					SelectContent(forExecElement);

					var supported = true;

					// UniversalXPConnect privilege is required for clipboard access in Firefox
					try {
						if (window.netscape && netscape.security) {
							netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
						}

						// Copy the selected content to the clipboard
						// Works in Firefox and in Safari before version 5
						success = document.execCommand("copy", false, null);
					} catch (e) {
						success = false;
					}

					// remove the temporary element
					document.body.removeChild(forExecElement);
				}

				if (success) {
					alert("The text is on the clipboard, try to paste it!");
				} else {
					alert("Your browser doesn't allow clipboard access!");
				}
			}

			function CreateElementForExecCommand(textToClipboard) {
				var forExecElement = document.createElement("pre");
				// place outside the visible area
				forExecElement.style.position = "absolute";
				forExecElement.style.left = "-10000px";
				forExecElement.style.top = "-10000px";
				// write the necessary text into the element and append to the document
				forExecElement.textContent = textToClipboard;
				document.body.appendChild(forExecElement);
				// the contentEditable mode is necessary for the  execCommand method in Firefox
				forExecElement.contentEditable = true;

				return forExecElement;
			}

			function SelectContent(element) {
				// first create a range
				var rangeToSelect = document.createRange();
				rangeToSelect.selectNodeContents(element);

				// select the contents
				var selection = window.getSelection();
				selection.removeAllRanges();
				selection.addRange(rangeToSelect);
			}
		</script>

</body>

</html>