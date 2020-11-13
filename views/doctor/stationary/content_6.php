<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../../layout/sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<?php include "../profile_card.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">

						<?php include "content_tabs.php"; ?>

						<div class="card">
							<div class="card-header header-elements-inline">
								<h5 class="card-title">Мои заметки</h5>
							</div>

							<div class="card-body">
								<div class="hot-container">
									<div id="hot_comments" class="handsontable htRowHeaders htColumnHeaders">
										<div class="ht_master handsontable" style="position: relative;">
											<div class="wtHolder" style="position: relative; width: 1234px; height: 404px;">
												<div class="wtHider" style="width: 1234px; height: 404px;">
													<div class="wtSpreader" style="position: relative; top: 0px; left: 0px;">
														<table class="htCore">
															<colgroup>
																<col class="rowHeader" style="width: 50px;" />
																<col style="width: 298px;" />
																<col style="width: 305px;" />
																<col style="width: 184px;" />
																<col style="width: 213px;" />
																<col style="width: 184px;" />
															</colgroup>
															<thead>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="colHeader cornerHeader">&nbsp;</span></div>
																	</th>
																	<th class="">
																		<div class="relative"><span class="colHeader">A</span></div>
																	</th>
																	<th class="">
																		<div class="relative"><span class="colHeader">B</span></div>
																	</th>
																	<th class="">
																		<div class="relative"><span class="colHeader">C</span></div>
																	</th>
																	<th class="">
																		<div class="relative"><span class="colHeader">D</span></div>
																	</th>
																	<th class="">
																		<div class="relative"><span class="colHeader">E</span></div>
																	</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">1</span></div>
																	</th>
																	<td class="">Mercedes</td>
																	<td class="">GL500</td>
																	<td class="">2009</td>
																	<td class="">blue</td>
																	<td class="">32500</td>
																</tr>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">2</span></div>
																	</th>
																	<td class="">Chevrolet</td>
																	<td class="htCommentCell">Camaro</td>
																	<td class="">2012</td>
																	<td class="">red</td>
																	<td class="">42400</td>
																</tr>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">3</span></div>
																	</th>
																	<td class="">Dodge</td>
																	<td class="">Charger</td>
																	<td class="htCommentCell">2011</td>
																	<td class="">white</td>
																	<td class="">24900</td>
																</tr>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">4</span></div>
																	</th>
																	<td class="">Hummer</td>
																	<td class="">H3</td>
																	<td class="">2014</td>
																	<td class="">black</td>
																	<td class="">54000</td>
																</tr>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">5</span></div>
																	</th>
																	<td class="">Chevrolet</td>
																	<td class="">Tahoe</td>
																	<td class="">2009</td>
																	<td class="">purple</td>
																	<td class="">29300</td>
																</tr>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">6</span></div>
																	</th>
																	<td class="">Toyota</td>
																	<td class="">Land Cruiser</td>
																	<td class="">2007</td>
																	<td class="">lime</td>
																	<td class="">54500</td>
																</tr>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">7</span></div>
																	</th>
																	<td class="">Nissan</td>
																	<td class="">GTR</td>
																	<td class="">2009</td>
																	<td class="">cyan</td>
																	<td class="">44900</td>
																</tr>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">8</span></div>
																	</th>
																	<td class="">Porsche</td>
																	<td class="">Cayenne</td>
																	<td class="">2012</td>
																	<td class="">yellow</td>
																	<td class="">35000</td>
																</tr>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">9</span></div>
																	</th>
																	<td class="">Volkswagen</td>
																	<td class="">Touareg</td>
																	<td class="">2010</td>
																	<td class="">crimson</td>
																	<td class="">41000</td>
																</tr>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">10</span></div>
																	</th>
																	<td class="">BMW</td>
																	<td class="">X5</td>
																	<td class="">2010</td>
																	<td class="">orange</td>
																	<td class="">48800</td>
																</tr>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">11</span></div>
																	</th>
																	<td class="">Audi</td>
																	<td class="">Q7</td>
																	<td class="">2009</td>
																	<td class="">green</td>
																	<td class="">21000</td>
																</tr>
																<tr>
																	<th class="">
																		<div class="relative"><span class="rowHeader">12</span></div>
																	</th>
																	<td class="">Cadillac</td>
																	<td class="">Escalade</td>
																	<td class="">2012</td>
																	<td class="">silver</td>
																	<td class="">63900</td>
																</tr>
															</tbody>
														</table>
														<div class="htBorders">
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill corner" style="background-color: red; height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none;"></div>
															</div>
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 294px; display: none; top: 155px; left: 50px;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 62px; width: 1px; display: none; top: 155px; left: 50px;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 294px; display: none; top: 217px; left: 50px;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 63px; width: 1px; display: none; top: 155px; left: 344px;"></div>
																<div
																	class="wtBorder area corner"
																	style="background-color: rgb(137, 175, 249); height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none; top: 213px; left: 340px;"
																></div>
															</div>
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 186px; display: none; top: 155px; left: 652px;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 31px; width: 2px; display: none; top: 155px; left: 652px;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 186px; display: none; top: 185px; left: 652px;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 32px; width: 2px; display: none; top: 155px; left: 837px;"></div>
																<div
																	class="wtBorder current corner"
																	style="background-color: rgb(82, 146, 247); height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none; top: 182px; left: 834px;"
																></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="ht_clone_top handsontable" style="position: absolute; top: 0px; left: 0px; overflow: hidden; width: 1234px; height: 35px;">
											<div class="wtHolder" style="position: relative; width: 1234px; height: 51px;">
												<div class="wtHider" style="width: 1234px;">
													<div class="wtSpreader" style="position: relative; left: 0px;">
														<table class="htCore">
															<colgroup>
																<col class="rowHeader" style="width: 50px;" />
																<col style="width: 298px;" />
																<col style="width: 305px;" />
																<col style="width: 184px;" />
																<col style="width: 213px;" />
																<col style="width: 184px;" />
															</colgroup>
															<thead>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="colHeader cornerHeader">&nbsp;</span></div>
																	</th>
																	<th class="">
																		<div class="relative"><span class="colHeader">A</span></div>
																	</th>
																	<th class="">
																		<div class="relative"><span class="colHeader">B</span></div>
																	</th>
																	<th class="">
																		<div class="relative"><span class="colHeader">C</span></div>
																	</th>
																	<th class="">
																		<div class="relative"><span class="colHeader">D</span></div>
																	</th>
																	<th class="">
																		<div class="relative"><span class="colHeader">E</span></div>
																	</th>
																</tr>
															</thead>
															<tbody></tbody>
														</table>
														<div class="htBorders">
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill corner" style="background-color: red; height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none;"></div>
															</div>
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area corner" style="background-color: rgb(137, 175, 249); height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none;"></div>
															</div>
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current corner" style="background-color: rgb(82, 146, 247); height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none;"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="ht_clone_left handsontable" style="position: absolute; top: 0px; left: 0px; overflow: hidden; height: 404px; width: 54px;">
											<div class="wtHolder" style="position: relative; height: 404px; width: 70px;">
												<div class="wtHider" style="height: 404px;">
													<div class="wtSpreader" style="position: relative; top: 0px;">
														<table class="htCore">
															<colgroup>
																<col class="rowHeader" style="width: 50px;" />
															</colgroup>
															<thead>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="colHeader cornerHeader">&nbsp;</span></div>
																	</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">1</span></div>
																	</th>
																</tr>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">2</span></div>
																	</th>
																</tr>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">3</span></div>
																	</th>
																</tr>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">4</span></div>
																	</th>
																</tr>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">5</span></div>
																	</th>
																</tr>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">6</span></div>
																	</th>
																</tr>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">7</span></div>
																	</th>
																</tr>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">8</span></div>
																	</th>
																</tr>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">9</span></div>
																	</th>
																</tr>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">10</span></div>
																	</th>
																</tr>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">11</span></div>
																	</th>
																</tr>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="rowHeader">12</span></div>
																	</th>
																</tr>
															</tbody>
														</table>
														<div class="htBorders">
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill corner" style="background-color: red; height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none;"></div>
															</div>
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area corner" style="background-color: rgb(137, 175, 249); height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none;"></div>
															</div>
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current corner" style="background-color: rgb(82, 146, 247); height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none;"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="ht_clone_top_left_corner handsontable" style="position: absolute; top: 0px; left: 0px; overflow: hidden; height: 35px; width: 54px;">
											<div class="wtHolder" style="position: relative;">
												<div class="wtHider">
													<div class="wtSpreader" style="position: relative;">
														<table class="htCore">
															<colgroup>
																<col class="rowHeader" style="width: 50px;" />
															</colgroup>
															<thead>
																<tr>
																	<th class="" style="height: 30px;">
																		<div class="relative"><span class="colHeader cornerHeader">&nbsp;</span></div>
																	</th>
																</tr>
															</thead>
															<tbody></tbody>
														</table>
														<div class="htBorders">
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill" style="background-color: red; height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder fill corner" style="background-color: red; height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none;"></div>
															</div>
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area" style="background-color: rgb(137, 175, 249); height: 1px; width: 1px; display: none;"></div>
																<div class="wtBorder area corner" style="background-color: rgb(137, 175, 249); height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none;"></div>
															</div>
															<div style="position: absolute; top: 0px; left: 0px;">
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current" style="background-color: rgb(82, 146, 247); height: 2px; width: 2px; display: none;"></div>
																<div class="wtBorder current corner" style="background-color: rgb(82, 146, 247); height: 5px; width: 5px; border: 2px solid rgb(255, 255, 255); display: none;"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="handsontableInputHolder" style="top: 62px; left: 344px; display: none;">
											<textarea
												class="handsontableInput"
												style="
													width: 880px;
													height: 31px;
													font-size: 13px;
													font-family: Roboto, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
													background-color: rgb(255, 255, 255);
													resize: none;
													min-width: 297px;
													max-width: 880px;
													overflow-y: hidden;
												"
											></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>

				    </div>

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
